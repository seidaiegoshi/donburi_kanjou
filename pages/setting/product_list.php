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
  <title>product list</title>
  <link rel="stylesheet" type="text/css" href="./../../css/basic_style.css">
  <link rel="stylesheet" type="text/css" href="./../../css/list.css">
  <script src="https://kit.fontawesome.com/66d795ff86.js" crossorigin="anonymous"></script>
</head>

<body>
  <header>
    <div>
      <a href="./../home/home.php">
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
        <a href="./fixed_cost_list.php">
          <div>
            固定費
          </div>
        </a>
      </li>
    </ul>
  </section>
  <section class="main">

    <div class="search">
      <input type="text" placeholder="商品名検索">
    </div>

    <div class="menu">
      <div>
        <div>
          <a href="./product_add.php" class="button-main">商品追加</a>
        </div>
      </div>
      <div>
        <div>
          <a href="" class="button-main">編集</a>
        </div>
        <div>
          <a href="" class="button-delete">削除</a>
        </div>
      </div>
    </div>
    <div>
      <table>
        <thead>
          <tr>
            <td>商品名</td>
            <td>単位</td>
            <td>主原価</td>
            <td>副原価</td>
            <td>売値</td>
            <td></td>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>

  </section>



  <?= $footer ?>
</body>

</html>