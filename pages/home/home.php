<?php
include("./../function/footer.php");
$footer = footer("home");
?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>home</title>
  <link rel="stylesheet" type="text/css" href="./../../css/basic_style.css">
  <link rel="stylesheet" type="text/css" href="./../../css/home.css">
  <script src="https://kit.fontawesome.com/66d795ff86.js" crossorigin="anonymous"></script>
</head>

<body>
  <header>
    <div>
    </div>
    <div>
      <h1 class="page-title">ホーム</h1>
    </div>
    <div>
    </div>
  </header>

  <section class="main">
    <h2>割と正確などんぶり会計</h2>
    <div>
      <p>このツールは損益分岐点や商品の粗利率などを可視化するツールです。</p>
    </div>
    <h2>使い方</h2>
    <div>
      <h3>固定費と商品を登録</h3>
      <div>
        <p>はじめに、
          <a href="./../setting/product_list.php">設定<i class='fa-solid fa-gear'></i></a>
          で
          <a href="./../setting/fixed_cost_list.php">固定費</a>
          と
          <a href="./../setting/product_list.php">販売している商品</a>
          を登録します。
        </p>
      </div>
    </div>
    <div>
      <h3>毎日の販売数を入力</h3>
      <div>
        <p>登録した商品がいくつ売れたかを
          <a href="./../input/sales_performance.php">入力<i class='fa-solid fa-pen'></i></a>
          します。
        </p>
      </div>

    </div>
    <div>
      <h3>グラフを確認</h3>
      <div>
        <p>登録した情報をもとに、
          <a href="./../analysis/monthly_graph.php">グラフを表示<i class='fa-solid fa-chart-line'></i></a>
          します。
        </p>
      </div>
    </div>

  </section>



  <?= $footer ?>
</body>

</html>