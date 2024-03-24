When you learn, you can create quiz to understand and remember.
You can play quiz when you want to learn.
You can edit or delete quiz when you want to change.
You can set quiz theme and choise quiz fitting the theme.

使用条件
1：dockerがインストールされている
2：Laravelが扱えるか、扱える人が知り合いにいる

手順
1：まずはgit cloneでローカルにダウンロードしてください。
2：次に、.env.exampleを元に.envを作成します。APP_PORT=8573なども必要に応じて設定してください。
3:composer installを行って、vendorディレクトリを作成します。
4:php artisan key:generate コマンドで、ENVのAPP_KEYをセットします。
5:./vendor/bin/sail migrate コマンドを実行して、データベースのテーブルを作成してください。
6:./vendor/bin/sail up -d でアプリケーションが起動します。
