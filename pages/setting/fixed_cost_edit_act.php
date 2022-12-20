<?php
include('./../function/db.php');

if (
  !isset($_POST['cost_id']) || $_POST['cost_id'] === '' ||
  !isset($_POST['fixed_cost_name']) || $_POST['fixed_cost_name'] === '' ||
  !isset($_POST['cost']) || $_POST['cost'] === ''
) {
  echo json_encode(["error_msg" => "no input"]);
  exit();
}

$cost_id = $_POST["cost_id"];
$fixed_cost_name = $_POST["fixed_cost_name"];
$cost = $_POST["cost"];

$pdo = connect_to_db();

$sql =
  'UPDATE fixed_cost_table
SET fixed_cost_name=:fixed_cost_name,  cost=:cost
WHERE  id=:cost_id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':cost_id', $cost_id, PDO::PARAM_STR);
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
