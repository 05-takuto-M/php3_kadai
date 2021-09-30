<?php
// 入力項目のチェック
if (
    !isset($_POST['todo']) || $_POST['todo'] == '' ||
    !isset($_POST['reason']) || $_POST['reason'] == '' ||
    !isset($_POST['deadline']) || $_POST['deadline'] == '' ||
    !isset($_POST['id']) || $_POST['id'] == ''
  ) {
    echo json_encode(["error_msg" => "no input"]);
    exit();
  }
  
  $todo = $_POST['todo'];
  $reason = $_POST['reason'];
  $deadline = $_POST['deadline'];
  $id = $_POST['id'];


// DB接続
include('functions.php');
$pdo = connect_to_db();

// SQL実行
$sql = 'UPDATE product_todo_table SET todo=:todo, reason=:reason, deadline=:deadline, updated_at=now() WHERE id=:id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':todo', $todo, PDO::PARAM_STR);
$stmt->bindValue(':reason', $reason, PDO::PARAM_STR);
$stmt->bindValue(':deadline', $deadline, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  header('Location:todo_input.php');
  exit();
}