<?php
// var_dump($_POST);
// exit();

if (
  !isset($_POST['username']) || $_POST['username'] == '' ||
  !isset($_POST['password']) || $_POST['password'] == '' ||
  !isset($_POST['is_admin']) || $_POST['is_admin'] == '' ||
  !isset($_POST['id']) || $_POST['id'] == ''
) {
  echo json_encode(["error_msg" => "no input"]);
  exit();
}

$username = $_POST['username'];
$password = $_POST['password'];
$is_admin = $_POST['is_admin'];
$id = $_POST['id'];

include('functions.php');
$pdo = connect_to_db();

$sql = 'UPDATE users_table SET username=:username, password=:password, is_admin=:is_admin, updated_at=sysdate() WHERE id=:id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$stmt->bindValue(':is_admin', $is_admin, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  header('Location:user_read.php');
  exit();
}
