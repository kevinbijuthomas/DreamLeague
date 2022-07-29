 <!DOCTYPE html>  
 <html lang="en">  
 <head>  
   <meta charset="UTF-8">  
   <meta http-equiv="X-UA-Compatible" content="IE=edge">  
   <meta name="viewport" content="width=device-width, initial-scale=1.0">  
   <title>Defender</title>  
   <style type="text/css">
     body{  
       width:100vw;  
       height:100vh;  
       display:flex;  
       justify-content: center;  
       align-items:center;  
       background: linear-gradient(#28313B, #485461);   
     }  

     .outer{  
 width:300px;  
 height:50px;  
 border-radius:10px;  
 padding:5px;  
   
         
       background-color: limegreen;  
     }  
      
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
       background: linear-gradient(#28313B, #485461);  
       border-radius:10px;  
     }  
     .a{  
       color:limegreen;  
       text-decoration:none;  
       font-weight: 900;  
       font-size:25px;  
     }  

     .outer2{  
 width:300px;  
 height:50px;  
 border-radius:10px;  
 padding:5px;  
     }  
     .outer2:hover{  
       animation-name:rotate;  
       animation-iteration-count:infinite;  
       animation-duration:1s;  
       animation-delay: 0ms;  
       background-color: rgb(23, 248, 248);  
     }  
     .outer2:hover #a2{  
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
     .inner2{  
       width:100%;  
       height:100%;  
       display:flex;  
       justify-content: center;  
       align-items:center;  
       background: linear-gradient(#28313B, #485461); 
       border-radius:10px;  
     }  
     a{  
       color: limegreen; 
       text-decoration:none;  
       font-weight: 900;  
       font-size:25px;  
     }  

     #button {
                position:absolute;                 
                bottom:20px;

                }

      #a2 {
        color: white;
      }

      #heading {

        color: white;
        position: absolute;
        top: 80px;
        font-size: 60px;
        font-style: italic;

      }

   </style>

   <h1 id="heading">Choose a player to swap with:</h1>
 </head>


 <body>
<script type="text/javascript">
    function passPosition(pos){
      aj = new XMLHttpRequest();
      aj.open("POST", "setSwap.php");
      aj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      aj.send("playerPosition="+pos);
    }
  </script>

  <?php
  session_start();
  $username = $_SESSION['username'];

  function getDefendersFromTeamsTable($usern){
    $sql = "SELECT Def0, Def1, Def2, Def3, Defs, GK0, GKs FROM teams WHERE username ='$usern'";
    $pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=2021_comp10120_z1', 'r88993ia', 'dashboardsqlpass');
    $stmt = $pdo->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $idsList = array();
    foreach ($row as $key => $value) {
      $idsList[] = $value;
    }

    $namesList = array();
    foreach ($idsList as $playerId) {   
      $sql = "SELECT name FROM players1 WHERE id =".$playerId;
      $stmt = $pdo->query($sql);
      $row1 = $stmt->fetch(PDO::FETCH_ASSOC);
      $namesList[] = $row1['name']; 
    }
    
    return $namesList;
  }

  $names = getDefendersFromTeamsTable($username);

  ?>

  
   <div class="outer">  
     <div class="inner"> 
     <div class="a">
       <a onclick="passPosition('Def0')" href="defenderPack2.html" ><?php echo $names[0];?></a>  
       </div> 
     </div>  
   </div> 
   <div class="outer">  
     <div class="inner"> 
     <div class="a">
       <a onclick="passPosition('Def1')" href="defenderPack2.html" ><?php echo $names[1];?></a>  
       </div> 
     </div>  
   </div> 
   <div class="outer">  
     <div class="inner"> 
     <div class="a">
       <a onclick="passPosition('Def2')" href="defenderPack2.html" ><?php echo $names[2];?></a>  
       </div> 
     </div>  
   </div> 
   <div class="outer">  
     <div class="inner"> 
     <div class="a">
       <a onclick="passPosition('Def3')" href="defenderPack2.html" ><?php echo $names[3];?></a>  
       </div> 
     </div>  
   </div> 
   <div class="outer">  
     <div class="inner"> 
     <div class="a">
       <a onclick="passPosition('Defs')" href="defenderPack2.html" ><?php echo $names[4];?></a>  
       </div> 
     </div>  
   </div>  
   <div class="outer">  
     <div class="inner"> 
     <div class="a"> 
       <a onclick="passPosition('GK0')" href="defenderPack2.html"><?php echo $names[5];?></a>  
       </div> 
     </div>  
   </div> 
   <div class="outer">  
     <div class="inner"> 
     <div class="a"> 
       <a onclick="passPosition('GKs')" href="defenderPack2.html"><?php echo $names[6];?></a>  
       </div> 
     </div>  
   </div> 



</div>
 </body>  
 </html>