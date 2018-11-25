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

$items = '';

$stmt = $pdo->prepare("SELECT * FROM schedules");
$stmt->execute();
foreach($stmt as $row) {
  $items .= '<li class="list-group-item"><a href="./schedule.php?schedule='. $row['id'] .'">'.$row['name'].'</a></li>';

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Planning uncertainty, begone!</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
    crossorigin="anonymous">
  <link rel="stylesheet" href="resources/css/style.css">
</head>

<body>
  <!-- NavBar -->
  <nav class="navbar navbar-dark bg-dark navbar-expand-lg">
    <a class="navbar-brand" href="./index.html"><img src="resources/images/Logo Resources/Logo.png" alt="Journey Junkie" class="brandImg"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02"
      aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0 ">
        <li class="nav-item">
          <a class="nav-link" href="./explore.html">Explore Journeys</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./itinerary.html">Itinerary</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./about.html">About Us</a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <input id="myInput" class="form-control mr-sm-2" type="search" placeholder="I'm headed to...">
        <button id="myBtn" class="btn btn-success btn-click my-2 my-sm-0" type="submit"><img class="NavBarButtonImg" src="resources/images/Logo Resources/NavBarSearchButton.png" alt=""></button>
      </form>
    </div>
  </nav>
<!-- NavBar End -->
<!-- Landing -->
<div class="bg">
  <div class="container">
      <h2>
        Itinerary Name
      </h2>
      <div class="card">
      <ul class="list-group list-group-flush">

        <?php
          echo $items;
        ?>
      </ul>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="event-name"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="event-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
  <!-- Landing End -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
    crossorigin="anonymous"></script>
    <script src="resources/js/app.js"></script>
</body>

</html>
