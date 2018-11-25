<?php
$host = 'localhost';
$db   = 'journeyjunkie';
$user = 'user';
$pass = 'pass';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$schedule_id = htmlspecialchars($_GET['schedule']);
$items = [];

$stmt = $pdo->prepare("SELECT * FROM schedule_items WHERE schedule_id = ?");
$stmt->execute([$schedule_id]);
foreach($stmt as $row) {
  $start = strtotime($row['start']);

  $i = 0;
  $currenttime = $start;
  while ($i < $row['length']) {
    $items[] = ["time" => $currenttime, "description" => $row['description'], "place" => $row['placeid']];
    $i++;
    $currenttime = $currenttime + 3600;
  }
}

header('Content-Type: application/json');
echo json_encode($items);
