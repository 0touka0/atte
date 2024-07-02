# Atte(アット)
ある企業の勤怠管理システム
![atte_Home](https://github.com/0touka0/atte/assets/163740181/7562f463-5f40-4fad-a757-d604835161df)

## 作成した目的
人事評価のため

## アプリケーションURL
- http://localhost/
- http://localhost/register
- http://localhost/login
- http://localhost/attendance
- http://localhost/userlist
- http://localhost/userdata
- http://localhost:8025

## 他のリポジトリ
無し

## 機能一覧
- 会員登録
- ログイン
- メール認証
- 勤務開始
- 勤務終了
- 休憩開始
- 休憩終了
- 日付別勤怠情報取得
- ユーザー情報取得
- ユーザー毎勤怠情報取得
- ページネーション

## 使用技術(実行環境)
- PHP 7.4.9
- Laravel 8
- MySQL 8.0.26
- nginx 1.21.1
- mailHog

## テーブル設計
![atte_table](https://github.com/0touka0/atte/assets/163740181/d96af0dd-6e2a-41dc-a4bd-e62e90d2c076)

## ER図
![atte_ER](https://github.com/0touka0/atte/assets/163740181/0f3959d8-2f01-44f2-90b0-c369417a6920)

# 環境構築
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

## 機能確認用ユーザー
- ユーザー名：テスト
- メールアドレス：test@example.com
- パスワード：testexample
- メール認証はmailhogから認証可能<br>(mailhogを使用する場合.envのMAIL_FROM_ADDRESSに送信側のメールアドレスを記述する必要があります。)
- 認証メールが届かなかった場合、再度送信してください
