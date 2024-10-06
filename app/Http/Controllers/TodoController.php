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

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
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

    public function create()
    {
        if (Auth::guest()) {
            return redirect('/login');
        }

        $categories = Category::all();
        return view('todo.create', compact('categories'));
    }


    public function edit(Todo $todo)
    {
        if (auth()->user()->id !== $todo->user_id) {
            return redirect('/todos/' . $todo->id)->with('status', 'Nice try! You can only edit your own todos.');
        }
        $categories = Category::all();
        return view('todo.edit', compact('todo', 'categories'));
    }

    public function show(Todo $todo)
    {
        return view('todo.show', compact('todo'));
    }

    public function store(Request $request)
    {
        $this->validateTodoRequest($request);

        $todo = Todo::create($this->getTodoData($request));

        if ($request->input('shared')) {
            $this->notifyUsers(new TodoShared($todo));
        }

        return redirect('/todos/' . $todo->id)->with('status', 'Todo has been created!');
    }

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

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return redirect('/')->with('status', 'Todo deleted successfully!');
    }

    public function delete($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();

        return redirect('/')->with('status', 'Todo deleted successfully!');
    }

    public function trashed()
    {
        $todos = Todo::onlyTrashed()
            ->where('user_id', Auth::id())
            ->orderBy('deleted_at', 'desc')
            ->paginate(5);

        return view('todo.trashed', compact('todos'));
    }

    public function restore($id)
    {
        $todo = Todo::onlyTrashed()->findOrFail($id);
        $todo->restore();

        return redirect('/')->with('status', 'Todo restored successfully!');
    }

    public function done(Todo $todo)
    {
        $todo->completed = 1;
        $todo->save();

        if ($todo->shared) {
            $this->notifyUsers(new TodoClosed($todo, Auth::user()));
        }

        return redirect('/todos/' . $todo->id)->with('status', 'Todo has been closed!');
    }

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

    private function validateTodoRequest(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'description' => 'required'
        ]);
    }

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

    private function hasSharedChanged(Request $request, Todo $todo)
    {
        return ($request->input('shared') && !$todo->shared) || ($todo->shared == 1 && !$request->input('shared'));
    }

    private function isClosed(Request $request, Todo $todo)
    {
        return $request->input('completed') && !$todo->completed;
    }

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

    private function notifyUsers($message)
    {
        $mailAddressesToNotify = User::where('id', '!=', Auth::id())->pluck('email')->toArray();
        $this->notificationService->sendNotification($mailAddressesToNotify, $message);
    }
}
