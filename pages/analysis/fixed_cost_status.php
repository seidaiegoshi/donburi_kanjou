<?php
include("./../function/footer.php");
include('./../function/db.php');

$footer = footer("analysis");


$pdo = connect_to_db();

// 固定費一覧を取得
$sql = 'SELECT * FROM fixed_cost_table WHERE company_id = :company_id  AND deleted_at IS  NULL ORDER BY cost DESC';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':company_id', 1, PDO::PARAM_STR);


try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$fixed_cost_result = json_encode($result);

$table_element = "";
foreach ($result as $key => $record) {
  $table_element .= "
    <tr>
      <td>{$record["fixed_cost_name"]}</td>
      <td class='cost'>{$record["cost"]}<span class='yen'>円</span></td>
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
      <li>
        <a href="./monthly_graph.php">
          <div>
            損益分岐点
          </div>
        </a>
      </li>
      <li>
        <a href="./product_status.php">
          <div>
            商品分析
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
    <div id="piechart" style="width: 100%; height: 500px;"></div>

    <table>
      <thead>
        <tr>
          <td>固定費</td>
          <td>毎月の費用</td>
        </tr>
      </thead>
      <tbody>
        <?= $table_element ?>
      </tbody>
    </table>
  </section>

  <?= $footer ?>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    // phpからデータ取得
    const resultData = JSON.parse(`<?= $fixed_cost_result ?>`);
    console.log(resultData);

    // グラフデータ作成
    const graphData = [
      ['固定費名', '金額'],
    ];
    resultData.forEach(el => {
      graphData.push([el.fixed_cost_name, el.cost])
    });


    google.charts.load('current', {
      'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = google.visualization.arrayToDataTable(graphData);

      var options = {
        title: '固定費の割合',
        legend: {
          position: 'none',
        },
      };

      var chart = new google.visualization.PieChart(document.getElementById('piechart'));

      chart.draw(data, options);
    }
  </script>

</body>

</html>