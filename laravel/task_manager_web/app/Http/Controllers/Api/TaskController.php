<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Notifications\TaskAttachedNotification;
use App\Notifications\TaskDeletedNotification;
use App\Notifications\TaskUpdatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (Auth::user()->id !== $request->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
 
        $user = Auth::user();
        // $tasks = Task::with('users')->where('user_id', $user->id)->latest()->get();
        $tasks = $user->tasks()->with('users')->latest()->get();
        // $tasks = Task::where('user_id', $user->id)->latest()->get();
        
        return response()->json([
            'status' => 'success',
            'count' => count($tasks),
            'tasks' => $tasks,
        ], 200);

    }
    
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'assigned_users' => 'nullable|array', // Array of user IDs
            'assigned_users.*' => 'exists:users,id', // Validate each user ID exists in the users table
        ]);

        $task = Auth::user()->tasks()->create($validated);
        
        if ($task) {
            // Attach additional users to the task if specified
            if ($request->has('assigned_users')) {
                $task->users()->attach($validated['assigned_users']);
    
                // Notify each user about the task attachment
                $task->users->each(function ($user) use ($task) {
                    $user->notify(new TaskAttachedNotification($task));
                });
            }
    
            return response()->json([
                'status' =>'success',
                'message' => 'Task created successfully!',
                'task' => $task,
            ], 201);
        } else {
            // Handle the case where the task creation failed
            return response()->json([
                'status' =>'error',
                'message' => 'Failed to create task',
            ], 500); // Use appropriate HTTP status code for failure
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        // Check if the authenticated user is among the users associated with the task
        $authenticatedUser = Auth::user();
        $associatedUsersIds = $task->users->pluck('id')->toArray();

        if (!in_array($authenticatedUser->id, $associatedUsersIds)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Eager load the 'users' relationship to fetch all users associated with the task
        $task->load('users');

        // Return the task details
        return response()->json([
            'status' => 'success',
            'task' => $task,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        // Validate the request data
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'status' => 'sometimes|required|in:start,pending,in progress,done,close', // Validate against the allowed status values
            'assigned_users' => 'nullable|array', // Array of user IDs
            'assigned_users.*' => 'exists:users,id', // Validate each user ID exists in the users table
        ]);

        $user = Auth::user();

        if (($request->status === 'start' || $request->status === 'close' || $request->title || $request->description)
        && $task->users()->where('users.id', $user->id)->exists()) {
            if (($user->role->name === 'manager') && $task->users()->whereHas('role', function ($query) {
                $query->where('name', 'admin');
            })->exists()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            if (($user->role->name === 'dev') && $task->users()->whereHas('role', function ($query) {
                $query->whereIn('name', ['admin', 'manager']);
            })->exists()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            if ($user->role->name === 'regular' && $task->users()->whereHas('role', function ($query) {
                $query->whereIn('name', ['admin', 'manager', 'dev']);
            })->exists()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        }
        
        try {
            if ($request->has('assigned_users')) {
                $task->users()->attach($validated['assigned_users']);

                // Notify each user about the task attachment
                $task->users->each(function ($user) use ($task) {
                    $user->notify(new TaskUpdatedNotification($task));
                });
            }

            // Update the task with the validated data
            $task->update($validated);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Task details updated successfully.',
                'task' => $task->refresh(), // Refresh the task to get the latest data
            ], 200);
        } catch (\Exception $e) {
            // Log the error or handle it as needed
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }
    
    
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);      

        try {
            $task->delete();

            foreach ($task->users as $user) {
                $user->notify(new TaskDeletedNotification($task));
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Task deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to delete task'
            ], 500);
        }
    }
    
}
