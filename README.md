When you learn, you can create quiz to understand and remember.
You can play quiz when you want to learn.
You can edit or delete quiz when you want to change.
You can set quiz theme and choise quiz fitting the theme.

[主な機能]
・クイズの作成・編集・削除: 自分だけのクイズを作成して学習に利用できます。不要になったクイズは削除も可能です。
・テーマ設定: クイズにはテーマを設定でき、テーマに沿ったクイズを選んで遊ぶことができます。

[使用条件]
・Dockerがインストールされていること。
・Laravelの基本的な知識がある、またはその知識を持つ人がサポート可能なこと。

[セットアップ]
1：まずはgit cloneでリポジトリをローカルにダウンロードしてください。
2：次に、.env.exampleを元に.envを作成し、必要に応じて設定を調整します（例：APP_PORT=8573）。
3:composer installを行って、vendorディレクトリを作成し、必要な依存関係をインストールします。
4:php artisan key:generate コマンドで、ENVのAPP_KEYをセットします。
5:./vendor/bin/sail up -dでDockerを起動し、./vendor/bin/sail migrate コマンドでデータベースの準備をします。
6:ブラウザでhttp://localhost:8573/にアクセスしてアプリケーションを開始します(8573の部分は自分が設定したPORT番号を使ってください)。

[使い方]
1:まずは学習テーマを設定してください
・「テーマを編集する」をクリックしてください。
・小テーマと大テーマが設定できます(例：小テーマにPHP,Javascript,css。大テーマにプログラミング…etc)。は全てのクイズに設定が必須です。
・大テーマは「設定しない」でもOKです。
・それぞれ既存のテーマは選べず、3文字以上です。
・テーマは随時、作成&編集&消去が可能です。

2:次に、クイズを作成してください
・「クイズを作る」をクリックしてください。
・タイトル、問題、回答をセットしてください。問題と回答は、それぞれ3文字以上です。
・回答は5つまで記入可能です。1つ目は必ず作成する必要があります。
・回答形式は回答を入力することで成否が分かる問題(回答必須)、と回答が説明形式の問題(回答は文章)の2通りあります。
・クイズにはレベルを設定し（1~10の範囲）、適切なテーマ(3つまで可能)を選択します。
・クイズは随時、作成&編集&消去が可能です。

3:クイズで遊んだり学んだりしてみてください
・「クイズを行う」をクリックしてください。
・行うクイズのテーマ、レベル、過去の正解率、回答形式を選択してください。テーマは複数選択OKです。
・問題が出題されます。回答必須のものは回答を入力し、回答5つのどれかであれば正解マークが表示、間違っていた場合は不正解マークと回答が表示されます。
・回答は文章のものは回答の入力と成否チェックはできません。
・該当の問題が全て終了すると、結果が表示されます。
・クイズは随時、作成&編集&消去が可能です。


