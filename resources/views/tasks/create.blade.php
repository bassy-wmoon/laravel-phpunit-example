<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Task Create</title>
</head>
<body>
<form method="post" action="/tasks">
    @csrf
    <div>
        <input type="text" name="title" placeholder="input tilte..." value="">
    </div>
    <div>
        <textarea name="description" placeholder="input description..." value=""></textarea>
    </div>
    <div>
        <input type="date" name="dueDate" value="">
    </div>
    <div>
        <button type="submit">送信</button>
    </div>
</form>

</body>
</html>
