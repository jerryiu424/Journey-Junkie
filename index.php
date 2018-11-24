<h1>Hack Westernatron 5000</h1>

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

$schedule_id = 2;
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


$stmt = $pdo->prepare('SELECT * FROM schedules WHERE id = 2');
$stmt->execute();

foreach($stmt as $row) {
    echo "<h2>" . $row['name'] . "</h2>";
    echo "<p>Jason will be biggest fan, himself in " . $row['city'] . "</p>";
    $starttime = strtotime($row['start']);
    $starttime = $starttime - ($starttime % 3600);
    $endtime = strtotime($row['end']);
    $endtime = $endtime - ($endtime % 3600);
    $length = round(($endtime - $starttime) / 3600, 0);
    echo "<p>Our lord and saviour Mr Cluckles will be on tour with Jason for an entire " . $length . " hours. Isn't that wonderful?";

    echo "<table width='100%;'><tr><th>Time</th><th>Thing</th><tr>";

    $i = 0;
    $currenttime = $starttime;

    while ($i <= $length) {
      $thisevent = "";
      foreach($items as $event) {
          if($currenttime == $event['time']) {
            $thisevent = $event['description'];
          }
      }

      echo "<tr><td>" .  gmdate("H:i:s d-m-Y ", $currenttime) . "</td><td>$thisevent</td></tr>";
      $i++;
      $currenttime = $currenttime + 3600;
    }
    echo "</table>";

}
