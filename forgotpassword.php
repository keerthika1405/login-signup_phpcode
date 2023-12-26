<?php
include "config.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$basename = basename($_SERVER['HTTP_REFERER']);
$basename_replace = str_replace($basename ,"resetpassword.php", $_SERVER['HTTP_REFERER']);
$str_code =rand(100000, 100000000);
$reset_code =str_shuffle("ascdvftgbhnjiwmolpq". $str_code);
$url=$basename_replace."?resetLink=".$reset_code;


if(isset($_POST['resetLink'])){

    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $sqlSelects = "SELECT * FROM `user` WHERE email='".$email."' AND  `status` ='active'";
    $resultselects = mysqli_query($conn, $sqlSelects);


if(mysqli_num_rows($resultselects)> 0){
    
require 'vendor/autoload.php';
require_once 'class.phpmailer.php';

  $mail = new PHPMailer;
  $mail->IsSMTP();
  $mail->Host='smtp.elasticemail.com';
  $mail->Port ='2525';
  $mail->SMTPAuth= true;
  $mail->Username ='keerthikaravi1405@gmail.com';
  $mail->Password= '882FE9E23494C1F767E8347592F3DBBA1364';
  $mail->SMTPSecure= 'TLS';
  $mail->From= 'keerthikaravi1405@gmail.com';
  $mail->FromName='reset password link'; 
  $mail->AddAddress($email);
  $mail->IsHTML(true);
  $mail->WordWrap=50;
  $mail->Subject= 'Verification code for Verify Your Email Address';
  $message_body=' <p>For reset password , please click to given link:  <b>' .$url. '</b>.</p>  <p>Sincerely,keesite  </p>';
  $mail->Body= $message_body;

  if($mail->Send())
  { 
    
    
  $sqlUpdate="UPDATE user SET reset_code ='".$reset_code."' WHERE email ='".$email."'"; 

  $resultUpdate =mysqli_query($conn ,$sqlUpdate);

  if($resultUpdate){

      echo '<script>alert("Please Check Your Email for reset password");</script>';
header('Refresh:1; url= Login.php');
    
  }

  else{
  
      echo '<script>alert("oops somethimg wrong")</script>';
  }

}
    else{
        $message=$mail->ErrorInfo;
        echo "<script>alert('".$message."');<script>";
    }
   
}





else{
    echo "<script>alert('no Account found , try to give Correct Email...');</script>";
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
        .forgot{
            background-color:#fafaf5;
            width:500px;
            height:300px;
            margin-top:80px;
            margin-left:500px;
            border-radius:5%;
        }
        input{
        height:15%;
        box-sizing: border-box;
        background: #eeeeee;
        outline: none;
        transition:  0.2s, border-color 0.2s;
        width:70%;
        border:none;
        border-radius:5%;
        margin-left:100px;
        font-size:18px;
        display:block;
        margin-top:30px;
        padding :10px 10px;
       
        }
.group1 input{
    width:30%;
    margin-left:30%;
 font-weight: bolder;
}
.group1 input:hover{
background-color:#4ca239;
color:white
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
    margin-top:80px;
    position:absolute;
  }
  #stage{
       position: absolute;
       margin-left: 1380px;
       margin-top:95px;
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

    <div class="forgot">
        <div class="forgot_form">
            <h2>Forget Password</h2>
        
            <form action="" method="POST">
                <div class="group" >
           
                <input type="email" id="email" name="email" autocomplete="email"  placeholder="Enter Email" required>
                </div>

                <div class="group1">
                    <label for="resetLink"></label>
                <input type="submit" id="resetLink" name="resetLink" value="Enter">
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