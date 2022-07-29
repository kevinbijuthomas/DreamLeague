<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Fixtures and Results</title>
    <link rel="stylesheet" href="fixturesstyle.css">
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
    <center>
      <br><br><br><br><br>
      <table style="width:90%" id="fixturesandresults">
        <tr>
          <th style="text-align:center" colspan="3">Upcoming Fixtures</th>
        </tr>

        <?php
        session_start();
        $sql = "SELECT * FROM updates";
        $pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=2021_comp10120_z1', 'r88993ia', 'dashboardsqlpass');
        $stmt = $pdo->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['skip']==0){
          if (time() < strtotime("06-05-2022")){
            $fixturesTable = 'week1';
            $resultsTable = 'na';
          } elseif (time() > strtotime("06-05-2022") && time() < strtotime("13-05-2022")){
            $fixturesTable = 'week2';
            $resultsTable = 'week1';
          } else{
            $fixturesTable = 'week3';
            $resultsTable = 'week2';
          }

        } else{
          if ($row['week'] == 'week0'){
            $fixturesTable = 'week1';
            $resultsTable = 'na';
          } elseif ($row['week'] == 'week1'){
            $fixturesTable = 'week2';
            $resultsTable = 'week1';
          } else{
            $fixturesTable = 'week3';
            $resultsTable = 'week2';
          }
        }

        $sql = "SELECT team1, team2 FROM $fixturesTable";
        $pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=2021_comp10120_z1', 'r88993ia', 'dashboardsqlpass');
        $stmt = $pdo->query($sql);
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($row as $match => $value) {
          echo "<tr>";
          echo "<td>".$value['team1']."</td>";
          echo "<td>v</td>";
          echo "<td>".$value['team2']."</td>";
          echo "</tr>";
        }
        ?>
        
      </table>
      <br><br><br><br><br>
      <?php
      if (!($resultsTable == 'na')){?>
        <table style="width:90%" id="fixturesandresults">

          <tr>
            <th style="text-align:center" colspan="3">Previous Results</th>
          </tr>

          <?php 
          $sql = "SELECT * FROM $resultsTable";
          $pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=2021_comp10120_z1', 'r88993ia', 'dashboardsqlpass');
          $stmt = $pdo->query($sql);
          $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

          foreach ($row as $match => $value) {
            echo "<tr>";
            echo "<td style='text-align:center'>".$value['team1']."</td>";
            echo "<td>".$value['team1S']." - ".$value['team2S']."</td>";
            echo "<td style='text-align:center'>".$value['team2']."</td>";
            echo "</tr>";
          }
        }
        ?>

      </table>
    </center>
  </body>
</html>
