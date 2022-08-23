<?php
function updateTeam($un, $col1, $col2){
	$sql = "SELECT $col1 FROM teams WHERE username ='$un'";
	$pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=2021_comp10120_z1', 'r88993ia', 'dashboardsqlpass');
	$stmt = $pdo->query($sql);
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$col1Value = $row[$col1];

	$sql = "UPDATE teams SET $col1=$col2, $col2=? WHERE username ='$un'";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$col1Value]);
}
session_start();
if (!isset($_SESSION['username']))
	header("Location:log_or_sign.html");
	
updateTeam($_SESSION['username'], $_POST['pos1'], $_POST['pos2']);
?>