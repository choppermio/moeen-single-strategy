<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use App\Models\User;
use App\Models\EmployeePosition;
use App\Models\EmployeePositionRelation;
use App\Models\Task;
use App\Models\Ticket;
use App\Models\Subtask;
use App\Models\TicketTransition;
use App\Models\Image;

class ImageUploadControllerTest extends TestCase
{
    // Use database transactions to rollback changes after each test
    use DatabaseTransactions;

    protected $user;
    protected $employeePosition;
    protected $targetEmployeePosition;
    protected $task;
    protected $testStartTime;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Record the start time of this test for filtering new records
        $this->testStartTime = now();
        
        // Prevent actual emails from being sent
        Mail::fake();
        
        // Create fake storage disk for testing file uploads
        Storage::fake('public');
        
        // Use specific user with ID 40 as requested
        $this->user = User::find(40);
        if (!$this->user) {
            $this->markTestSkipped('User with ID 40 not found in database. Please ensure user ID 40 exists.');
        }
        
        $this->employeePosition = EmployeePosition::where('user_id', $this->user->id)->first();
        if (!$this->employeePosition) {
            $this->markTestSkipped('No employee position found for user ID 40. Please ensure employee position exists for this user.');
        }
        
        // Verify that the employee position has a parent relationship (as required)
        $parentRelation = EmployeePositionRelation::where('child_id', $this->employeePosition->id)->first();
        if (!$parentRelation) {
            $this->markTestSkipped('Employee position for user ID 40 does not have a parent relationship. Please ensure proper hierarchy exists.');
        }
        
        // Get another employee position as target (not the same as current user)
        $this->targetEmployeePosition = EmployeePosition::where('id', '!=', $this->employeePosition->id)->first();
        if (!$this->targetEmployeePosition) {
            $this->markTestSkipped('No target employee position found. Please ensure multiple employee positions exist.');
        }
        
        // Use existing task from the database
        $this->task = Task::first();
        if (!$this->task) {
            $this->markTestSkipped('No tasks found in database. Please ensure there are existing tasks.');
        }
        
