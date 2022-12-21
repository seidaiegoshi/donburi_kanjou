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
    // その月の最初と最後を取得しておく。
    let thisDay = new Date(resultData[0].date);
    console.log(thisDay);
    thisDay.setDate(1)
    const firstDay = thisDay.getFullYear() + "-" + (thisDay.getMonth() + 1) + "-01";
    thisDay.setMonth(thisDay.getMonth() + 1);
    thisDay.setDate(0)
    const lastDay = thisDay.getFullYear() + "-" + (thisDay.getMonth() + 1) + "-" + thisDay.getDate();
    // console.log(firstDay);
    // console.log(lastDay);


    function getJustDate(date) {
      // 長い日付のときは、単に最後の日数だけ、1とか2とかきたら、01とか02とかで返す。
      return ("0" + date).slice(-2);
    }

    let total_profit = 0;
    const graphData = [];

    let day = 1;
    let index = 0;
    while (day <= getJustDate(lastDay)) {
      console.log(day, index);
      if (getJustDate(resultData[index]?.date) == getJustDate(day)) {
        // その日付にデータがあったら、データを登録する。
        total_profit += Number(resultData[index].day_profit);
        if (index === resultData.length) {
          // 最後のデータだったら、データラベルを追加する。
          graphData.push([getJustDate(day), sum_fixed_cost, "固定費", total_profit, "利益"])
        } else {
          graphData.push([getJustDate(day), sum_fixed_cost, "", total_profit, ""])
        }
        index++;
      } else {
        if (index >= resultData.length) {
          // もうデータがなかったら、空のデータで埋める。
          graphData.push([getJustDate(day), sum_fixed_cost, "", null, ""])
        } else {
          // データがまだありそうなら、累積粗利で埋める.これしないと、線がつながらない。
          graphData.push([getJustDate(day), sum_fixed_cost, "", total_profit, ""])
        }
      }
      day++;
    }

    // resultData.forEach((el, idx, arr) => {
    //   total_profit += Number(el.day_profit);
    //   if (idx === arr.length - 1) {

    //     if (el.date !== lastDay) {
    //       // 最後のデータが最終日じゃない場合は、最終日を追加する。
    //       graphData.push([getJustDate(lastDay), sum_fixed_cost, "", null, ""])
    //     }

    //   } else if (idx === 0 && el.date !== firstDay) {
    //     // 初日が月の開始日じゃない場合は、開始日を追加する。
    //     graphData.push([getJustDate(firstDay), sum_fixed_cost, "", 0, ""])
    //   } else {
    //     graphData.push([getJustDate(el.date), sum_fixed_cost, "", total_profit, ""])
    //   }
    // });
    console.log(graphData);

    google.charts.load('current', {
      'packages': ['corechart', 'line', "bar"]
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      // var data = google.visualization.arrayToDataTable(resultData);
      var data = new google.visualization.DataTable();
      data.addColumn("string", "日付");
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

      var options = {
        chartArea: {
          left: 140,
          right: 80,
        },
        hAxis: {
          title: "日付",
          textStyle: {
            fontSize: 10
          },
        },
        vAxis: {
          title: "金額",
        },
        title: '損益分岐点を知る',
        titleTextStyle: {
          color: '#333', // タイトルの文字色を指定
          fontSize: 24 // タイトルのフォントサイズを指定
        },
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