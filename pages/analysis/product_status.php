<?php
include("./../function/footer.php");
include('./../function/db.php');

$footer = footer("analysis");

// データベースに接続
$pdo = connect_to_db();

// 商品一覧の情報を取得
$sql = 'SELECT * FROM `products_table`
INNER JOIN(
    SELECT product_id, SUM(quantity)AS cumulative_quantity FROM sale_table
    GROUP BY product_id
) AS result ON products_table.id = result.product_id
WHERE company_id = :company_id AND deleted_at IS  NULL
ORDER BY cumulative_quantity DESC';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':company_id', 1, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$products_status_result = json_encode($result);
$table_element = "";
foreach ($result as $key => $record) {
  $gross_profit_rate = number_format($record["gross_profit_rate"], 2);
  $table_element .= "
    <tr>
      <td>{$record["product_name"]}</td>
      <td class='main_cost'>{$record["main_cost"]}<span class='yen'>円</span></td>
      <td class='sub_cost'>{$record["sub_cost"]}<span class='yen'>円</span></td>
      <td class='selling_price'>{$record["selling_price"]}<span class='yen'>円</span></td>
      
      <td class='gross_profit'>{$record["gross_profit"]}<span class='yen'>円</span></td>
      <td class='gross_profit_rate'>{$gross_profit_rate}<span class='yen'>%</span></td>
      <td class='cumulative_quantity'>{$record["cumulative_quantity"]}<span class='yen'>{$record["unit"]}</span></td>

      
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
  <section class="main">
    <div id="piechart" style="width: 100%; height: 500px;"></div>
    <table>
      <thead>
        <tr>
          <td>商品名</td>
          <td>主原価</td>
          <td>副原価</td>
          <td>売値</td>
          <td>粗利</td>
          <td>粗利率</td>
          <td>累計販売数</td>
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
    const resultData = JSON.parse(`<?= $products_status_result ?>`);
    console.log(resultData);

    // グラフデータ作成
    const graphData = [
      ['商品名', '粗利',
        {
          role: 'annotation'
        },
        "変動費(主原価+副原価)",
      ],
    ];
    resultData.forEach(el => {
      graphData.push([el.product_name, el.gross_profit, Math.floor(el.gross_profit_rate) + "%", el.main_cost + el.sub_cost])
    });


    google.charts.load('current', {
      'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = google.visualization.arrayToDataTable(graphData);

      var options = {
        chartArea: {
          left: 110,
          right: 20,
          // top: 50,
        },
        legend: {
          position: 'top',
        },
        hAxis: {
          title: "販売価格(円)",
          minValue: 0,
          maxValue: 100,
        },
        vAxis: {
          title: "商品名",
        },
        isStacked: true,
      };

      var chart = new google.visualization.BarChart(document.getElementById('piechart'));

      chart.draw(data, options);
    }
  </script>
</body>

</html>