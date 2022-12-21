<?php
// 各種項目設定
function connect_to_db()
{
  $database_name = "donburi";
  $dbn = "mysql:dbname={$database_name};charset=utf8mb4;port=3306;host=localhost";
  $user = 'root';
  $pwd = '';

  // DB接続
  try {
    return new PDO($dbn, $user, $pwd);
    // exit("ok");
  } catch (PDOException $e) {
    echo json_encode(["db error" => "{$e->getMessage()}"]);
    exit();
  }
}
