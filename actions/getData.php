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
$formattedTime = date("Y-m-d H:i:s",$time);
$desc = htmlspecialchars($_GET['desc']);
$place = htmlspecialchars($_GET['placeid']);


$response = file_get_contents("https://jackbiggin.lib.id/hackwestern@dev/getLocationInfo/?placeid=" . $place);
$response = json_decode($response, true);
$response['description'] = $desc;

header('Content-Type: application/json');
echo json_encode($response);


 ?>
