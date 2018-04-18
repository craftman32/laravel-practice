<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Task;

class TasksController extends Controller
{
    /**
     * Handles the index route and sets the current user.
     */
    public function index()
    {
        $user = Auth::user();
        return view('welcome', compact('user'));
    }

    /**
     * Handles the add route.
     */
    public function add()
    {
        return view('add');
    }

    /**
     * Handles the create route and saves a new task.
     */
    public function create(Request $request)
    {
        $task = new Task();
        $task->description = $request->description;
        $task->user_id = Auth::id();
        $task->save();

        return redirect('/');
    }

    /**
     * Handles the edit route.
     */
    public function edit(Task $task)
    {
        // checks if the current user can edit the task
        if (Auth::check() && Auth::user()->id == $task->user_id) {
            return view('edit', compact('task'));
        } else {
            return redirect('/');
        }
    }

    /**
     * Handles the update route.
     */
    public function update(Request $request, Task $task)
    {
        // checks if a delete is being requested
        if (isset($_POST['delete'])) {
            $task->delete();
            return redirect('/');
        } else {
            // updates the task description
            $task->description = $request->description;
            $task->save();
            return redirect('/');
        }
    }
}
