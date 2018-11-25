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

$time = htmlspecialchars($_GET['time']);
$place_id = htmlspecialchars($_GET['place_id']);
$schedule_id = htmlspecialchars($_GET['schedule_id']);
$description = htmlspecialchars($_GET['name']);

$time = date("Y-m-d H:i:s", $time);

$stmt = $pdo->prepare("INSERT INTO schedule_items (schedule_id, start, end, placeid, length, description) VALUES (?,?,?,?,?,?)");
$stmt->execute([$schedule_id, $time, $time + 3600, $place_id, 1, $description]);

?>
