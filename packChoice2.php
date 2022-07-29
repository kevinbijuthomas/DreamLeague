 <!DOCTYPE html>  
 <html lang="en">  
 <head>  
   <meta charset="UTF-8">  
   <meta http-equiv="X-UA-Compatible" content="IE=edge">  
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Weekly Pack</title>  
   <style type="text/css">
    html {
        height: 100%;
    }
    body {
       margin: 0;
       padding: 0;
       /* font-family: arial; */
       background: linear-gradient(#28313B, #485461);
     }
     .wrapper{
       display:flex;
       justify-content: center;
       align-items:center;
     }
     .outer{
       width:300px;
       height:50px;
       border-radius:10px;
       padding:5px;
     }
     .outer:hover{
       animation-name:rotate;
       animation-iteration-count:infinite;
       animation-duration:1s;
       animation-delay: 0ms;
       background-color: rgb(23, 248, 248);
     }
     .outer:hover a{
       color:aqua;
     }
     @keyframes rotate {
       from{
         filter: hue-rotate(0deg);
       }
       to{
         filter:hue-rotate(360deg);
       }
     }
     .inner{
       width:100%;
       height:100%;
       display:flex;
       justify-content: center;
       align-items:center;
       background: black;
       border-radius:10px;
     }

    .inner a{
       color:white;
       text-decoration:none;
       font-weight: 900;
       font-size:25px;
     }

     ul {
       font-family: arial;
       list-style-type: none;
       margin: 0;
       padding: 0;
       overflow: hidden;
       background-color: #333;
     }

    li {
      float: left;
    }

    li a {
      display: block;
      color: white;
      text-align: center;
      padding: 14px 16px;
      text-decoration: none;
    }

    li a:hover {
      background-color: #111;
    }

    .active {
      background-color: #04AA6D;
    }

    #heading {
        color: white;
        top: 80px;
        font-size: 50px;
        font-style: italic;
        text-align: center;
    }
   </style>
 </head>  
 <body>
  <ul>
   <li><a class="active" href="ViewTeamPage.php">View Team</a></li>
   <li><a href="Leaderboard.php">Leaderboard</a></li>
   <li><a href="FixturesAndResults.php">Fixtures and Results</a></li>
   <li><a href="PremierLeagueTable.php">Premier League Table</a></li>
   <li><a href="HowToPlay.html">How to Play</a></li>
   <li><a href="packChoice2.php">Weekly Pack</a></li>
   <li style="float:right"><b><a href="logout.php">Log Out</a></b></li>
  </ul>
  <br><br>
  <h1 id="heading">You can only open one of the three packs each week</h1><br>
  <div class="wrapper">
  <?php

  session_start();
  if (!isset($_SESSION['username']))
    header("Location:log_or_sign.html");

  $username = $_SESSION['username'];
  
  $sql = "SELECT nextFriday, openedPacks, fridaysPassed FROM users WHERE username ='$username'";
  $pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=2021_comp10120_z1', 'r88993ia', 'dashboardsqlpass');
  $stmt = $pdo->query($sql);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  $nextFriday = $row['nextFriday'];
  $openedPacks = $row['openedPacks'];
  $fridaysPassed = $row['fridaysPassed'];


  if (time() > $nextFriday){
    $sql = "UPDATE users SET nextFriday=?, fridaysPassed=? WHERE username ='$username'";
    $fridaysPassed++;
    $nextFriday = strtotime('next friday');
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nextFriday, $fridaysPassed]);
  }

  if ($openedPacks < $fridaysPassed){

    function getMidfielder(){
      $sql = "SELECT id, name FROM players1 WHERE position = 'Midfielder' ORDER BY RAND() LIMIT 1";
      $pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=2021_comp10120_z1', 'r88993ia', 'dashboardsqlpass');
      $stmt = $pdo->query($sql);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      return array($row['id'], $row['name']);
    }

    function getAttacker(){
      $sql = "SELECT id, name FROM players1 WHERE position = 'Attacker' ORDER BY RAND() LIMIT 1";
      $pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=2021_comp10120_z1', 'r88993ia', 'dashboardsqlpass');
      $stmt = $pdo->query($sql);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      return array($row['id'], $row['name']);
    }

    function getDefender(){
      $positions = ['Defender', 'Goalkeeper'];
      $position = $positions[rand(0,1)];
      $sql = "SELECT id, name FROM players1 WHERE position = '$position' ORDER BY RAND() LIMIT 1";
      $pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=2021_comp10120_z1', 'r88993ia', 'dashboardsqlpass');
      $stmt = $pdo->query($sql);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      return array($row['id'], $row['name'], $position);
    }

    $_SESSION['attackerW'] = getAttacker();
    $_SESSION['midfielderW'] = getMidfielder();
    $_SESSION['defenderW'] = getDefender();

    ?>

    <div class="outer">  
     <div class="inner">  
       <a href="swapAttacker.php">Open Attacker Pack</a>  
     </div>  
   </div>  
   <div class="outer">  
     <div class="inner">  
       <a href="swapMidfielder.php">Open Midfielder Pack</a>  
     </div>  
   </div> 
   <div class="outer">  
     <div class="inner">  
       <a href="swapDefender.php">Open Defender Pack</a>  
     </div>  
   </div>  

  <?php
  } else{
    $time_left = $nextFriday - time();

    $days = floor($time_left / (60*60*24));
    $time_left %= (60 * 60 * 24);

    $hours = floor($time_left / (60 * 60));
    $time_left %= (60 * 60);

    $min = floor($time_left / 60);
    $time_left %= 60;

    echo "<h1 style='color:limegreen; padding-right:15px;'>Next set of packs available in:";
    echo "<h2 style='color:limegreen;'>$days Days $hours Hours and $min Mins</h2>";

  }

  ?>
   </div>

 </body>  
 </html>