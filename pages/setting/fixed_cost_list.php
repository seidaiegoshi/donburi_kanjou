<?php
include("./../function/footer.php");
include('./../function/db.php');

$footer = footer();


// データベースに接続
$pdo = connect_to_db();


// 固定費の合計金額を取得
$sql = 'SELECT SUM(cost) AS sum_cost FROM fixed_cost_table
WHERE company_id =:company_id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':company_id', 1, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$sum_fixed_cost
  = $stmt->fetch(PDO::FETCH_ASSOC);

// 固定費一覧を取得
$sql = 'SELECT * FROM fixed_cost_table WHERE company_id = :company_id  AND deleted_at IS  NULL';

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
      <td>{$record["fixed_cost_name"]}</td>
      <td class='cost'>{$record["cost"]}<span class='yen'>円</span></td>
      <td class='td_edit'>
        <form action='./fixed_cost_edit.php' method='POST'>
        <input type='hidden' name='cost_id' value='{$record["id"]}'>
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

    <div class="sum_fixed_cost">
      <p>
        <span>固定費の合計</span>
        <span class="sum-cost"><?= $sum_fixed_cost["sum_cost"] ?></span><span class="yen">円</span>
        <span><a href="./../analysis/">グラフアイコン</a></span>
      </p>
    </div>
    <div class="search">
      <input id="search" type="text" placeholder="固定費名検索">
    </div>

    <div class="menu">
      <div>
        <div>
          <a href="./fixed_cost_add.php" class="button-main">固定費追加</a>
        </div>
      </div>
    </div>
    <div>
      <table>
        <thead>
          <tr>
            <td>固定費</td>
            <td>毎月の費用</td>
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
      const url = "./fixed_cost_list_ajax.php";
      axios
        .get(`${url}?search_word=${searchWord}`)
        .then(function(response) {
          htmlElement = "";
          response.data.forEach((record) => {
            htmlElement += `<tr>
            <td>${record.fixed_cost_name}</td>
            <td class="main_cost">${record.cost}<span class='yen'>円</span></td>
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
    let edit_mode = false;
    let delete_mode = false;
    // 編集・削除ボタン表示
    $("#edit-button").on("click", function() {
      if (edit_mode) {
        edit_mode = !edit_mode
        delete_mode = false;
        $(".td_edit").addClass("hidden");

      } else {
        edit_mode = !edit_mode
        delete_mode = true;
        $(".td_edit").removeClass("hidden");
        $(".td_delete").addClass("hidden");
      }

    })
    $("#delete-button").on("click", function() {
      if (delete_mode) {
        delete_mode = !delete_mode
        edit_mode = false;
        $(".td_delete").addClass("hidden");

      } else {
        delete_mode = !delete_mode
        edit_mode = true;
        $(".td_delete").removeClass("hidden");
        $(".td_edit").addClass("hidden");
      }

    })
  </script>

</body>

</html>