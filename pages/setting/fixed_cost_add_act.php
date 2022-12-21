<?php
include('./../function/db.php');

if (
  !isset($_POST['fixed_cost_name']) || $_POST['fixed_cost_name'] === '' ||
  !isset($_POST['cost']) || $_POST['cost'] === ''
) {
  echo json_encode(["error_msg" => "no input"]);
  exit();
}

$fixed_cost_name = $_POST["fixed_cost_name"];
$cost = $_POST["cost"];

$pdo = connect_to_db();

$sql = 'INSERT INTO  fixed_cost_table (id, company_id, fixed_cost_name, cost, created_at, deleted_at) VALUES(NULL, :company_id, :fixed_cost_name, :cost, now(), NULL)';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':company_id', 1, PDO::PARAM_STR);
$stmt->bindValue(':fixed_cost_name', $fixed_cost_name, PDO::PARAM_STR);
$stmt->bindValue(':cost', $cost, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header("Location:./fixed_cost_list.php");
exit();
