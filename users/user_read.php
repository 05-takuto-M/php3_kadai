<?php
include('functions.php');
$pdo = connect_to_db();

$sql = 'SELECT * FROM users_table WHERE is_deleted=0 ORDER BY updated_at DESC';

$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザ管理（一覧画面）</title>
</head>

<body>
  <fieldset>
    <legend>ユーザ管理（一覧画面）</legend>
    <a href="user_input.php">ユーザ入力画面</a>
    <table>
      <thead>
        <tr>
          <th>deadline</th>
          <th>todo</th>
          <th>管理者</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody id="users_table">
      </tbody>
    </table>
  </fieldset>
  <script>
    const usersArray = <?= json_encode($result) ?>;

    const createUsersDOM = (usersArray) => usersArray.map(x => `
      <tr>
        <td>${x.username}</td>
        <td>${x.password}</td>
        <td>${x.is_admin==='1'?'管理者':'一般'}</td>
        <td>
          <a href='user_edit.php?id=${x.id}'>edit</a>
        </td>
        <td>
          <a href='user_delete.php?id=${x.id}'>delete</a>
        </td>
      </tr>
    `).join('');

    document.getElementById('users_table').innerHTML = createUsersDOM(usersArray);
  </script>
</body>

</html>