<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TaskManagementController extends Controller
{
    /**
     * Toggle task hidden status (pause/unpause)
     */
    public function toggleHidden(Request $request)
    {
        $task = Task::findOrFail($request->task_id);
        $task->hidden = $request->hidden;
        $task->save();

        return response()->json([
            'success' => true,
            'message' => $task->hidden ? 'تم إيقاف المهمة مؤقتاً' : 'تم استئناف المهمة',
            'hidden' => $task->hidden
        ]);
    }

    /**
     * Get task attachments
     */
    public function getAttachments($taskId)
    {
        $task = Task::findOrFail($taskId);
        
        try {
            // Get all media without specifying collection name
            $mediaItems = $task->media;
            
            // Format attachments for response
            $attachments = $mediaItems->map(function($media) {
                return [
                    'id' => $media->id,
                    'name' => $media->name,
                    'file_name' => $media->file_name,
                    'url' => $media->getUrl(),
                    'original_url' => $media->getUrl(),
                    'size' => $media->size,
                    'mime_type' => $media->mime_type,
                ];
            });
            
            return response()->json([
                'success' => true,
                'attachments' => $attachments,
                'task' => [
                    'id' => $task->id,
                    'name' => $task->name
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'attachments' => []
            ]);
        }
    }

    /**
     * Upload attachments for task
     */
    public function uploadAttachments(Request $request, $taskId)
    {
        $task = Task::findOrFail($taskId);
        
        if (!$request->hasFile('files')) {
            return response()->json([
                'success' => false,
                'message' => 'لم يتم اختيار أي ملفات'
            ], 400);
        }

        try {
            $uploadedFiles = [];
            
            foreach ($request->file('files') as $file) {
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $filename = pathinfo($originalName, PATHINFO_FILENAME);
                
                // Add unique identifier and timestamp to filename
                $uniqueFilename = 'task_' . $taskId . '_' . $filename . '_' . time() . '_' . Str::random(8) . '.' . $extension;
                
                // Add to media library in a specific collection with custom path
                $media = $task->addMedia($file)
                    ->usingFileName($uniqueFilename)
                    ->usingName($originalName)
                    ->toMediaCollection('task-attachments', 'task_uploads');
                
                $uploadedFiles[] = [
                    'id' => $media->id,
                    'name' => $media->name,
                    'file_name' => $media->file_name,
                    'url' => $media->getUrl(),
                ];
            }
            
            return response()->json([
                'success' => true,
                'message' => 'تم رفع الملفات بنجاح',
                'files' => $uploadedFiles
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء رفع الملفات: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete task attachment
     */
    public function deleteAttachment(Request $request, $taskId, $mediaId)
    {
        try {
            $task = Task::findOrFail($taskId);
            $media = $task->media()->findOrFail($mediaId);
            
            $media->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'تم حذف المرفق بنجاح'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حذف المرفق: ' . $e->getMessage()
            ], 500);
        }
    }
}
