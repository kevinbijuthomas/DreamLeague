<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Dream League | Login</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <?php

    function authenticateUser($username, $password){
      $sql = "SELECT password, teamName FROM users WHERE username = :username";
      $pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=2021_comp10120_z1', 'r88993ia', 'dashboardsqlpass');
      $stmt = $pdo->prepare($sql);
      $stmt->execute(['username' => $username]);
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $row = $stmt->fetch();

      if (!isset($row['password'])){
        return "* Invalid Username";
      } 
      else{
        if (password_verify($password, $row['password'])){
          session_start();
          $_SESSION['username'] = $username;
          $_SESSION['teamName'] = $row['teamName'];
          header("Location:ViewTeamPage.php");
          exit();
        }
        else{
          return "* Incorrect Password";
        }
      }
    }

    $invalid = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
      $username = $_POST['username'];
      $password = $_POST['password'];

      $invalid = authenticateUser($username, $password);
    }
    ?>
    
    <div class="frame">
      <a href="log_or_sign.html" id="back_arrow">&#x25c0;</a>
      <h2>Login</h2>
      <div style="padding-bottom: 15px"><span style="color: red"><?php echo $invalid;?></span></div>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="user_input">
          <input type="text" name="username" required="">
          <label>Username</label>
        </div>
        <div class="user_input">
          <input type="password" name="password" required="">
          <label>Password</label>
        </div>
        <button type="submit">Login</button>
      </form>
    </div>
  </body>
</html>
