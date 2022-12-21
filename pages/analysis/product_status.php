<?php
include("./../function/footer.php");
include('./../function/db.php');

$footer = footer("setting");

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>product list</title>
  <link rel="stylesheet" type="text/css" href="./../../css/basic_style.css">
  <link rel="stylesheet" type="text/css" href="./../../css/list.css">
  <script src="https://kit.fontawesome.com/66d795ff86.js" crossorigin="anonymous"></script>
</head>

<body>
  <header>
    <div class="return">
      <a href="./../home/home.php">
        <i class="fa-solid fa-chevron-left"></i>
        <span>HOME</span>
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
        <a href="./monthly_graph.php">
          <div>
            損益分岐点
          </div>
        </a>
      </li>
      <li class="selected">
        <div>
          商品分析
        </div>
      </li>
      <li>
        <a href="./fixed_cost_status.php">
          <div>
            固定費
          </div>
        </a>
      </li>
    </ul>
  </section>

  <?= $footer ?>


</body>

</html>