<?php
include("./../function/footer.php");
include('./../function/db.php');

$product_id = $_POST["product_id"];
$footer = footer();

// データベースに接続
$pdo = connect_to_db();

//プロダクトIDのデータを参照
$sql = 'SELECT * FROM products_table WHERE id = :product_id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':product_id', $product_id, PDO::PARAM_STR);

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
      <a href="./product_list.php">
        <i class="fa-solid fa-chevron-left"></i><span>商品一覧</span>
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
    <form action="./product_edit_act.php" method="POST">
      <div class="status">
        <input type="hidden" name="product_id" value="<?= $result["id"] ?>">
        <label for="product_name">
          商品名
        </label>
        <div>
          <p>商品の名前を入力</p>
          <input id="product_name" type="text" name="product_name" value="<?= $result["product_name"] ?>">
        </div>
      </div>
      <div class="status">
        <label for="unit">単位</label>
        <div>
          <p>商品の販売単位を入力(例)箱、袋、枚、ケース</p>
          <input id="unit" type="text" name="unit" value="<?= $result["unit"] ?>">
        </div>
      </div>
      <div class="status">
        <label for="main_cost">主原価</label>
        <div>
          <p>製造に必要な原料費</p>
          <input id="main_cost" type="text" name="main_cost" value="<?= $result["main_cost"] ?>">円
        </div>
      </div>
      <div class="status">
        <label for="sub_cost">副原価</label>
        <div>
          <p>梱包や輸送など、製造以外でかかる費用の概算</p>
          <input id="sub_cost" type="text" name="sub_cost" value="<?= $result["sub_cost"] ?>">円
        </div>
      </div>
      <div class="status">
        <label for="selling_price">売値</label>
        <div>
          <p>商品の販売価格</p>
          <input id="selling_price" type="text" name="selling_price" value="<?= $result["selling_price"] ?>">円
        </div>
      </div>
      <button class="button-main">保存</button>
    </form>
    <div class="delete_link">
      <a href="./product_delete_act.php?product_id=<?= $product_id ?>" class>削除</a>
    </div>
  </section>


  <?= $footer ?>
</body>

</html>