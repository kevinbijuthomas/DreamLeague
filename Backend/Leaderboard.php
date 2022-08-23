<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Leaderboard</title>
    <link rel="stylesheet" href="leaderboardstyle.css">
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
      <h2>Leaderboard</h2>
      <table style="width:90%" id="leaderboards">
        <tr>
          <th style="text-align:center">Position</th>
          <th style="text-align:center">Team Name</th>
          <!-- <th style="text-align:center">This Week's Points</th> -->
          <th style="text-align:center">Overall Points</th>
        </tr>
        <?php
          $sql = "SELECT * FROM users INNER JOIN teams ON users.username=teams.username ORDER BY total_pts DESC";
          $pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=2021_comp10120_z1', 'r88993ia', 'dashboardsqlpass');
          $stmt = $pdo->query($sql);
          $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
          for ($i=0; $i<count($row); $i++){
            echo "<tr>";
            echo "<td>".($i+1)."</td>";
            echo "<td>".$row[$i]['teamName']."</td>";
            echo "<td>".$row[$i]['total_pts']."</td>";
            echo "</tr>";
          }
        ?>  
      </table>
    </center>
  </body>
</html>
