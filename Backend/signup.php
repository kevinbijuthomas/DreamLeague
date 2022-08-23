<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Dream League | Sign Up</title>
    <link rel="stylesheet" href="style.css">
    <style type="text/css">
     
    </style>
  </head>
  <body>
    <?php
    function checkUsername($username){
      $sql = "SELECT username FROM users WHERE username = :username";
      $pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=2021_comp10120_z1', 'r88993ia', 'dashboardsqlpass');
      $stmt = $pdo->prepare($sql);
      $stmt->execute(['username' => $username]);
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $row = $stmt->fetch();

      if (isset($row['username'])){
        return false;
      } else{
        return true;
      }
    }

    function checkTeamName($teamName){
      $sql = "SELECT teamName FROM users WHERE teamName = :teamName";
      $pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=2021_comp10120_z1', 'r88993ia', 'dashboardsqlpass');
      $stmt = $pdo->prepare($sql);
      $stmt->execute(['teamName' => $teamName]);
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $row = $stmt->fetch();

      if (isset($row['teamName'])){
        return false;
      } else{
        return true;
      }
    }

    function addUser($username, $teamName, $password){
      $sql = "INSERT INTO users (username, teamName, password, nextFriday, openedPacks, fridaysPassed) VALUES (:username, :teamName, :password, :nextFriday, :openedPacks, :fridaysPassed)";
      $pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=2021_comp10120_z1', 'r88993ia', 'dashboardsqlpass');
      $stmt = $pdo->prepare($sql);
      $stmt->execute([
      'username' => $username,
      'teamName' => $teamName,
      'password' => $password, 
      'nextFriday' => strtotime('next friday'),
      'openedPacks' => 0,
      'fridaysPassed' => 0
      ]);
    }

    function getAttackers(){
      $ids = array();
      $names = array();
      $pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=2021_comp10120_z1', 'r88993ia', 'dashboardsqlpass');
      for ($i=2; $i>-1; $i--){
        $sql = "SELECT id, name FROM players1 WHERE position = 'Attacker' AND Rarity = $i ORDER BY RAND() LIMIT 1";
        $stmt = $pdo->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $ids[] = $row['id'];
        $names[] = $row['name'];
      }
      return array($ids, $names);
    }

    function getMidfielders(){
      $ids = array();
      $names = array();
      $pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=2021_comp10120_z1', 'r88993ia', 'dashboardsqlpass');

      for ($i=2; $i>0; $i--){
        $sql = "SELECT id, name FROM players1 WHERE position = 'Midfielder' AND Rarity = $i ORDER BY RAND() LIMIT 2";
        $stmt = $pdo->query($sql);
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $ids[] = $row[0]['id'];
        $ids[] = $row[1]['id'];
        $names[] = $row[0]['name'];
        $names[] = $row[1]['name'];
      }

      $sql = "SELECT id, name FROM players1 WHERE position = 'Midfielder' AND Rarity = 0 ORDER BY RAND() LIMIT 1";
      $stmt = $pdo->query($sql);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $ids[] = $row['id'];
      $names[] = $row['name'];

      return array($ids, $names);
    }

    function getDefenders(){
      // $sql = "SELECT id, name FROM players1 WHERE position = 'Defender' ORDER BY RAND() LIMIT 5";
      // $pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=2021_comp10120_z1', 'r88993ia', 'dashboardsqlpass');
      // $stmt = $pdo->query($sql);
      // $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
      // $ids = array($row[0]['id'], $row[1]['id'], $row[2]['id'], $row[3]['id'], $row[4]['id']);
      // $names = array($row[0]['name'], $row[1]['name'], $row[2]['name'], $row[3]['name'], $row[4]['name']);
      // return array($ids, $names);

      $ids = array();
      $names = array();
      $pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=2021_comp10120_z1', 'r88993ia', 'dashboardsqlpass');

      for ($i=2; $i>0; $i--){
        $sql = "SELECT id, name FROM players1 WHERE position = 'Defender' AND Rarity = $i ORDER BY RAND() LIMIT 2";
        $stmt = $pdo->query($sql);
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $ids[] = $row[0]['id'];
        $ids[] = $row[1]['id'];
        $names[] = $row[0]['name'];
        $names[] = $row[1]['name'];
      }

      $sql = "SELECT id, name FROM players1 WHERE position = 'Defender' AND Rarity = 0 ORDER BY RAND() LIMIT 1";
      $stmt = $pdo->query($sql);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $ids[] = $row['id'];
      $names[] = $row['name'];
      
      return array($ids, $names);
    }

    function getGoalkeepers(){
      $ids = array();
      $names = array();
      $pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=2021_comp10120_z1', 'r88993ia', 'dashboardsqlpass');

      $sql = "SELECT id, name FROM players1 WHERE position = 'Goalkeeper' AND Rarity = 2 ORDER BY RAND() LIMIT 1";
      $stmt = $pdo->query($sql);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $ids[] = $row['id'];
      $names[] = $row['name'];
      $sql = "SELECT id, name FROM players1 WHERE position = 'Goalkeeper' AND Rarity = 0 ORDER BY RAND() LIMIT 1";
      $stmt = $pdo->query($sql);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $ids[] = $row['id'];
      $names[] = $row['name'];

      return array($ids, $names);
    }

    function addTeam($un, $gks, $defs, $mids, $attackers){
      $team = array_merge($gks, $defs, $mids, $attackers);
      array_unshift($team, $un);
      $team[] = 0;

      $sql = "INSERT INTO teams (username, GK0, GKs, Def0, Def1, Def2, Def3, Defs, Mid0, Mid1, Mid2, Mid3, Mids, ST0, ST1, STs, total_pts) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
      $pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=2021_comp10120_z1', 'r88993ia', 'dashboardsqlpass');
      $stmt = $pdo->prepare($sql);
      $stmt->execute($team);
    }

    $invalid = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
      $username = $_POST['username'];
      $teamName = $_POST['teamName'];
      $password = $_POST['password'];
      $cpassword = $_POST['cpassword'];

      if (!checkUsername($username)){
        $invalid = "* Invalid Username";
      }
      else if (!checkTeamName($teamName)){
        $invalid = "* Invalid Team Name";
      }
      else if (strlen($password) < 6){
        $invalid = "* Password should have 6 characters at least";
      }
      else if ($password != $cpassword){
        $invalid = "* Passwords do not match";
      }
      else{
        $password = password_hash($password, PASSWORD_DEFAULT);
        addUser($username, $teamName, $password);
        
        $attackers = getAttackers();
        $mids = getMidfielders();
        $defs = getDefenders();
        $gks = getGoalkeepers();
        addTeam($username, $gks[0], $defs[0], $mids[0], $attackers[0]);

        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['teamName'] = $teamName;
        $_SESSION['attackers'] = $attackers[1];
        $_SESSION['mids'] = $mids[1];
        $_SESSION['defs'] = array_merge($defs[1], $gks[1]);

        header("Location:packChoice.html");
        exit();
      }
    }
    ?>

    <div class="frame">
      <a href="log_or_sign.html" id="back_arrow">&#x25c0;</a>
      <h2>Sign Up</h2>
      <div style="padding-bottom: 15px"><span style="color: red"><?php echo $invalid;?></span></div>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="user_input">
          <input type="text" name="username" required="">
          <label>Username</label>
        </div>
        <div class="user_input">
          <input type="team_name" name="teamName" required="">
          <label>Team Name</label>
        </div>
        <div class="user_input">
          <input type="password" name="password" required="">
          <label>Password</label>
        </div>
        <div class="user_input">
          <input type="password" name="cpassword" required="">
          <label>Confirm Password</label>
        </div>
        <button type="submit">Sign Up</button>
      </form>
    </div>
  </body>

</html>

