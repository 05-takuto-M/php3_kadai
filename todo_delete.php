<?php
// データ受け取り
$id = $_GET['id'];

// DB接続
include('functions.php');
$pdo = connect_to_db();

// SQL実行
$sql = 'DELETE FROM product_todo_table WHERE id=:id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  header("Location:todo_input.php");
  exit();
}