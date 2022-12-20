<?php
// var_dump($_GET);
$search_date = $_GET['search_date'];

include("./../function/db.php");

$pdo = connect_to_db();

$sql = 'SELECT id,product_name,unit FROM products_table WHERE company_id =:company_id AND (deleted_at >= :search_date OR deleted_at IS NULL)';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':company_id', 1, PDO::PARAM_STR);
$stmt->bindValue(':search_date', $search_date, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// axiosにデータを送る
echo json_encode($result);
