<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Premier League Table</title>
    <link rel="stylesheet" href="premiertablestyle.css">
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
      <h2>Premier League Table</h2>
      <table style="width:90%" id="PremierLeagueTable">
        <tr>
          <th style="text-align:center">Rank</th>
          <th style="text-align:center">Club</th>
          <th style="text-align:center">MP</th>
          <th style="text-align:center">W</th>
          <th style="text-align:center">D</th>
          <th style="text-align:center">L</th>
          <th style="text-align:center">GF</th>
          <th style="text-align:center">GA</th>
          <th style="text-align:center">GD</th>
          <th style="text-align:center">Pts</th>
        </tr>

    <?php

		$sql = "SELECT * FROM pl_table";
		$pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=2021_comp10120_z1', 'r88993ia', 'dashboardsqlpass');
		$stmt = $pdo->query($sql);
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($row as $key => $value) {
			echo "<tr>";
			foreach ($value as $value2) {
				echo "<td>".$value2."</td>";
			}
			echo "</tr>";
		}
		?>

      </table>
    </center>
  </body>
</html>
