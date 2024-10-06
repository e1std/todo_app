<!DOCTYPE html>
<html>
<head>
    <title>Todo Has Been Closed</title>
</head>
<body>
<h1>Todo Has Been Closed</h1>
<p>A todo has been closed by <strong>{{ $user->name }}</strong>:</p>
<p><strong>Name:</strong> {{ $todo->name }}</p>
<p><strong>Description:</strong> {!! nl2br(e($todo['description'])) !!}</p>
<p><strong>Category:</strong> {{ $todo->category->name }}</p>
</body>
</html>
