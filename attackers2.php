  <!DOCTYPE html>  
 <html lang="en">  
 <head>  
   <meta charset="UTF-8">  
   <meta http-equiv="X-UA-Compatible" content="IE=edge">  
   <meta name="viewport" content="width=device-width, initial-scale=1.0">  
   <title>Attacker</title>  
   <style type="text/css">
     body{  
       width:100vw;  
       height:100vh;  
       display:flex;  
       justify-content: center;  
       align-items:center;  
       background: linear-gradient(#28313B, #485461);   
     }  

     @keyframes dropHeader {
  0%   { opacity: 0; }
  99%   { opacity: 0; }
  100% { opacity: 1; }
}

@-webkit-keyframes dropHeader {
  0%   { opacity: 0; }
  99%   { opacity: 0; }
  100% { opacity: 1; }
}

#heading {
 
animation-name: dropHeader;
animation-iteration-count: 1;
animation-timing-function: ease-in;
animation-duration: 1s;
}

.outer{
 
animation-name: dropHeader;
animation-iteration-count: 1;
animation-timing-function: ease-in;
animation-duration: 3s;

}

#button {
 
animation-name: dropHeader;
animation-iteration-count: 1;
animation-timing-function: ease-in;
animation-duration: 5s;
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

   <h1 id="heading">Your new attacker is.....</h1>
 </head>


 <body>
 <?php
    session_start();
    $username = $_SESSION['username'];
    if (!isset($_SESSION['attackerW']))
      header("Location:packChoice2.php");

    $player = $_SESSION['attackerW'];
    
    $playerId = $player[0];
    $swapWith = $_SESSION['toSwap'];

    $sql = "UPDATE teams SET $swapWith=$playerId WHERE username='$username'";
    $pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;dbname=2021_comp10120_z1', 'r88993ia', 'dashboardsqlpass');
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $sql = "UPDATE users SET openedPacks=(openedPacks+1) WHERE username ='$username'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    unset($_SESSION['attackerW']);
    unset($_SESSION['midfielderW']);
    unset($_SESSION['defenderW']);

  ?>  

   <div class="outer">
    <div class="inner">
      <a><?php echo $player[1] ?></a>
    </div>
  </div>
  <div id="button" >
    <div class="outer2">  
     <div class="inner2"> 
       <a id="a2"  href="ViewTeamPage.php">View Team</a>         
     </div>  
    </div> 
  </div>



</div>
 </body>  
 </html>