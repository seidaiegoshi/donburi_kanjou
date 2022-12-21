<?php
include("./../function/footer.php");
include('./../function/db.php');

$footer = footer("setting");


// データベースに接続
$pdo = connect_to_db();

$sql = 'SELECT * FROM products_table WHERE company_id = :company_id AND deleted_at IS  NULL';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':company_id', 1, PDO::PARAM_STR);


try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$table_element = "";
foreach ($result as $key => $record) {
  $table_element .= "
    <tr>
      <td>{$record["product_name"]}</td>
      <td>{$record["unit"]}</td>
      <td class='main_cost'>{$record["main_cost"]}<span class='yen'>円</span></td>
      <td class='sub_cost'>{$record["sub_cost"]}<span class='yen'>円</span></td>
      <td class='selling_price'>{$record["selling_price"]}<span class='yen'>円</span></td>

      <td class='td_edit'>
        <form action='./product_edit.php' method='POST'>
        <input type='hidden' name='product_id' value='{$record["id"]}'>
        <button class='button-main'>編集</button>
        </form>
      </td>
    </tr>
  ";
}


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
      <input id="search" type="text" placeholder="商品名検索">
    </div>

    <div class="menu">
      <div>
        <div>
          <a href="./product_add.php" class="button-main">商品追加</a>
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
        <tbody>
          <?= $table_element ?>
        </tbody>
      </table>
    </div>
  </section>


  <?= $footer ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script>
    $("#search").on("keyup", function(e) {
      // console.log(e.target.value);
      const searchWord = e.target.value;
      const url = "./product_list_ajax.php";
      axios
        .get(`${url}?search_word=${searchWord}`)
        .then(function(response) {
          htmlElement = "";
          response.data.forEach((record) => {
            htmlElement += `<tr>
            <td>${record.product_name}</td>
            <td>${record.unit}</td>
            <td class="main_cost">${record.main_cost}<span class='yen'>円</span></td>
            <td class="sub_cost" >${record.sub_cost}<span class='yen'>円</span></td>
            <td class="selling_price" >${record.selling_price}<span class='yen'>円</span></td>
            <td class='td_edit'>
              <form action='./product_edit.php' method='POST'>
              <input type='hidden' name='product_id' value='${record.id}'>
              <button class='button-main'>編集</button>
              </form>
            </td>
            <tr>`;
          });
          if (htmlElement !== "") {
            $("tbody").html(htmlElement);
          } else {
            $("tbody").html(`<?= $table_element ?>`);
          }
          // console.log(htmlElement);
        })
        .catch(function(error) {})
        .finally(function() {});
    });
  </script>
  <script>
    // 編集・削除ボタン表示
    $("#edit-button").on("click", function() {
      $(".td_edit").removeClass("hidden");
      $(".td_delete").addClass("hidden");
    })
    $("#delete-button").on("click", function() {
      $(".td_delete").removeClass("hidden");
      $(".td_edit").addClass("hidden");
    })
  </script>

</body>

</html>