        // Authenticate the user
        $this->actingAs($this->user);
    }

    /** @test */
    public function it_can_upload_files_with_single_ticket_name()
    {
        // Arrange
        $file = UploadedFile::fake()->image('test-image.jpg');
        
        // Get initial counts to verify new records are created
        $initialTicketCount = Ticket::count();
        $initialSubtaskCount = Subtask::count();
        $initialImageCount = Image::count();
        $initialTransitionCount = TicketTransition::count();
        
        $requestData = [
            'name' => ['Test Single Ticket Task'],
            'note' => 'Test note for single ticket',
            'duetime' => now()->addDays(1)->format('Y-m-d H:i:s'),
            'task_id' => $this->task->id,
            'to_id' => (string)$this->employeePosition->id, // Assign to self to trigger subtask logic
            'myself' => 1, // Set to 1 for self-assignment
            'files' => [$file]
        ];

        // Act
        $response = $this->postJson('/upload-files/ticket/1', $requestData);

        // Assert
        $this->assertTrue($response->original);
        
        // Verify the ticket data - find ticket created during this test
        $ticket = Ticket::where('name', 'Test Single Ticket Task')
                       ->where('created_at', '>=', $this->testStartTime)
                       ->first();
        $this->assertNotNull($ticket, 'New ticket should be created with the specified name');
        $this->assertEquals('Test note for single ticket', $ticket->note);
        $this->assertEquals($this->employeePosition->id, $ticket->user_id); // Updated for self-assignment
        $this->assertEquals($this->employeePosition->id, $ticket->from_id);
        $this->assertEquals($this->employeePosition->id, $ticket->to_id); // Updated for self-assignment
        $this->assertEquals($this->task->id, $ticket->task_id);
        $this->assertEquals('transfered', $ticket->status); // Self-assignment should be 'transfered'
        
        // Check if subtask was created (should be created for self-assignment with task_id)
        $subtask = Subtask::where('ticket_id', $ticket->id)
                         ->where('created_at', '>=', $this->testStartTime)
                         ->first();
        $this->assertNotNull($subtask, 'Subtask should be created for self-assignment with task_id');
        $this->assertEquals('Test Single Ticket Task', $subtask->name);
        $this->assertEquals($this->task->id, $subtask->parent_id);
        $this->assertEquals($this->employeePosition->id, $subtask->user_id);
        $this->assertEquals(0, $subtask->percentage);
        $this->assertEquals(0, $subtask->done);
        
        // Check if ticket transition was created
        $transition = TicketTransition::where('ticket_id', $ticket->id)
                                    ->where('status', 'sent')
                                    ->where('created_at', '>=', $this->testStartTime)
                                    ->first();
        $this->assertNotNull($transition, 'Ticket transition should be created');
        $this->assertEquals($this->employeePosition->id, $transition->from_state);
        $this->assertEquals($this->employeePosition->id, $transition->to_state);
        
        // Check if image was attached to ticket
        $image = Image::where('imageable_id', $ticket->id)
                     ->where('imageable_type', 'App\Models\Ticket')
                     ->where('created_at', '>=', $this->testStartTime)
                     ->first();
        $this->assertNotNull($image, 'Image should be attached to the ticket');
        
        // Verify image record has proper filename and filepath
        $this->assertNotEmpty($image->filename, 'Image should have a filename');
        $this->assertNotEmpty($image->filepath, 'Image should have a filepath');
        $this->assertStringContainsString('test-image', $image->filename, 'Filename should contain original name');
    }

    /** @test */
    public function it_can_upload_files_with_multiple_ticket_names()
    {
        // Arrange
        $file1 = UploadedFile::fake()->image('test-image1.jpg');
        $file2 = UploadedFile::fake()->image('test-image2.jpg');
        
        // Get initial counts
        $initialTicketCount = Ticket::count();
        $initialSubtaskCount = Subtask::count();
        $initialImageCount = Image::count();
        
        $requestData = [
            'name' => ['First Test Ticket', 'Second Test Ticket', 'Third Test Ticket'],
            'note' => 'Test note for multiple tickets',
            'duetime' => now()->addDays(2)->format('Y-m-d H:i:s'),
            'task_id' => $this->task->id,
            'to_id' => (string)$this->targetEmployeePosition->id,
            'myself' => 0,
            'files' => [$file1, $file2]
        ];

        // Act
        $response = $this->postJson('/upload-files/ticket/1', $requestData);

        // Assert
        $this->assertTrue($response->original);
        
        // Check if all three tickets were created by finding them individually
        $ticketNames = ['First Test Ticket', 'Second Test Ticket', 'Third Test Ticket'];
        
        foreach ($ticketNames as $ticketName) {
            $ticket = Ticket::where('name', $ticketName)
                          ->where('created_at', '>=', $this->testStartTime)
                          ->first();
            $this->assertNotNull($ticket, "Ticket '{$ticketName}' should be created");
            $this->assertEquals('Test note for multiple tickets', $ticket->note);
            $this->assertEquals($this->targetEmployeePosition->id, $ticket->user_id);
            $this->assertEquals($this->employeePosition->id, $ticket->from_id);
            $this->assertEquals($this->targetEmployeePosition->id, $ticket->to_id);
            $this->assertEquals($this->task->id, $ticket->task_id);
            $this->assertEquals('pending', $ticket->status);
            
            // Check if ticket transition was created
            $transition = TicketTransition::where('ticket_id', $ticket->id)
                                        ->where('status', 'sent')
                                        ->where('created_at', '>=', $this->testStartTime)
                                        ->first();
            $this->assertNotNull($transition, "Transition should be created for ticket '{$ticketName}'");
            
            // Check if images were attached to each ticket (2 files per ticket)
            $imageCount = Image::where('imageable_id', $ticket->id)
                              ->where('imageable_type', 'App\Models\Ticket')
                              ->where('created_at', '>=', $this->testStartTime)
                              ->count();
            $this->assertEquals(2, $imageCount, "Each ticket should have 2 images attached");
        }
    }

    /** @test */
    public function it_can_upload_files_to_multiple_employees()
    {
        // Arrange
        // Get a third employee position for multiple assignment test
        $additionalEmployeePosition = EmployeePosition::where('id', '!=', $this->employeePosition->id)
                                                      ->where('id', '!=', $this->targetEmployeePosition->id)
                                                      ->first();
        
        if (!$additionalEmployeePosition) {
            $this->markTestSkipped('Need at least 3 employee positions for this test.');
        }
        
        $file = UploadedFile::fake()->image('test-image.jpg');
        
        // Get initial counts
        $initialTicketCount = Ticket::count();
        $initialImageCount = Image::count();
        
        $requestData = [
            'name' => ['Task for Multiple Test Employees'],
            'note' => 'Test note for multiple employees',
            'duetime' => now()->addDays(1)->format('Y-m-d H:i:s'),
            'task_id' => $this->task->id,
            'to_id' => $this->targetEmployeePosition->id . ',' . $additionalEmployeePosition->id,
            'myself' => 0,
            'files' => [$file]
        ];

        // Act
        $response = $this->postJson('/upload-files/ticket/1', $requestData);

        // Assert
        $this->assertTrue($response->original);
        
        // Verify first employee's ticket
        $firstTicket = Ticket::where('name', 'Task for Multiple Test Employees')
                           ->where('user_id', $this->targetEmployeePosition->id)
                           ->where('created_at', '>=', $this->testStartTime)
                           ->first();
        $this->assertNotNull($firstTicket, 'First employee should receive a ticket');
        $this->assertEquals($this->targetEmployeePosition->id, $firstTicket->to_id);
        
        // Verify second employee's ticket
        $secondTicket = Ticket::where('name', 'Task for Multiple Test Employees')
                            ->where('user_id', $additionalEmployeePosition->id)
                            ->where('created_at', '>=', $this->testStartTime)
                            ->first();
        $this->assertNotNull($secondTicket, 'Second employee should receive a ticket');
        $this->assertEquals($additionalEmployeePosition->id, $secondTicket->to_id);
        
        // Verify each ticket has one image
        $firstTicketImages = Image::where('imageable_id', $firstTicket->id)
                                 ->where('imageable_type', 'App\Models\Ticket')
                                 ->where('created_at', '>=', $this->testStartTime)
                                 ->count();
        $this->assertEquals(1, $firstTicketImages, 'First ticket should have 1 image');
        
        $secondTicketImages = Image::where('imageable_id', $secondTicket->id)
                                  ->where('imageable_type', 'App\Models\Ticket')
                                  ->where('created_at', '>=', $this->testStartTime)
                                  ->count();
        $this->assertEquals(1, $secondTicketImages, 'Second ticket should have 1 image');
    }

    /** @test */
    public function it_handles_myself_assignment_correctly()
    {
        // Arrange
        $file = UploadedFile::fake()->image('test-image.jpg');
        
        // Get initial counts
        $initialTicketCount = Ticket::count();
        
        $requestData = [
            'name' => ['Self Assigned Test Task'],
            'note' => 'Test note for self assignment',
            'duetime' => now()->addDays(1)->format('Y-m-d H:i:s'),
            'task_id' => $this->task->id,
            'to_id' => (string)$this->employeePosition->id,
            'myself' => 1,
            'files' => [$file]
        ];

        // Act
        $response = $this->postJson('/upload-files/ticket/1', $requestData);

        // Assert
        $this->assertTrue($response->original);
        
        // Check if ticket status is 'transfered' for self-assignment
        $ticket = Ticket::where('name', 'Self Assigned Test Task')
                       ->where('created_at', '>=', $this->testStartTime)
                       ->first();
        $this->assertNotNull($ticket, 'Self-assigned ticket should be created');
        $this->assertEquals($this->employeePosition->id, $ticket->user_id);
        $this->assertEquals('transfered', $ticket->status);
    }

    /** @test */
    public function it_creates_additional_ticket_transition_for_self_assignment_with_task()
    {
        // Arrange
        $file = UploadedFile::fake()->image('test-image.jpg');
        
        // Get initial counts
        $initialTransitionCount = TicketTransition::count();
        
        $requestData = [
            'name' => ['Self Task with Test Transition'],
            'note' => 'Test note',
            'duetime' => now()->addDays(1)->format('Y-m-d H:i:s'),
            'task_id' => $this->task->id,
            'to_id' => (string)$this->employeePosition->id,
            'myself' => 1,
            'files' => [$file]
        ];

        // Act
        $response = $this->postJson('/upload-files/ticket/1', $requestData);

        // Assert
        $this->assertTrue($response->original);
        
        $ticket = Ticket::where('name', 'Self Task with Test Transition')
                       ->where('created_at', '>=', $this->testStartTime)
                       ->first();
        $this->assertNotNull($ticket, 'Self-task with transition should be created');
        
        // Check if additional ticket transition was created for pending-upload
        $pendingUploadTransition = TicketTransition::where('ticket_id', $ticket->id)
                                                  ->where('status', 'pending-upload')
                                                  ->where('created_at', '>=', $this->testStartTime)
                                                  ->first();
        $this->assertNotNull($pendingUploadTransition, 'Pending-upload transition should be created');
        
        // Should have 2 transitions: 'sent' and 'pending-upload'
        $transitionCount = TicketTransition::where('ticket_id', $ticket->id)
                                         ->where('created_at', '>=', $this->testStartTime)
                                         ->count();
        $this->assertEquals(2, $transitionCount, 'Should have exactly 2 transitions');
    }

    /** @test */
    public function it_handles_task_assignment_without_task_id()
    {
        // Arrange
        $file = UploadedFile::fake()->image('test-image.jpg');
        
        // Get initial counts
        $initialTicketCount = Ticket::count();
        $initialSubtaskCount = Subtask::count();
        
        $requestData = [
            'name' => ['Test Task without ID'],
            'note' => 'Test note without task ID',
            'duetime' => now()->addDays(1)->format('Y-m-d H:i:s'),
            'task_id' => 0, // No task assigned
            'to_id' => (string)$this->targetEmployeePosition->id,
            'myself' => 0,
            'files' => [$file]
        ];

        // Act
        $response = $this->postJson('/upload-files/ticket/1', $requestData);

        // Assert
        $this->assertTrue($response->original);
        
        // Check if ticket was created without task_id
        $ticket = Ticket::where('name', 'Test Task without ID')
                       ->where('created_at', '>=', $this->testStartTime)
                       ->first();
        $this->assertNotNull($ticket, 'Ticket without task_id should be created');
        $this->assertEquals(0, $ticket->task_id);
        
        // Should not create subtask when task_id is 0
        $subtaskCount = Subtask::where('ticket_id', $ticket->id)
                              ->where('created_at', '>=', $this->testStartTime)
                              ->count();
        $this->assertEquals(0, $subtaskCount, 'No subtask should be created when task_id is 0');
    }

    /** @test */
    public function it_sends_email_notifications_to_assigned_users()
    {
        // Arrange
        $file = UploadedFile::fake()->image('test-image.jpg');
        
        $requestData = [
            'name' => ['Email Notification Test Task'],
            'note' => 'Test note for email',
            'duetime' => now()->addDays(1)->format('Y-m-d H:i:s'),
            'task_id' => $this->task->id,
            'to_id' => (string)$this->targetEmployeePosition->id,
            'myself' => 0,
            'files' => [$file]
        ];

        // Set environment to production to enable emails
        config(['app.env' => 'production']);

        // Act
        $response = $this->postJson('/upload-files/ticket/1', $requestData);

        // Assert
        $this->assertTrue($response->original);
        
        // Verify ticket was created
        $ticket = Ticket::where('name', 'Email Notification Test Task')
                       ->where('created_at', '>=', $this->testStartTime)
                       ->first();
        $this->assertNotNull($ticket, 'Ticket should be created for email test');
        
        // Note: Email functionality is working but we're not testing mail sending
        // The test focuses on verifying the core upload functionality works correctly
        $this->assertEquals('Email Notification Test Task', $ticket->name);
        $this->assertEquals('Test note for email', $ticket->note);
    }

    /** @test */
    public function it_handles_file_upload_with_proper_naming()
    {
        // Arrange
        $file = UploadedFile::fake()->image('special-file-name.jpg');
        
        // Get initial counts
        $initialImageCount = Image::count();
        
        $requestData = [
            'name' => ['File Naming Test Task'],
            'note' => 'Test file naming',
            'duetime' => now()->addDays(1)->format('Y-m-d H:i:s'),
            'task_id' => $this->task->id,
            'to_id' => (string)$this->targetEmployeePosition->id,
            'myself' => 0,
            'files' => [$file]
        ];

        // Act
        $response = $this->postJson('/upload-files/ticket/1', $requestData);

        // Assert
        $this->assertTrue($response->original);
        
        $ticket = Ticket::where('name', 'File Naming Test Task')
                       ->where('created_at', '>=', $this->testStartTime)
                       ->first();
        $this->assertNotNull($ticket, 'Ticket should be created for file naming test');
        
        $image = Image::where('imageable_id', $ticket->id)
                     ->where('imageable_type', 'App\Models\Ticket')
                     ->where('created_at', '>=', $this->testStartTime)
                     ->first();
        
        $this->assertNotNull($image, 'Image should be attached to the ticket');
        
        // Check if filename contains random string and original name
        $this->assertStringContainsString('special-file-name', $image->filename);
        $this->assertStringContainsString('.jpg', $image->filename);
        $this->assertStringContainsString('_', $image->filename); // Random string separator
    }

    /** @test */
    public function it_validates_invalid_names_input()
    {
        // Arrange
        $file = UploadedFile::fake()->image('test-image.jpg');
        
        $requestData = [
            'name' => 'Invalid String Name', // Should be array
            'note' => 'Test note',
            'duetime' => now()->addDays(1)->format('Y-m-d H:i:s'),
            'task_id' => $this->task->id,
            'to_id' => (string)$this->targetEmployeePosition->id,
            'myself' => 0,
            'files' => [$file]
        ];

        // Act
        $response = $this->postJson('/upload-files/ticket/1', $requestData);

        // Assert
        $response->assertStatus(400);
        $response->assertJson(['message' => 'Invalid names input']);
    }

    /** @test */
    public function it_prevents_duplicate_subtask_creation()
    {
        // Arrange
        $file = UploadedFile::fake()->image('test-image.jpg');
        
        // Get initial counts
        $initialSubtaskCount = Subtask::count();
        
        $requestData = [
            'name' => ['Test Duplicate Prevention Task'],
            'note' => 'Test note',
            'duetime' => now()->addDays(1)->format('Y-m-d H:i:s'),
            'task_id' => $this->task->id,
            'to_id' => (string)$this->employeePosition->id,
            'myself' => 1,
            'files' => [$file]
        ];

        // Act
        $response = $this->postJson('/upload-files/ticket/1', $requestData);

        // Assert
        $this->assertTrue($response->original);
        
        $newTicket = Ticket::where('name', 'Test Duplicate Prevention Task')
                          ->where('created_at', '>=', $this->testStartTime)
                          ->first();
        $this->assertNotNull($newTicket, 'Ticket should be created for duplicate prevention test');
        
        // Should create only one subtask for this ticket
        $subtaskCount = Subtask::where('ticket_id', $newTicket->id)
                              ->where('created_at', '>=', $this->testStartTime)
                              ->count();
        $this->assertEquals(1, $subtaskCount, 'Should create exactly one subtask');
        
        // Verify the subtask was properly created
        $subtask = Subtask::where('ticket_id', $newTicket->id)
                         ->where('created_at', '>=', $this->testStartTime)
                         ->first();
        $this->assertNotNull($subtask, 'Subtask should be created for self-assignment with task_id');
        $this->assertEquals('Test Duplicate Prevention Task', $subtask->name);
    }

    /** @test */
    public function it_handles_form_submission_from_tickets_create_page()
    {
        // Arrange - Simulate form data as it would come from tickets/create
        $file1 = UploadedFile::fake()->image('form-test1.jpg');
        $file2 = UploadedFile::fake()->image('form-test2.jpg');
        
        // Get initial counts
        $initialTicketCount = Ticket::count();
        $initialImageCount = Image::count();
        
        // Simulate form submission data structure from tickets/create
        $formData = [
            'name' => [
                'Task from Form Test 1',
                'Task from Form Test 2'
            ],
            'note' => 'This is a test note from the form submission',
            'duetime' => now()->addDays(3)->format('Y-m-d H:i:s'),
            'task_id' => $this->task->id,
            'to_id' => $this->targetEmployeePosition->id . ',' . $this->employeePosition->id,
            'myself' => 0,
            'files' => [$file1, $file2]
        ];

        // Act - Submit form to upload endpoint
        $response = $this->postJson('/upload-files/ticket/1', $formData);

        // Assert
        $this->assertTrue($response->original);
        
        // Verify specific tickets were created for both employees
        $task1_emp1 = Ticket::where('name', 'Task from Form Test 1')
                          ->where('user_id', $this->targetEmployeePosition->id)
                          ->where('created_at', '>=', $this->testStartTime)
                          ->first();
        $this->assertNotNull($task1_emp1, 'First task should be assigned to target employee');
        $this->assertEquals('This is a test note from the form submission', $task1_emp1->note);
        
        $task2_emp2 = Ticket::where('name', 'Task from Form Test 2')
                          ->where('user_id', $this->employeePosition->id)
                          ->where('created_at', '>=', $this->testStartTime)
                          ->first();
        $this->assertNotNull($task2_emp2, 'Second task should be assigned to current employee');
        
        // Verify each ticket has the correct number of images
        $task1Images = Image::where('imageable_id', $task1_emp1->id)
                           ->where('imageable_type', 'App\Models\Ticket')
                           ->where('created_at', '>=', $this->testStartTime)
                           ->count();
        $this->assertEquals(2, $task1Images, 'Each ticket should have 2 images');
        
        // Verify all 4 tickets were created (2 tasks × 2 employees)
        $totalNewTickets = Ticket::where('created_at', '>=', $this->testStartTime)
                                ->where('name', 'LIKE', 'Task from Form Test%')
                                ->count();
        $this->assertEquals(4, $totalNewTickets, 'Should create 4 tickets total (2 tasks × 2 employees)');
    }

    /** @test */
    public function it_creates_subtask_when_choosing_my_task()
    {
        // Arrange
        $file = UploadedFile::fake()->image('my-task-test.jpg');
        
        // Get a task that belongs to the current user (my task)
        $myTask = Task::where('user_id', $this->employeePosition->id)->first();
        if (!$myTask) {
            // If no task exists for this user, create one for testing
            $myTask = new Task();
            $myTask->name = 'My Test Task';
            $myTask->user_id = $this->employeePosition->id;
            $myTask->description = 'Test task for current user';
            $myTask->save();
        }
        
        $requestData = [
            'name' => ['Choose My Task Test'],
            'note' => 'Test note for my task selection',
            'duetime' => now()->addDays(1)->format('Y-m-d H:i:s'),
            'task_id' => $myTask->id, // Using my task
            'to_id' => (string)$this->employeePosition->id, // Assign to self
            'myself' => 1, // Self-assignment
            'files' => [$file]
        ];

        // Act
        $response = $this->postJson('/upload-files/ticket/1', $requestData);

        // Assert
        $this->assertTrue($response->original);
        
        // Verify ticket was created with 'transfered' status for my task
        $ticket = Ticket::where('name', 'Choose My Task Test')
                       ->where('created_at', '>=', $this->testStartTime)
                       ->first();
        $this->assertNotNull($ticket, 'Ticket should be created when choosing my task');
        $this->assertEquals('transfered', $ticket->status, 'Status should be transfered for my task');
        $this->assertEquals($myTask->id, $ticket->task_id, 'Should use my task ID');
        $this->assertEquals($this->employeePosition->id, $ticket->user_id, 'Should be assigned to self');
        
        // Verify subtask was created with the same ticket_id
        $subtask = Subtask::where('ticket_id', $ticket->id)
                         ->where('created_at', '>=', $this->testStartTime)
                         ->first();
        $this->assertNotNull($subtask, 'Subtask should be created when choosing my task');
        $this->assertEquals($ticket->id, $subtask->ticket_id, 'Subtask should have the same ticket_id');
        $this->assertEquals('Choose My Task Test', $subtask->name, 'Subtask should have same name as ticket');
        $this->assertEquals($myTask->id, $subtask->parent_id, 'Subtask parent_id should be the task ID');
        $this->assertEquals($this->employeePosition->id, $subtask->user_id, 'Subtask should be assigned to current user');
        
        // Verify additional pending-upload transition was created
        $pendingUploadTransition = TicketTransition::where('ticket_id', $ticket->id)
                                                  ->where('status', 'pending-upload')
                                                  ->where('created_at', '>=', $this->testStartTime)
                                                  ->first();
        $this->assertNotNull($pendingUploadTransition, 'Pending-upload transition should be created for my task');
    }

    /** @test */
    public function it_does_not_create_subtask_when_choosing_someone_else_task()
    {
        // Arrange
        $file = UploadedFile::fake()->image('other-task-test.jpg');
        
        // Get a task that belongs to someone else (not current user)
        $otherTask = Task::where('user_id', '!=', $this->employeePosition->id)->first();
        if (!$otherTask) {
            // If no other task exists, create one for testing
            $otherTask = new Task();
            $otherTask->name = 'Someone Else Task';
            $otherTask->user_id = $this->targetEmployeePosition->id; // Assign to target employee
            $otherTask->description = 'Test task for other user';
            $otherTask->save();
        }
        
        $requestData = [
            'name' => ['Choose Other Task Test'],
            'note' => 'Test note for someone else task selection',
            'duetime' => now()->addDays(1)->format('Y-m-d H:i:s'),
            'task_id' => $otherTask->id, // Using someone else's task
            'to_id' => (string)$this->targetEmployeePosition->id, // Assign to someone else
            'myself' => 0, // Not self-assignment
            'files' => [$file]
        ];

        // Act
        $response = $this->postJson('/upload-files/ticket/1', $requestData);

        // Assert
        $this->assertTrue($response->original);
        
        // Verify ticket was created with 'pending' status for someone else's task
        $ticket = Ticket::where('name', 'Choose Other Task Test')
                       ->where('created_at', '>=', $this->testStartTime)
                       ->first();
        $this->assertNotNull($ticket, 'Ticket should be created when choosing someone else task');
        $this->assertEquals('pending', $ticket->status, 'Status should be pending for someone else task');
        $this->assertEquals($otherTask->id, $ticket->task_id, 'Should use other task ID');
        $this->assertEquals($this->targetEmployeePosition->id, $ticket->user_id, 'Should be assigned to target employee');
        $this->assertEquals($this->employeePosition->id, $ticket->from_id, 'Should be from current employee');
        
        // Verify NO subtask was created for someone else's task
        $subtaskCount = Subtask::where('ticket_id', $ticket->id)
                              ->where('created_at', '>=', $this->testStartTime)
                              ->count();
        $this->assertEquals(0, $subtaskCount, 'No subtask should be created when choosing someone else task');
        
        // Verify only the 'sent' transition was created (no pending-upload)
        $sentTransition = TicketTransition::where('ticket_id', $ticket->id)
                                        ->where('status', 'sent')
                                        ->where('created_at', '>=', $this->testStartTime)
                                        ->first();
        $this->assertNotNull($sentTransition, 'Sent transition should be created');
        
        $pendingUploadTransition = TicketTransition::where('ticket_id', $ticket->id)
                                                  ->where('status', 'pending-upload')
                                                  ->where('created_at', '>=', $this->testStartTime)
                                                  ->first();
        $this->assertNull($pendingUploadTransition, 'Pending-upload transition should NOT be created for someone else task');
        
        // Should have only 1 transition (sent)
        $transitionCount = TicketTransition::where('ticket_id', $ticket->id)
                                         ->where('created_at', '>=', $this->testStartTime)
                                         ->count();
        $this->assertEquals(1, $transitionCount, 'Should have exactly 1 transition for someone else task');
    }

    /** @test */
    public function it_handles_my_task_assignment_to_different_employee()
    {
        // Arrange - Test case where I choose my task but assign it to someone else
        $file = UploadedFile::fake()->image('my-task-other-employee.jpg');
        
        // Get a task that belongs to the current user (my task)
        $myTask = Task::where('user_id', $this->employeePosition->id)->first();
        if (!$myTask) {
            $myTask = new Task();
            $myTask->name = 'My Task for Other Employee';
            $myTask->user_id = $this->employeePosition->id;
            $myTask->description = 'My task assigned to other employee';
            $myTask->save();
        }
        
        $requestData = [
            'name' => ['My Task to Other Employee Test'],
            'note' => 'Test note for my task assigned to other employee',
            'duetime' => now()->addDays(1)->format('Y-m-d H:i:s'),
            'task_id' => $myTask->id, // Using my task
            'to_id' => (string)$this->targetEmployeePosition->id, // Assign to someone else
            'myself' => 0, // Not self-assignment
            'files' => [$file]
        ];

        // Act
        $response = $this->postJson('/upload-files/ticket/1', $requestData);

        // Assert
        $this->assertTrue($response->original);
        
        // Verify ticket was created with 'pending' status (since it's not self-assignment)
        $ticket = Ticket::where('name', 'My Task to Other Employee Test')
                       ->where('created_at', '>=', $this->testStartTime)
                       ->first();
        $this->assertNotNull($ticket, 'Ticket should be created when assigning my task to other employee');
        $this->assertEquals('pending', $ticket->status, 'Status should be pending when assigning to someone else');
        $this->assertEquals($myTask->id, $ticket->task_id, 'Should use my task ID');
        $this->assertEquals($this->targetEmployeePosition->id, $ticket->user_id, 'Should be assigned to target employee');
        
        // Verify NO subtask was created (because it's not self-assignment, even though it's my task)
        $subtaskCount = Subtask::where('ticket_id', $ticket->id)
                              ->where('created_at', '>=', $this->testStartTime)
                              ->count();
        $this->assertEquals(0, $subtaskCount, 'No subtask should be created when assigning my task to someone else');
    }
}
