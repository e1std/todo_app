<!DOCTYPE html>
<html>
<head>
    <title>Todo Shared</title>
</head>
<body>
<h1>Todo Shared</h1>
<p>A todo has been shared with you by <strong>{{ $todo->user->name }}:</strong></p>
<p><strong>Name:</strong> {{ $todo->name }}</p>
<p><strong>Description:</strong> {!! nl2br(e($todo['description'])) !!}</p>
<p><strong>Category:</strong> {{ $todo->category->name }}</p>
</body>
</html>
