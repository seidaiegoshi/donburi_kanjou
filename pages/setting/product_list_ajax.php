<?php
// var_dump($_GET);
$search_word = $_GET['search_word'];

include("./../function/db.php");

$pdo = connect_to_db();

$sql = 'SELECT * FROM products_table WHERE product_name LIKE :search_word';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':search_word', "%{$search_word}%", PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// axiosにデータを送る
echo json_encode($result);
