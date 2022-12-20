<?php
include("./../function/footer.php");
include('./../function/db.php');

if (
  !isset($_POST['cost_id']) || $_POST['cost_id'] === ''
) {
  echo json_encode(["error_msg" => "no input"]);
  exit();
}
$cost_id = $_POST["cost_id"];
$footer = footer();

// データベースに接続
$pdo = connect_to_db();

//プロダクトIDのデータを参照
$sql = 'SELECT * FROM fixed_cost_table WHERE id = :cost_id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':cost_id', $cost_id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$result = $stmt->fetch(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>product_add</title>
  <link rel="stylesheet" type="text/css" href="./../../css/basic_style.css">
  <link rel="stylesheet" type="text/css" href="./../../css/add.css">
  <script src="https://kit.fontawesome.com/66d795ff86.js" crossorigin="anonymous"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@500&display=swap" rel="stylesheet">
</head>

<body>
  <header>
    <div class="return">
      <a href="./fixed_cost_list.php">
        <i class="fa-solid fa-chevron-left"></i><span>固定費一覧</span>
      </a>
    </div>
    <div>
      <h1 class="page-title">設定</h1>
    </div>
    <div>
    </div>
  </header>
  <section class="navigation-tab">
    <ul>
      <li class="selected">
        <div>
          商品一覧
        </div>
      </li>
      <li>
        <a href="./fixed_cost_list.php">
          <div>
            固定費
          </div>
        </a>
      </li>
    </ul>
  </section>
  <section class="main">
    <form action="./fixed_cost_edit_act.php" method="POST">
      <div class="status">
        <input type="hidden" name="cost_id" value="<?= $result["id"] ?>">
        <label for="fixed_cost_name">
          固定費名
        </label>
        <div>
          <p>固定費の名前を入力</p>
          <input id="fixed_cost_name" type="text" name="fixed_cost_name" value="<?= $result["fixed_cost_name"] ?>">
        </div>
      </div>
      <div class="status">
        <label for="cost">費用</label>
        <div>
          <p>固定費の1ヶ月分の値段(費用)を入力</p>
          <input id="cost" type="text" name="cost" value="<?= $result["cost"] ?>">円
        </div>
      </div>
      <button class="button-main">保存</button>
    </form>
    <div class="delete_link">
      <a href="./fixed_cost_delete_act.php?cost_id=<?= $cost_id ?>" class>削除</a>
    </div>
  </section>

  <?= $footer ?>
</body>

</html>