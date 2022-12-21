<?php
include('./../function/db.php');

if (
  !isset($_GET['cost_id']) || $_GET['cost_id'] === ''
) {
  echo json_encode(["error_msg" => "no input"]);
  exit();
}

$cost_id = $_GET["cost_id"];

$pdo = connect_to_db();

$sql =
  'UPDATE fixed_cost_table
SET deleted_at=NOW()
WHERE  id=:cost_id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':cost_id', $cost_id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header("Location:./fixed_cost_list.php");
exit();
