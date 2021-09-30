<?php
$id = $_GET['id'];

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

$sql = 'SELECT * FROM product_todo_table ORDER BY deadline ASC';
// $sql = 'SELECT * FROM  product_todo_table  ';

$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

if ($status == false) {
$error = $stmt->errorInfo();
echo json_encode(["error_msg" => "{$error[2]}"]);
exit();
} else {
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$output1 = "";
$output2 = "";
$output3 = "";
foreach ($result as $record) {
    $output1 .= "
    <tr>
        <td>{$record["deadline"]}</td>
        <td>
        <a href='todo_input.php?id={$record["id"]}'>edit</a>
        </td>
        <td>
        <a href='todo_delete.php?id={$record["id"]}'>delete</a>
        </td>
    </tr>
    ";
    $output2 .= "
    <tr>
    <td>{$record["todo"]}</td>
        <td>
        <a href='todo_input.php?id={$record["id"]}'>edit</a>
        </td>
        <td>
        <a href='todo_delete.php?id={$record["id"]}'>delete</a>
        </td>
    </tr>
    ";
    $output3 .= "
    <tr>
    <td>{$record["reason"]}</td>
        <td>
        <a href='todo_input.php?id={$record["id"]}'>edit</a>
        </td>
        <td>
        <a href='todo_delete.php?id={$record["id"]}'>delete</a>
        </td>
    </tr>
    ";
}
};



$sql = 'SELECT * FROM product_todo_table WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  $record = $stmt->fetch(PDO::FETCH_ASSOC);
// var_dump($_GET);
// exit();
}
?>


<!-- 画像 -->
<?php
require_once('ifunctions.php');
$pdo = connectDB();

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    // 画像を取得
    $sql = 'SELECT * FROM images ORDER BY created_at DESC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $images = $stmt->fetchAll();

} else {
    // 画像を保存
    if (!empty($_FILES['image']['name'])) {
        $name = $_FILES['image']['name'];
        $type = $_FILES['image']['type'];
        $content = file_get_contents($_FILES['image']['tmp_name']);
        $size = $_FILES['image']['size'];

        $sql = 'INSERT INTO images(image_name, image_type, image_content, image_size, created_at)
                VALUES (:image_name, :image_type, :image_content, :image_size, now())';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':image_name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':image_type', $type, PDO::PARAM_STR);
        $stmt->bindValue(':image_content', $content, PDO::PARAM_STR);
        $stmt->bindValue(':image_size', $size, PDO::PARAM_INT);
        $stmt->execute();
    }
    header('Location:todo_input.php');
    exit();
}
?>
<!-- 画像 -->

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>todoリスト</title>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">-->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="position">
        <div>
            <!-- input.phpの内容 -->
            <form action="todo_create.php" method="POST">
                <fieldset>
                    <legend>todoリスト（入力）</legend>
                    <!-- <a href="todo_read.php">一覧画面</a> -->
                    <div>
                        todo: <input type="text" name="todo">
                    </div>
                    <div>
                        reason: <input type="text" name="reason">
                    </div>
                    <div>
                        deadline: <input type="date" name="deadline">
                    </div>
                    <div>
                        <button>submit</button>
                    </div>
                </fieldset>
            </form>
        </div>
        <div>
            <!-- edit.phpの内容編集 -->
            <form action="todo_update.php" method="POST">
                <fieldset>
                    <legend>todoリスト（編集）</legend>
                    <!-- <a href="todo_read.php">一覧画面</a> -->
                    <div>
                        todo: <input type="text" name="todo" value="<?= $record['todo'] ?>">
                    </div>
                    <div>
                        reason: <input type="text" name="reason" value="<?= $record['reason'] ?>">
                    </div>
                    <div>
                        deadline: <input type="date" name="deadline" value="<?= $record['deadline'] ?>">
                    </div>
                    <div>
                        <!-- ここでid取得しつつ、hiddenで隠してる -->
                        <input type="hidden" name="id" value="<?= $record['id'] ?>">
                    </div>
                    <div>
                        <button>submit</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>

    <!-- read.phpの内容 -->
    <div class="yokonarabi1">
    <div>
        <fieldset class="width">
            <legend>deadline（一覧）</legend>
            <!-- <a href="todo_input.php">入力画面</a> -->
            <table>
                <thead>
                    <tr>
                        <th>deadline</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?= $output1 ?>
                </tbody>
            </table>
        </fieldset>
    </div>
    <div>
        <fieldset class="width">
            <legend>todo（一覧）</legend>
            <!-- <a href="todo_input.php">入力画面</a> -->
            <table>
                <thead>
                    <tr>
                        <th>todo</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?= $output2 ?>
                </tbody>
            </table>
        </fieldset>
    </div>
    <div>
        <fieldset class="width">
            <legend>reason（一覧）</legend>
            <!-- <a href="todo_input.php">入力画面</a> -->
            <table>
                <thead>
                    <tr>
                        <th>reason</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?= $output3 ?>
                </tbody>
            </table>
        </fieldset>
    </div>
    </div>
    <!-- 画像 -->
    <div class="images">
        <!--class="container mt-5"-->
        <div>
            <div>
                <!--class="col-md-4 pt-4 pl-4"-->
                <form method="post" enctype="multipart/form-data">
                    <div>
                        <label>画像を選択</label>
                        <input type="file" name="image" required>
                    </div>
                    <button type="submit" class="btn btn-primary">保存</button>
                </form>
            </div>
            <div>
                <!--class="col-md-8 border-right"-->
                <ul>
                    <?php for($i = 0; $i < count($images); $i++): ?>
                    <div class="yokonarabi">
                        <div>
                            <a href="#lightbox" data-toggle="modal" data-slide-to="<?= $i; ?>">
                                <img src="image.php?id=<?= $images[$i]['image_id']; ?>" width="100px" height="auto"
                                    class="mr-3">
                            </a>
                        </div>
                        <div>
                            <h5><?= $images[$i]['image_name']; ?>
                                (<?= number_format($images[$i]['image_size']/1000, 2); ?> KB)</h5>
                            <a href="javascript:void(0);"
                                onclick="var ok = confirm('削除しますか？'); if (ok) location.href='delete.php?id=<?= $images[$i]['image_id']; ?>'">
                                <i class="far fa-trash-alt"></i> 削除</a>
                        </div>
                    </div>
                    <?php endfor; ?>
                </ul>
            </div>

        </div>
    </div>
    <!-- 画像 -->
    <div id="lightbox" tabindex="-1" role="dialog" data-ride="carousel">
        <div role="document">
            <div>
                <div>
                    <!-- <ol>
                        <?php for ($i = 0; $i < count($images); $i++): ?>
                        <li data-target="#lightbox" data-slide-to="<?= $i; ?>"
                            <?php if ($i == 0) echo 'class="active"'; ?>></li>
                        <?php endfor; ?>
                    </ol> -->

                    <div>
                        <?php for ($i = 0; $i < count($images); $i++): ?>
                        <div <?php if ($i == 0) echo 'active'; ?>">
                            <img src="image.php?id=<?= $images[$i]['image_id']; ?>">
                        </div>
                        <?php endfor; ?>
                    </div>

                    <a href="#lightbox" role="button" data-slide="prev">
                        <span aria-hidden="true"></span>
                        <span>Previous</span>
                    </a>
                    <a href="#lightbox" role="button" data-slide="next">
                        <span aria-hidden="true"></span>
                        <span>Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>