<?php
include("./../function/footer.php");

$footer =
  footer("input");

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>performance</title>
  <link rel="stylesheet" type="text/css" href="./../../css/basic_style.css">
  <link rel="stylesheet" type="text/css" href="./../../css/sales.css">
  <script src="https://kit.fontawesome.com/66d795ff86.js" crossorigin="anonymous"></script>
</head>

<body>
  <header>
    <div class="return">
      <a href="./../home/home.php">
        <i class="fa-solid fa-chevron-left"></i><span>HOME</span>
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
      <tbody>
      </tbody>
      </form> <!-- php -->
    </table>
  </section>
  <?= $footer ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="./../../js/sales_performance.js"></script>
</body>

</html>