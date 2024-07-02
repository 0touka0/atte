# atte

## 環境構築
Dockerビルド

 1.`git clone git@github.com:0touka0/atte.git`<br>
 2.docker-compose up -d --build

＊MySQLは、OSによって起動しない場合があるのでそれぞれのPCに合わせて、docker-compose.ymlファイルを編集してください。

Laravel環境構築

1. docker-compose exec php bash
2. composer install
3. .env.exampleファイルから.envを作成し、環境変数を変更
4. php artisan key:generate
5. php artisan migrate
6. php artisan db:seed

## 使用技術(実行環境)
- PHP 7.4.9
- Laravel 8
- MySQL 8.0.26
- nginx 1.21.1
- phpMyAdmin
- MailHog

## ER図




## URL
- 開発環境：http://localhost/
- 開発環境：http://localhost/register
- 開発環境：http://localhost/login
- 開発環境：http://localhost/attendance
- 開発環境：http://localhost/userlist
- 開発環境：http://localhost/userdata
- phpMyAdmin : http://localhost:8080/
- MailHog : http://localhost:8025/