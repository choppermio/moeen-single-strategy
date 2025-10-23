# Task Pause and Attachments Feature

## Overview
This document describes the implementation of two new features for tasks in the newstrategy.blade.php page:
1. **Pause/Unpause Task Button** - Allows toggling task visibility status
2. **Attachments Button** - Shows modal with existing attachments and allows uploading new ones

## Database Changes

### Migration
- **File**: `database/migrations/2025_10_23_091922_add_hidden_column_to_tasks_table.php`
- **Column Added**: `hidden` (TINYINT, default: 0)
- **Purpose**: Tracks whether a task is paused (1) or active (0)

## Model Updates

### Task Model (`app/Models/Task.php`)
- Added `HasMedia` interface implementation
- Added `InteractsWithMedia` trait for file attachments
- Added `'hidden'` to fillable array

## Controller Methods

### TaskController (`app/Http/Controllers/TaskController.php`)

#### toggleHidden(Request $request)
- **Route**: POST `/task/toggle-hidden`
- **Purpose**: Toggle task's hidden status between 0 and 1
- **Parameters**: 
  - `task_id` - ID of the task
  - `hidden` - New hidden value (0 or 1)
- **Returns**: JSON response with success status and message

#### getAttachments($taskId)
- **Route**: GET `/task/{id}/attachments`
- **Purpose**: Retrieve all media attachments for a specific task
- **Returns**: JSON response with attachments array

## Routes Added

```php
// Task pause/unpause and attachments
Route::post('/task/toggle-hidden', [TaskController::class, 'toggleHidden'])->name('task.toggleHidden');
Route::get('/task/{id}/attachments', [TaskController::class, 'getAttachments'])->name('task.getAttachments');
```

## View Updates

### newstrategy.blade.php

#### New Buttons Added
1. **Pause/Unpause Button**
   - Icon: fa-pause (when active) / fa-play (when paused)
   - Color: btn-warning (active) / btn-success (paused)
   - Displays "متوقف مؤقتاً" badge when task is paused

2. **Attachments Button**
   - Icon: fa-paperclip
   - Color: btn-info
   - Opens modal to view and upload attachments

#### New Modal: Attachments Modal
- **ID**: `attachmentsModal`
- **Features**:
  - Display existing attachments as clickable links
  - File upload form with multiple file support
  - Uses existing `/upload-files/Task/{id}` route
  - Auto-refreshes attachment list after upload

## JavaScript Functionality

### Toggle Hidden (Pause/Unpause)
```javascript
$('.toggle-hidden-btn').on('click', function (e) {
    // Sends AJAX request to toggle hidden status
    // Updates button appearance dynamically
    // Shows/hides "متوقف مؤقتاً" badge
});
```

### View Attachments
```javascript
$('.view-attachments-btn').on('click', function () {
    // Opens modal
    // Loads attachments via AJAX
    // Displays list of files with download links
});
```

### Upload Attachments
```javascript
$('#uploadAttachmentsForm').on('submit', function (e) {
    // Uploads files using FormData
    // Uses existing ImageUploadController
    // Refreshes attachment list on success
});
```

## Features

### Pause/Unpause Task
- ✅ Changes hidden column value (0 or 1)
- ✅ Visual feedback with icon change (pause ↔ play)
- ✅ Button color change (warning ↔ success)
- ✅ Shows "متوقف مؤقتاً" badge when paused
- ✅ Arabic success messages
- ✅ Persists across page refreshes

### Task Attachments
- ✅ View existing attachments in modal
- ✅ Download attachments (click to open in new tab)
- ✅ Upload multiple files at once
- ✅ Uses Spatie Media Library
- ✅ Auto-refresh after upload
- ✅ Loading spinners for better UX
- ✅ Error handling with user-friendly messages

## Usage

### For Users
1. **To Pause a Task**: Click the yellow pause button next to the task
2. **To Resume a Task**: Click the green play button next to the paused task
3. **To View Attachments**: Click the "المرفقات" (Attachments) button
4. **To Upload Files**: In the modal, select files and click "رفع الملفات"

### For Developers
- Hidden tasks can be filtered using `where('hidden', 0)` in queries
- Attachments are stored using Spatie Media Library
- All AJAX requests include CSRF token protection
- Bootstrap 4 modals are used for UI

## Testing Checklist

- [ ] Pause button changes task hidden status to 1
- [ ] Unpause button changes task hidden status to 0
- [ ] Badge "متوقف مؤقتاً" appears when paused
- [ ] Attachments modal opens and loads existing files
- [ ] File upload works for single and multiple files
- [ ] Attachment list refreshes after upload
- [ ] Error messages display correctly
- [ ] Page refresh maintains task pause state

## Notes
- Existing controller methods were not modified (as per requirement)
- Uses existing upload route: `/upload-files/Task/{id}`
- Compatible with existing media library setup
- All text is in Arabic for consistency
- Tooltip support included for better UX
