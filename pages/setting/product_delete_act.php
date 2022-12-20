<?php
include('./../function/db.php');

if (
  !isset($_GET['product_id']) || $_GET['product_id'] === ''
) {
  echo json_encode(["error_msg" => "no input"]);
  exit();
}

$product_id = $_GET["product_id"];

$pdo = connect_to_db();

$sql = 'DELETE FROM products_table
WHERE id = :product_id
';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':product_id', $product_id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header("Location:./product_list.php");
exit();
