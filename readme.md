# What is this Project ?

LaravelのPHPUnitのサンプルを作るプロジェクトです。  
タスクのCRUDアプリをベースにPHPUnitを作成します。

# Requirement

- https://readouble.com/laravel/5.8/ja/installation.html#server-requirements 参照

# Set up

```
$ composer install
$ touch database/database.sqlite
$ php artisan migrate:refresh --seed
```

# How to run Task Applliction

```
$ php artisan serve
```
http://localhost:8000/tasks にアクセスして下さい。  
その他のルーティングは`php artisan route:list`をチェックして下さい。
