<?php
include("./../function/footer.php");
$footer = footer();


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
    <div>
      <a href="./product_list.php">
        <i class="fa-solid fa-chevron-left"></i>
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
        <a href="./fixed_cost_lsit.php">
          <div>
            固定費
          </div>
        </a>
      </li>
    </ul>
  </section>
  <section class="main">
    <form action="./product_add_act.php" method="POST">
      <div class="status">
        <label for="product_name">
          商品名
        </label>
        <div>
          <p>商品の名前を入力</p>
          <input id="product_name" type="text" name="product_name">
        </div>
      </div>
      <div class="status">
        <label for="unit">単位</label>
        <div>
          <p>商品の販売単位を入力(例)箱、袋、枚、ケース</p>
          <input id="unit" type="text" name="unit">
        </div>
      </div>
      <div class="status">
        <label for="main_cost">主原価</label>
        <div>
          <p>製造に必要な原料費</p>
          <input id="main_cost" type="text" name="main_cost">円
        </div>
      </div>
      <div class="status">
        <label for="sub_cost">副原価</label>
        <div>
          <p>梱包や輸送など、製造以外でかかる費用の概算</p>
          <input id="sub_cost" type="text" name="sub_cost">円
        </div>
      </div>
      <div class="status">
        <label for="selling_price">売値</label>
        <div>
          <p>商品の販売価格</p>
          <input id="selling_price" type="text" name="selling_price">円
        </div>
      </div>
      <button class="button-main">追加</button>
    </form>
  </section>


  <?= $footer ?>
</body>

</html>