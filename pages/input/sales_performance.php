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
    <div class="section-label">
      <h2>日付</h2>
      <input type="date" id="select_date">
    </div>
    <table>
      <thead>
        <tr>
          <td>商品名</td>
          <td>販売数</td>
          <td>単位</td>
        </tr>
      </thead>
      <form action="./quantity_add_act.php" method="POST">
        <tbody>
        </tbody>
        <button class="button-main">販売数を登録</button>
      </form> <!-- php -->
    </table>
  </section>
  <section class="bottom-button">
    <div>

    </div>
  </section>
  <?= $footer ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="./../../js/sales_performance.js"></script>
</body>

</html>