<?php
include("./../function/footer.php");

$footer = footer();
// 商品名一覧を取得


?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>performance</title>
  <link rel="stylesheet" type="text/css" href="./../../css/basic_style.css">
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
      <h1 class="page-title">販売実績を入力</h1>
    </div>
    <div>
    </div>
  </header>
  <section class="main">
    <h2 class="section-label">日付 </h2>
    <table>
      <thead>
        <tr>
          <td>商品名</td>
          <td>販売数</td>
          <td>単位</td>
        </tr>
      </thead>
      <tbody>
        <!-- php -->
      </tbody>
    </table>



  </section>
  <?= $footer ?>
</body>

</html>