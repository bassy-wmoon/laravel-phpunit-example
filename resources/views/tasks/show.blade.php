<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Task Create</title>
</head>
<body>
<form method="POST" action="/tasks/{{ @request('id') }}">
    @method('PUT')
    @csrf
    <div>
        <input type="text" name="title" placeholder="input tilte..." value="{{ $task['title'] }}">
    </div>
    <div>
        <textarea name="description" placeholder="input description...">{{ $task['description'] }}</textarea>
    </div>
    <div>
        <input type="date" name="dueDate" value="{{ $task['dueDate'] }}">
    </div>
    <div>

        <select name="status" value="{{ $task['status'] }}">
            <option value="">選択してください</option>
            <option value="1" @if($task['status'] === '1') selected @endif >todo</option>
            <option value="2" @if($task['status'] === '2') selected @endif >doing</option>
            <option value="3" @if($task['status'] === '3') selected @endif >done</option>
        </select>
    </div>
    <div>
        <button type="submit">送信</button>
    </div>
</form>

</body>
</html>
