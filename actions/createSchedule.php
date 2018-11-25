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

$start = htmlspecialchars($_POST['start']);
$end = htmlspecialchars($_POST['end']);
$city = htmlspecialchars($_POST['city']);
$name = htmlspecialchars($_POST['name']);


$stmt = $pdo->prepare("INSERT INTO schedules (name, city, start, end) VALUES (?,?,?,?)");
$stmt->execute([$name, $city, $start, $end]);

header('Location: ../schedules.php');
?>
