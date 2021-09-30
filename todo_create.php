<?php

if (
  !isset($_POST['todo']) || $_POST['todo'] == '' ||
  !isset($_POST['reason']) || $_POST['reason'] == '' ||
  !isset($_POST['deadline']) || $_POST['deadline'] == ''
) {
  exit('paramError');
}

$todo = $_POST['todo'];
$reason = $_POST['reason'];
$deadline = $_POST['deadline'];

// DB接続

include('functions.php');
$pdo = connect_to_db();

// $dbn = 'mysql:dbname=gsacs_d03_05;charset=utf8;port=3306;host=localhost';
// $user = 'root';
// $pwd = '';

// try {
//   $pdo = new PDO($dbn, $user, $pwd);
// } catch (PDOException $e) {
//   echo json_encode(["db error" => "{$e->getMessage()}"]);
//   exit();
// }

$sql = 'INSERT INTO product_todo_table(id, todo, reason, deadline, created_at, updated_at) VALUES(NULL, :todo, :reason, :deadline, now(), now())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':todo', $todo, PDO::PARAM_STR);
$stmt->bindValue(':reason', $reason, PDO::PARAM_STR);
$stmt->bindValue(':deadline', $deadline, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  header("Location:todo_input.php");
  exit();
}
