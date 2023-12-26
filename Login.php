
<?php
include "config.php";


session_start();
if(isset($_POST['login']))
{
    $email=mysqli_real_escape_string($conn, $_POST['email']);
    $password=mysqli_real_escape_string($conn, $_POST['password']);

    $sqllogin="SELECT * from user where email ='".$email."' and  password ='".$password."' and status='active' "; 
 $resultlogin=mysqli_query($conn ,$sqllogin);


if(mysqli_num_rows($resultlogin)> 0){
    echo "update";

     if( $rowlogin =mysqli_fetch_assoc($resultlogin))

      $_SESSION['id']=$rowlogin['uid'];
      $name =$rowlogin['name'];

      setcookie('username',$name);

      header("Location: home.html");

  }
  else{
    echo "<script> alert('no user exists with this emai')</script>";
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
        .login{
          background-color:#fafaf5;
            width:500px;
            height:400px;
            margin-left:500px;
            margin-top:180px;
            border-radius:5%;
          }
        .login input{
          margin-left:100px;
    margin-top:10px;
   
}
input:focus{
    border-color:#93938e;
     
  }
.group input{
  height:15%;
      box-sizing: border-box;
      background: #eeeeee;
      outline: none;
      transition:  0.2s, border-color 0.2s;
  border:1px solid #f0f0d7;
            font-size:18px;
    display:block;
    margin-top:25px;
    border-radius:5%;
width:70%;
border:none;
padding:10px 10px;

 }

 .group1 input{
  border:1px solid #f0f0d7;
  border:none;
  background-color:;
  width:30%;
  padding: 10px 10px;
  font-size:18px;
  margin-left:40%;
  border-radius:5%;
font-weight:bolder;
 }
 

 .group1 input:hover{
  background-color:#fceb30;
  color:white
 }
 .group3  a,
 .group4 a{

  color:blue;
font-size:20px;
margin-left:200px;
 }
 .group4 a{
  margin-left:140px;
 }
 .group3, .group4{
  margin-top:20px;
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
    margin-top:-15px;
    position:absolute;
  }

  #stage{
       position: absolute;
       margin-left: 1380px;
       margin-top:0px;
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


<div class=login>
<h2>Login Form</h2>
<form action="" method="POST">
<div class= "group">
    <!-- <label for="email">Email</label> -->
    <input type="email" id="email" name="email" autocomplete="email"  placeholder="Enter Email" required>
    </div>

    <div class="group">
    <!-- <label for="password">Password</label> -->
    <input type="password"  id="password" name="password" placeholder="Enter password" required>
    </div>
  
    <div class="group1">
    <input type="submit"  name="login" value="Login">
    </div>
    <div class=group3>
      <a href="forgotpassword.php"> forgot password?</a> 
    <div>
    <div class=group4>
      <a href="">Don't have an account? Create account</a> 
    <div>

    </div>

</form>
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


<!-- <div>
  <div>
    <h2>login</h2>
  <hr>
  <form action="" action="POST">
  <div class= "form-group">
    <label for="email">Email</label>
    <input type="email" id="email" name="email" autocomplete="email"  placeholder="Enter Email" required>
    </div>

    <div class="form-group">
    <label for="password">Password</label>
    <input type="password"  id="password" name="password" placeholder="Enter password" autocomplete="off" required>
    </div>

    <div class= "form-group extra">

    <input type="checkbox" id="email" name="rememberme">   <label class="rem" >Remember me</label>
    <label  class="forget"><a href="">Forgot Password</a></label>
    </div>

    <div class="form-group">
  
    <input type="submit"  name="login" value="Login">
    </div>
  </form>
  </div>
</div> -->