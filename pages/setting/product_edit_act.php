<?php
include('./../function/db.php');

if (
  !isset($_POST['product_id']) || $_POST['product_id'] === '' ||
  !isset($_POST['product_name']) || $_POST['product_name'] === '' ||
  !isset($_POST['unit']) || $_POST['unit'] === '' ||
  !isset($_POST['main_cost']) || $_POST['main_cost'] === '' ||
  !isset($_POST['sub_cost']) || $_POST['sub_cost'] === '' ||
  !isset($_POST['selling_price']) || $_POST['selling_price'] === ''
) {
  echo json_encode(["error_msg" => "no input"]);
  exit();
}

$product_id = $_POST["product_id"];
$product_name = $_POST["product_name"];
$unit = $_POST["unit"];
$main_cost = $_POST["main_cost"];
$sub_cost = $_POST["sub_cost"];
$selling_price = $_POST["selling_price"];
$gross_profit = $selling_price - $main_cost - $sub_cost;
$gross_profit_rate = $gross_profit / $selling_price * 100;

$pdo = connect_to_db();

$sql = 'UPDATE products_table 
SET id=:product_id, company_id=:company_id, product_name=:product_name, unit=:unit, main_cost=:main_cost, sub_cost=:sub_cost, selling_price=:selling_price, gross_profit=:gross_profit, gross_profit_rate=:gross_profit_rate
WHERE id = :product_id
';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':product_id', $product_id, PDO::PARAM_STR);
$stmt->bindValue(':company_id', 1, PDO::PARAM_STR);
$stmt->bindValue(':product_name', $product_name, PDO::PARAM_STR);
$stmt->bindValue(':unit', $unit, PDO::PARAM_STR);
$stmt->bindValue(':main_cost', $main_cost, PDO::PARAM_STR);
$stmt->bindValue(':sub_cost', $sub_cost, PDO::PARAM_STR);
$stmt->bindValue(':selling_price', $selling_price, PDO::PARAM_STR);
$stmt->bindValue(':gross_profit', $gross_profit, PDO::PARAM_STR);
$stmt->bindValue(':gross_profit_rate', $gross_profit_rate, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header("Location:./product_list.php");
exit();
