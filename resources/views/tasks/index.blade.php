@foreach ($tasks as $task)

    <div>
        <span>{{ $task['title'] }}</span>
        <p>{{ $task['description'] }}</p>
        <p>{{ $task['due_date'] }}</p>
        <p>{{ $task['status'] }}</p>
    </div>

@endforeach
