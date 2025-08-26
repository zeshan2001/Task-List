@extends('layouts.app')

@section('title', 'The List of Tasks:')
{{-- @if (count($tasks))
    @foreach ($tasks as $task)
        <div>{{$task->title}}</div>
    @endforeach
@else
    <div>No tasks</div>
@endif --}}

@section('content')
<nav class="mb-4">
    <a href="{{ route('tasks.create') }}" class="link">Add Task</a>
</nav>
    @forelse ($tasks as $task)
        <a href="{{ route('tasks.show', ['task' => $task->id]) }}"
            @class(['color-gray', 'line-through' => $task->completed])>{{$task->title}}</a>
        <br>
    @empty
        <h2>You have No Task yet...</h2>
    @endforelse
    @if ($tasks->count())
        <nav>{{ $tasks->links() }}</nav>
    @endif
@endsection
