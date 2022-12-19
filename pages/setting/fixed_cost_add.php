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
    <div class="return">
      <a href="./product_list.php">
        <i class="fa-solid fa-chevron-left"></i><span>HOME</span>
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
      <li>
        <a href="./product_list.php">
          <div>
            商品一覧
          </div>
        </a>
      </li>
      <li class="selected">
        <div>
          固定費
        </div>
      </li>
    </ul>
  </section>
  <section class="main">
    <form action="./fixed_cost_add_act.php" method="POST">
      <div class="status">
        <label for="fixed_cost_name">
          固定費名
        </label>
        <div>
          <p>固定費の名前を入力</p>
          <input id="fixed_cost_name" type="text" name="fixed_cost_name">
        </div>
      </div>
      <div class="status">
        <label for="cost">費用</label>
        <div>
          <p>固定費の1月分の値段(費用)を入力</p>
          <input id="cost" type="text" name="cost">
        </div>
      </div>
      </div>
      <button class="button-main">追加</button>
    </form>
  </section>


  <?= $footer ?>
</body>

</html>