<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザ管理（入力画面）</title>
</head>

<body>
  <form action="user_create.php" method="POST">
    <fieldset>
      <legend>ユーザ管理（入力画面）</legend>
      <a href="user_read.php">ユーザ一覧画面</a>
      <div>
        username: <input type="text" name="username">
      </div>
      <div>
        password: <input type="text" name="password">
      </div>
      <div>
        <label for="admin">
          管理者<input type="radio" name="is_admin" value="1" id="admin">
        </label>
        <label for="normal">
          一般<input type="radio" name="is_admin" value="0" id="normal" checked>
        </label>
      </div>
      <div>
        <button>submit</button>
      </div>
    </fieldset>
  </form>

</body>

</html>