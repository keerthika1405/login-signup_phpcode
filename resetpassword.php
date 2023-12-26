<?php
include "config.php";


if(isset($_POST['resetpassword'])){


    $passwords =mysqli_real_escape_string($conn, $_POST['password']);
    $confrimpassword =mysqli_real_escape_string($conn, $_POST['confrimpassword']);


if($passwords != $confrimpassword){

        echo " <script>alert('password not matched...'); </script> ";
}



else{
    

    if(isset($_GET['resetLink'])){
      

        $sqlselect = "SELECT * FROM user WHERE reset_code ='".$_GET['resetLink']."'";
        $resultselect =mysqli_query($conn, $sqlselect);


    if(mysqli_num_rows($resultselect)> 0){
        

        $sqlupdate =" UPDATE `user` SET  `password` ='".$passwords."' WHERE reset_code ='".$_GET['resetLink']."'";

        $resultupdate = mysqli_query($conn , $sqlupdate);


    if($resultupdate){
    echo "<script>alert('password update successfully')</script>";
    header('Refresh:1; url= Login.php');
    }

    else{
        echo "<script>alert('oops something wrong')</script>";
    }
    
}

    else{
        echo "<script>alert('wrong url')</script>";
    }

}
}
}


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        .resetpassword{
            background-color:#fafaf5;
            width:500px;
            height:300px;
            margin-left:500px;
            margin-top:170px;
            border-radius:5%;
        }
         input{
            padding:10px 10px;
            margin-left:100px;
            margin-top:10px;
            width:70%;
            border:none;
            border-radius:5%;
            font-size:18px;
            height:15%;
      box-sizing: border-box;
      background: #eeeeee;
      outline: none;
      transition:  0.2s, border-color 0.2s;
        }

        .group1 input{
width:30%;
background-color:white;
margin-left:40%;
border-radius:5%;
font-weight:bolder;
font-size:18px;
border:none;
        }
        input:focus{
    border-color:#93938e;
     
  }
        .group1 input:hover{
            background-color:#07bdba;
            color:white
        }
        
  input:focus{
    border-color:#93938e;
     
  }
  .bg{
 position: fixed;
 height: 160px;
 width: 100%;
 left:0;
top:0;
 
 }
 
  .bg img{
   z-index: -1;
   width: 100%;
   height: 160px;
  } 
  .webname{
    margin-left:1300px;
    margin-top:0px;
    position:absolute;
  }
  #stage{
       position: absolute;
       margin-left: 1380px;
       margin-top: 15px;
       cursor: pointer;
       z-index: 200;
    
   
       }
       @font-face {
            font-family: 'FontAwesome';
            src: url('fontawesome/fonts/fontawesome-webfont.ttf');
            font-weight: normal;
            font-style: normal;
        
           }
           #stage{
             font-family:FontAwesome;
           }
 

    </style>
    </style>
</head>
<body>



<div   class="bg" id="bgcontent">
      <img  id="bg" class="image-container" src="bgimg23.avif"  alt="">
  </div>


  <div class="webname">
       <h2>keesite</h2>
</div>

<div id="stage">
       <canvas id="Canvas" width="50" height="45"></canvas>
</div>


    <div>
        <div class= "resetpassword">
            <h2>Reset  password</h2>
         

            <form action="" method="POST">

            <div class="group">
            <input type="password" name="password" id="password" placeholder="Enter your New password" auutocomplete="off">
            </div>

            <div class="group">
            <input type="password" name="confrimpassword" id="confrimpassword" placeholder="Confrim your new password" auutocomplete="off">
            </div>

            <div  class="group1">
            <label for="resetpassword"></label>
            <input type="submit" name="resetpassword" value="Change" id="resetpassword" placeholder="" auutocomplete="off">
            </div>

            </form>
        </div>
    </div>


    <script>
        const canvas = document.getElementById('Canvas');
        const ctx = canvas.getContext('2d');
        // ctx.clearRect(0, 0, canvas.width, canvas.height);
      
        const cubeWidth = 26;
        const cubeHeight =20;
        const cubeDepth = 20;
      
        // Set cube position
        const cubeX = (canvas.width - cubeWidth) / 2;
        const cubeY = (canvas.height - cubeHeight) / 2;
      
        
        function drawCube() {
      
          ctx.beginPath();// Front face
          ctx.moveTo(cubeX, cubeY);
          ctx.lineTo(cubeX + cubeWidth, cubeY);
          ctx.lineTo(cubeX + cubeWidth, cubeY + cubeHeight);
          ctx.lineTo(cubeX, cubeY + cubeHeight);
          ctx.closePath();
          ctx.fillStyle = '#8d8f84';
          ctx.fill();
      
      
          ctx.beginPath();//top face
          ctx.moveTo(cubeX, cubeY);
          ctx.lineTo(cubeX + cubeWidth / 2, cubeY - cubeDepth / 2);
          ctx.lineTo(cubeX + cubeWidth / 2 + cubeWidth, cubeY - cubeDepth / 2);
          ctx.lineTo(cubeX + cubeWidth, cubeY);
          ctx.closePath();
          ctx.fillStyle = 'white';
          ctx.fill();
      
         
          ctx.beginPath();//side face
          ctx.moveTo(cubeX + cubeWidth, cubeY);
          ctx.lineTo(cubeX + cubeWidth / 2 + cubeWidth, cubeY - cubeDepth / 2);
          ctx.lineTo(cubeX + cubeWidth / 2 + cubeWidth, cubeY + cubeHeight - cubeDepth / 2);
          ctx.lineTo(cubeX + cubeWidth, cubeY + cubeHeight);
          ctx.closePath();
          ctx.fillStyle = '#8d8f84';
          ctx.fill();
        }
      
        setTimeout( function() {
      
          ctx.fillStyle = '#ffd700';
          ctx.font = '10px FontAwesome';  
          ctx.fillText("\uf084",25,9);
        },1000);
        drawCube();
      
      
      </script> 

</body>
</html>