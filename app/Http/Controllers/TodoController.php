<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Todo;
use App\Models\User;
use App\Notifications\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TodoNotShared;
use App\Mail\TodoShared;
use App\Mail\TodoClosed;

class TodoController extends Controller
{

    protected NotificationService $notificationService;

    // Constructor to inject NotificationService
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    // Display a listing of the todos
    public function index(Request $request)
    {
        if (Auth::guest()) {
            return redirect('/login');
        }

        $todos = $this->getTodos($request);
        $categories = Category::all();
        $hasDeletedRecords = Todo::onlyTrashed()->where('user_id', Auth::id())->exists();

        return view('todo.index', compact('todos', 'categories', 'hasDeletedRecords'));
    }

    // Show the form for creating a new todo
    public function create()
    {
        if (Auth::guest()) {
            return redirect('/login');
        }

        $categories = Category::all();
        return view('todo.create', compact('categories'));
    }

    // Show the form for editing the specified todo
    public function edit(Todo $todo)
    {
        if (auth()->user()->id !== $todo->user_id) {
            return redirect('/todos/' . $todo->id)->with('status', 'Nice try! You can only edit your own todos.');
        }
        $categories = Category::all();
        return view('todo.edit', compact('todo', 'categories'));
    }

    // Display the specified todo
    public function show(Todo $todo)
    {
        return view('todo.show', compact('todo'));
    }

    // Store a newly created todo in storage
    public function store(Request $request)
    {
        $this->validateTodoRequest($request);

        $todo = Todo::create($this->getTodoData($request));

        if ($request->input('shared')) {
            $this->notifyUsers(new TodoShared($todo));
        }

        return redirect('/todos/' . $todo->id)->with('status', 'Todo has been created!');
    }

    // Update the specified todo in storage
    public function update(Request $request, Todo $todo)
    {
        $this->validateTodoRequest($request);

        $sharedChangedNotification = $this->hasSharedChanged($request, $todo);
        $closedNotification = $this->isClosed($request, $todo);

        $todo->update($this->getTodoData($request));

        if ($sharedChangedNotification || $closedNotification) {
            $this->handleNotifications($request, $todo, $sharedChangedNotification, $closedNotification);
        }

        return redirect('/todos/' . $todo->id)->with('status', 'Todo has been updated!');
    }

    // Remove the specified todo from storage (soft delete)
    public function destroy(Todo $todo)
    {
        $todo->delete();
        return redirect('/')->with('status', 'Todo deleted successfully!');
    }

    // Remove the specified todo from storage by ID
    public function delete($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();

        return redirect('/')->with('status', 'Todo deleted successfully!');
    }

    // Display a listing of the trashed todos
    public function trashed()
    {
        $todos = Todo::onlyTrashed()
            ->where('user_id', Auth::id())
            ->orderBy('deleted_at', 'desc')
            ->paginate(5);

        return view('todo.trashed', compact('todos'));
    }

    // Restore the specified trashed todo
    public function restore($id)
    {
        $todo = Todo::onlyTrashed()->findOrFail($id);
        $todo->restore();

        return redirect('/')->with('status', 'Todo restored successfully!');
    }

    // Mark the specified todo as completed
    public function done(Todo $todo)
    {
        $todo->completed = 1;
        $todo->save();

        if ($todo->shared) {
            $this->notifyUsers(new TodoClosed($todo, Auth::user()));
        }

        return redirect('/todos/' . $todo->id)->with('status', 'Todo has been closed!');
    }

    // Get todos based on request filters
    private function getTodos(Request $request)
    {
        $query = Todo::where(function ($query) {
            $query->where('user_id', Auth::id())
                ->orWhere('shared', 1);
        });

        if ($categoryId = $request->input('category_id')) {
            $query->where('category_id', $categoryId);
        }

        if ($status = $request->input('status')) {
            $query->where('completed', $status === 'closed' ? 1 : 0);
        }

        if ($ownership = $request->input('ownership')) {
            $query->where('user_id', $ownership === 'my' ? Auth::id() : '!=', Auth::id());
        }

        return $query->orderBy('created_at', 'desc')->paginate(5);
    }

    // Validate the todo request
    private function validateTodoRequest(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'description' => 'required'
        ]);
    }

    // Get todo data from request
    private function getTodoData(Request $request)
    {
        return [
            'name' => $request->input('name'),
            'category_id' => $request->input('category_id'),
            'description' => $request->input('description'),
            'shared' => $request->input('shared') ? 1 : 0,
            'user_id' => Auth::id(),
            'completed' => $request->input('completed') ? 1 : 0,
        ];
    }

    // Check if the shared status has changed
    private function hasSharedChanged(Request $request, Todo $todo)
    {
        return ($request->input('shared') && !$todo->shared) || ($todo->shared == 1 && !$request->input('shared'));
    }

    // Check if the todo is closed
    private function isClosed(Request $request, Todo $todo)
    {
        return $request->input('completed') && !$todo->completed;
    }

    // Handle notifications for shared and closed todos
    private function handleNotifications(Request $request, Todo $todo, $sharedChangedNotification, $closedNotification)
    {
        $mailAddressesToNotify = User::where('id', '!=', Auth::id())->pluck('email')->toArray();

        if ($sharedChangedNotification) {
            $message = $request->input('shared') == 1 ? new TodoShared($todo) : new TodoNotShared($todo);
            $this->notificationService->sendNotification($mailAddressesToNotify, $message);
        }

        if ($closedNotification && $todo->shared) {
            $message = new TodoClosed($todo, Auth::user());
            $this->notificationService->sendNotification($mailAddressesToNotify, $message);
        }
    }

    // Notify users with a given message
    private function notifyUsers($message)
    {
        $mailAddressesToNotify = User::where('id', '!=', Auth::id())->pluck('email')->toArray();
        $this->notificationService->sendNotification($mailAddressesToNotify, $message);
    }
}
