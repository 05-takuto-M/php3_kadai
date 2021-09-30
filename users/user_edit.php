<?php
// var_dump($_GET);
// exit();

$id = $_GET['id'];

include('functions.php');
$pdo = connect_to_db();

$sql = 'SELECT * FROM users_table WHERE id=:id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  $record = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザ管理（編集画面）</title>
</head>

<body>
  <form action="user_update.php" method="POST" id="update_form"></form>

  <script>
    const userData = <?= json_encode($record) ?>;

    document.getElementById('update_form').innerHTML = `
      <fieldset>
        <legend>ユーザ管理（編集画面）</legend>
        <a href="user_read.php">ユーザ一覧画面</a>
        <div>
          username: <input type="text" name="username" value="${userData.username}">
        </div>
        <div>
          password: <input type="text" name="password" value="${userData.password}">
        </div>
        <div>
          <label for="admin">
            管理者<input type="radio" name="is_admin" value="1" id="admin" ${userData.is_admin==='1'?'checked':''}>
          </label>
          <label for="normal">
            一般<input type="radio" name="is_admin" value="0" id="normal" ${userData.is_admin==='1'?'':'checked'}>
          </label>
        </div>
        <div>
          <input type="hidden" name="id" value="${userData.id}">
        </div>
        <div>
          <button>submit</button>
        </div>
      </fieldset>
    `;
  </script>
</body>

</html>