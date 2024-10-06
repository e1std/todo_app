<!DOCTYPE html>
<html>
<head>
    <title>Todo No Longer Shared</title>
</head>
<body>
<h1>Todo No Longer Shared</h1>
<p>A todo is no longer shared with you:</p>
<p><strong>Name:</strong> {{ $todo->name }}</p>
<p><strong>Description:</strong> {!! nl2br(e($todo['description'])) !!}</p>
<p><strong>Category:</strong> {{ $todo->category->name }}</p>
</body>
</html>
