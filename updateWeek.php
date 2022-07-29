<?php

session_start();
function countTotalW1(){
    $sql = "SELECT username FROM teams";
    $pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=2021_comp10120_z1', 'r88993ia', 'dashboardsqlpass');
    $stmt = $pdo->query($sql);
    $row1 = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($row1 as $key => $value) {
        $usern = $value['username'];
        $sql = "SELECT * FROM teams WHERE username ='$usern'";
        
        $stmt = $pdo->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $idsList = array();
        foreach ($row as $key => $value) {
            $idsList[] = $value;
            $positions[] = $key;
        }
        unset($idsList[0]);
        unset($idsList[2]);
        unset($idsList[7]);
        unset($idsList[12]);
        unset($idsList[15]);
        unset($idsList[16]);
        $idsList = array_values($idsList);

        $totalPoints = 0;
        foreach ($idsList as $playerId) {       
            $sql = "SELECT pts FROM week1stats WHERE id =".$playerId;
            $stmt = $pdo->query($sql);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $totalPoints += $row['pts']; 
        }

        $sql = "UPDATE teams SET total_pts=$totalPoints WHERE username='$usern'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        }
}

function countTotalW2(){
    countTotalW1();
    $sql = "SELECT username FROM teams";
    $pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=2021_comp10120_z1', 'r88993ia', 'dashboardsqlpass');
    $stmt = $pdo->query($sql);
    $row1 = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($row1 as $key => $value) {
        $usern = $value['username'];
        $sql = "SELECT * FROM teams WHERE username ='$usern'";
        
        $stmt = $pdo->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $idsList = array();
        foreach ($row as $key => $value) {
            $idsList[] = $value;
        }
        unset($idsList[0]);
        unset($idsList[2]);
        unset($idsList[7]);
        unset($idsList[12]);
        unset($idsList[15]);
        unset($idsList[16]);
        $idsList = array_values($idsList);

        $totalPoints = 0;
        foreach ($idsList as $playerId) {       
            $sql = "SELECT pts FROM week2stats WHERE id =".$playerId;
            $stmt = $pdo->query($sql);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $totalPoints += $row['pts']; 
        }

        $sql = "UPDATE teams SET total_pts=(total_pts + $totalPoints) WHERE username='$usern'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        }
}

if (isset($_POST['week'])) {
    switch ($_POST['week']) {
        case 'week0':
            // $_SESSION['week'] = 'week0';
            $sql = "UPDATE updates SET week='week0', skip=0";
            $pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=2021_comp10120_z1', 'r88993ia', 'dashboardsqlpass');
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            $sql = "UPDATE teams SET total_pts=0";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            break;
        case 'week1stats':
            // $_SESSION['week'] = 'week1';
            $sql = "UPDATE updates SET week='week1', skip=1";
            $pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=2021_comp10120_z1', 'r88993ia', 'dashboardsqlpass');
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            countTotalW1();
            break;
        case 'week2stats':
        	// $_SESSION['week'] = 'week2';
            $sql = "UPDATE updates SET week='week2', skip=1";
            $pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=2021_comp10120_z1', 'r88993ia', 'dashboardsqlpass');
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            countTotalW2();
            break;
    }
}

if (isset($_POST['letOpen'])){
    $sql = "UPDATE users SET fridaysPassed = (fridaysPassed + 1)";
    $pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=2021_comp10120_z1', 'r88993ia', 'dashboardsqlpass');
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    unset($_POST['letOpen']);
}
?>