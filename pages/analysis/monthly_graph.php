<?php
include("./../function/footer.php");
include('./../function/db.php');

$footer = footer("setting");

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

$result
  = $stmt->fetch(PDO::FETCH_ASSOC);
$sum_fixed_cost = $result["sum_cost"];

// 利益の推移を取得
$sql = 'SELECT date,SUM((quantity*gross_profit))AS day_profit FROM sale_table
INNER JOIN (
	SELECT id,product_name,gross_profit FROM products_table
) AS result
ON sale_table.product_id = result.id
WHERE company_id = :company_id AND date between date_format(now(), "%Y-%m-01") and last_day(now())
GROUP BY date
ORDER BY date';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':company_id', 1, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$result
  = $stmt->fetchAll(PDO::FETCH_ASSOC);
$month_result = json_encode($result);

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
          損益分岐点
        </div>
      </li>
      <li>
        <a href="./product_status.php">
          <div>
            商品分析
          </div>
        </a>
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
    <div>
      <div id="curve_chart" style="width: 100%; height: 80vh"></div>
    </div>
  </section>


  <?= $footer ?>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    const sum_fixed_cost = Number("<?= $sum_fixed_cost ?>");

    const resultData = JSON.parse(`<?= $month_result ?>`);

    console.log(resultData);
    let total_profit = 0;
    const graphData = [];
    resultData.forEach((el, idx, arr) => {
      total_profit += Number(el.day_profit);
      if (idx === arr.length - 1) {
        graphData.push([el.date, sum_fixed_cost, "固定費", total_profit, "利益"])
      } else {
        graphData.push([el.date, sum_fixed_cost, "", total_profit, ""])
      }
    });
    console.log(graphData);

    google.charts.load('current', {
      'packages': ['corechart', 'line', "bar"]
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      // var data = google.visualization.arrayToDataTable(resultData);
      var data = new google.visualization.DataTable();
      data.addColumn("string", "X");
      data.addColumn("number", "固定費");
      data.addColumn({
        type: 'string',
        role: 'annotation'
      });
      data.addColumn("number", "利益");
      data.addColumn({
        type: 'string',
        role: 'annotation'
      });
      data.addRows(graphData)
      // data.addRows([
      //   ['1', 1000, "", 400, ""],
      //   ['15', 1000, "", 1120, ""],
      //   ['30', 1000, "固定費", 1300, "利益"]
      // ])

      var options = {
        hAxis: {
          title: "日付",
        },
        vAxis: {
          title: "金額",
        },
        title: '○月の損益分岐点',
        legend: {
          position: 'none',
        },
        annotations: {
          stem: {
            // 軸の色
            color: '#fff',
            // 軸の長さ
            length: 10,
          },
        },

        pointShape: 'circle',
        series: {
          0: {
            lineWidth: 3,
            pointSize: 1,
            annotations: {
              textStyle: {
                color: '#EA4060',
              },
            },
            color: '#EA4060',
          },
          1: {
            lineWidth: 3,
            pointSize: 10,
            annotations: {
              textStyle: {

                fontSize: 20,
                color: '#038EC7',
              },
            },
            color: '#038EC7',
          },

        },

      };

      var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

      chart.draw(data, options);
    }
  </script>

</body>

</html>