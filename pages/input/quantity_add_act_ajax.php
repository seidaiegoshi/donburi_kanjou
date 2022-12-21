<?php
include('./../function/db.php');

if (
  !isset($_GET['product_id']) || $_GET['product_id'] === '' ||
  !isset($_GET['quantity']) || $_GET['quantity'] === '' ||
  !isset($_GET['date']) || $_GET['date'] === ''
) {
  echo json_encode(["error_msg" => "no input"]);
  exit();
}

$product_id = $_GET["product_id"];
$quantity = $_GET["quantity"];
$date = $_GET["date"];

$pdo = connect_to_db();


// すでに登録されているか確認する。
$sql = "SELECT COUNT(*) FROM sale_table
WHERE company_id=:company_id AND product_id=:product_id AND date=:date
";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':company_id', 1, PDO::PARAM_STR);
$stmt->bindValue(':product_id', $product_id, PDO::PARAM_STR);
$stmt->bindValue(':date', $date, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$is_exist = $stmt->fetchColumn();



if ($is_exist > 0) {
  // データが有る場合はUPDATE
  $sql = 'UPDATE  sale_table
  SET quantity=:quantity
  WHERE company_id=:company_id AND  product_id=:product_id AND date=:date
  ';

  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':company_id', 1, PDO::PARAM_STR);
  $stmt->bindValue(':product_id', $product_id, PDO::PARAM_STR);
  $stmt->bindValue(':quantity', $quantity, PDO::PARAM_STR);
  $stmt->bindValue(':date', $date, PDO::PARAM_STR);

  try {
    $status = $stmt->execute();
  } catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
  }
} else {
  // データがない場合はINSERT
  $sql = 'INSERT INTO  sale_table (id, company_id, product_id, quantity, date) VALUES(NULL, :company_id, :product_id, :quantity, :date)';

  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':company_id', 1, PDO::PARAM_STR);
  $stmt->bindValue(':product_id', $product_id, PDO::PARAM_STR);
  $stmt->bindValue(':quantity', $quantity, PDO::PARAM_STR);
  $stmt->bindValue(':date', $date, PDO::PARAM_STR);

  try {
    $status = $stmt->execute();
  } catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
  }
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($result);
