<?php
// var_dump($_GET);
$first_day = $_GET['first_day'];
$last_day = $_GET['last_day'];

include("./../function/db.php");

$pdo = connect_to_db();

$sql =
  'SELECT date,SUM((quantity*gross_profit))AS day_profit FROM sale_table
INNER JOIN (
	SELECT id,product_name,gross_profit FROM products_table
) AS result
ON sale_table.product_id = result.id
WHERE company_id = :company_id AND (date between :first_day AND :last_day)
GROUP BY date
ORDER BY date';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':company_id', 1, PDO::PARAM_STR);
$stmt->bindValue(':first_day', $first_day, PDO::PARAM_STR);
$stmt->bindValue(':last_day', $last_day, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// axiosにデータを送る
echo json_encode($result);
