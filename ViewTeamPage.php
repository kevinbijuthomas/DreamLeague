<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>My Team</title>
	<link rel="stylesheet" href="viewteam.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	
</head>
<body>
	<?php
		session_start();
		$username = $_SESSION['username'];
		$teamName = $_SESSION['teamName'];

		$sql = "SELECT * FROM updates";
		$pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=2021_comp10120_z1', 'r88993ia', 'dashboardsqlpass');
		$stmt = $pdo->query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($row['skip']==0){
			if (time() < strtotime("14-05-2022")){
	          $week = "week0stats";
	        } elseif (time() > strtotime("14-05-2022") && time() < strtotime("21-05-2022")){
	          $week = "week1stats";
	        } else{
	          $week = "week2stats";
	        }
		} else
			$week = $row['week']."stats";
		
		if (!isset($username))
			header("Location:log_or_sign.html");

		
		function getPlayersFromTeamsTable($usern){
			$sql = "SELECT * FROM teams WHERE username ='$usern'";
			$pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=2021_comp10120_z1', 'r88993ia', 'dashboardsqlpass');
			$stmt = $pdo->query($sql);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			
			$idsList = array();
			$positions = array();
			foreach ($row as $key => $value) {
				$idsList[] = $value;
				$positions[] = $key;
			}
			unset($idsList[0]);
			unset($idsList[16]);
			$idsList = array_values($idsList);

			unset($positions[0]);
			unset($positions[16]);
			$positions = array_values($positions);

			$namesList = array();
			foreach ($idsList as $playerId) {		
				$sql = "SELECT name FROM players1 WHERE id =".$playerId;
				$stmt = $pdo->query($sql);
				$row1 = $stmt->fetch(PDO::FETCH_ASSOC);
				$namesList[] = $row1['name']; 
			}
			
			return array($namesList, $positions, $idsList);
		}

		function getPts($ids, $week){
			$points = [];
			foreach ($ids as $playerId) {
				$sql = "SELECT pts FROM $week WHERE id=$playerId";
				$pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=2021_comp10120_z1', 'r88993ia', 'dashboardsqlpass');
				$stmt = $pdo->query($sql);
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$points[] = $row['pts']; 
			}
			return $points;
		}

		$playersInfo = getPlayersFromTeamsTable($username);
		$names = $playersInfo[0];
		$positions = $playersInfo[1];
		$ids = $playersInfo[2];
		if ($week == "week0stats"){
			$points = array();
			$points = array_fill(0, 15, 0);
		} else 
			$points = getPts($ids, $week);

		$weekTotal = $points;

		unset($weekTotal[1]); 
		unset($weekTotal[6]); 
		unset($weekTotal[11]); 
		unset($weekTotal[14]);
		$weekTotal = array_values($weekTotal);
		$weekTotal = array_sum($weekTotal);
	?>
	
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
		<h1><?php echo $teamName ?></h1>
		<h3 >This Week's Points: <?php echo $weekTotal ?></h3>
		<div id="pitch">
			<br><br><br><br><br><br><br>
			<!-- ATTACKERS -->
			<div class="container">
				<?php 
				for ($i=13; $i>11; $i--){
					echo '<div class="card">
					    <br>
					    <span style="display:none;">'.$positions[$i].'</span>
					    <img src="kit.jpeg" class="kitimg">
					    <p>
						    <b>'.$names[$i].'</b>
						    <br>
						    Points: '.$points[$i].'
					    </p>
				      </div>';
				}
				?>
			</div>
			<br><br><br>
			<!-- MIDFIELDERS -->
			<div class="container">
				<?php 
				for ($i=10; $i>6; $i--){
					echo '<div class="card">
					    <br>
					    <span style="display:none;">'.$positions[$i].'</span>
					    <img src="kit.jpeg" class="kitimg">
					    <p>
						    <b>'.$names[$i].'</b>
						    <br>
						    Points: '.$points[$i].'
					    </p>
				      </div>';
				}
				?>
			</div>
			<br><br><br>
			<!-- DEFENDERS -->
			<div class="container">
				<?php 
				for ($i=5; $i>1; $i--){
					echo '<div class="card">
					    <br>
					    <span style="display:none;">'.$positions[$i].'</span>
					    <img src="kit.jpeg" class="kitimg">
					    <p>
						    <b>'.$names[$i].'</b>
						    <br>
						    Points: '.$points[$i].'
					    </p>
				      </div>';
				}
				?>
			</div>
			<br><br><br>
			<!-- GOALKEEPER -->
			<div class="container">
				<div class="card">
					<br>
					<span style="display:none;"><?php echo $positions[0] ?></span>
					<img src="kit.jpeg" class="kitimg">
					<p>
						<b><?php echo $names[0]?></b>
						<br>
						Points: <?php echo $points[0]?>
					</p>
				</div>
			</div>
			<br><br><br><br><br>
		</div>
		<h2><br>Substitutes<br></h2>
		<div id="substitutes">
			<?php
				$subsInds = array(14, 11, 6, 1);
				foreach ($subsInds as $value) {
					echo '<div class="card">
						<span style="display:none;">'.$positions[$value].'</span>
					    <br>
					    <img src="kit.jpeg" class="kitimg">
					    <p>
						    <b>'.$names[$value].'</b>
						    
						    <br>
						    Points: '.$points[$value].'
					    </p>
				      </div>';
				}
			?>
		</div>
	</center>
	<br><br><br><br><br>
	<script>
		$(document).ready(function(){
			var $count = 0;
			$(".card").click(function(){
				// The class 'act' gives the blue outline to show it has been selected
				if ($(this).hasClass('act')) {
					// If the card has already been selected, deselect it
					$(this).removeClass('act');
					$count = $count - 1;
				} else {
					// Select the card. If 2 cards have been selected, then switch the content and deselect them
					$(this).addClass('act');
					$count = $count + 1;
					if ($count > 1) {
						var elements = document.getElementsByClassName('act');

						// Create a regular expression pattern to extract the positions of the swapped players
						const regex = /^[\s|\n]*([A-Z]+[a-z|0-9]+)\s/;

						// .textContent returns everything inside the card(position, name, points)
						// Use the above pattern to get the position only
						var player1 = elements[0].textContent;
        				var pos1 = regex.exec(player1);

						var player2 = elements[1].textContent;
        				var pos2 = regex.exec(player2);

						var span1 = elements[0].getElementsByTagName("span")[0].innerHTML;
						var span2 = elements[1].getElementsByTagName("span")[0].innerHTML;

						div1_content = elements[0].innerHTML;
						div2_content = elements[1].innerHTML;
						elements[0].innerHTML = div2_content;
						elements[1].innerHTML = div1_content;

						elements[0].getElementsByTagName("span")[0].innerHTML = span1;
						elements[1].getElementsByTagName("span")[0].innerHTML = span2;

						// Ajax- pass the two positions to updateTeam.php file
						// updateTeam.php will run on the server and will swap the two players in the database 
						aj = new XMLHttpRequest();
						aj.open("POST", "updateTeam.php");
						aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						aj.send("pos1="+pos1[1] + "&pos2="+pos2[1]);

						$(".card").each(function(){
			       	$(this).removeClass('act');
							$count = 0;
			    	});
					}
				}
			});
		});
	</script>
</body>
</html>
