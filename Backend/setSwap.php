<?php
session_start();
echo $_SESSION['toSwap'] = $_POST['playerPosition'];
?>