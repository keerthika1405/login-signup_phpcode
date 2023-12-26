<?php
session_start();

include "config.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;




$otp = isset($_POST['otp']) ? $_POST['otp'] : '';
$activation_code = isset($_POST['activation_code']) ? $_POST['activation_code'] : '';

echo "<br>";

$otp = implode('', array_rand(array_flip(range(1, 9)), 6));
echo "<br>";
$act_str = rand(100000, 10000000);
$base_str = "adffghjkloiiuytrecvbnm";
$shuffled_str = str_shuffle($base_str);
$activation_code = $shuffled_str . $act_str;

// $_SESSION['activation'] = $activation_code;
// echo "Activation Code set: " . $_SESSION['activation'];

if(isset($_POST['register']))
{


 $name=mysqli_real_escape_string($conn, $_POST['name']);
 $email=mysqli_real_escape_string($conn, $_POST['email']);
 $password=mysqli_real_escape_string($conn, $_POST['password']);


//  "Name: " . $name . "<br>";
//  "Email: " . $email . "<br>";
//  "Password: " . $password . "<br>";
//  "OTP: " . $otp . "<br>";
//  "Activation Code: " . $activation_code . "<br>";


  $select_database="SELECT * from user where email ='".$email."' ";
  $select_result=mysqli_query($conn ,$select_database);

  if(mysqli_num_rows($select_result)> 0)
  {
    echo "update";
      $selectrow =mysqli_fetch_assoc($select_result);

   $status= $selectrow['status'];

      if($status ==='active')
      {
       
          echo "<script>alert('email already registered');   </script>";
          header("Location: Login.php");
          
      }


      else 
      {
        echo "updating";

        echo "Activation Code: " . $activation_code . "<br>";

          $sqlupdate= "UPDATE `user` SET  `name` ='".$name."'  , password ='".$password."' , otp ='".$otp."', activation_code ='".$activation_code."' 
          
          WHERE email = '".$email."'";
          $updateresult=mysqli_query($conn ,$sqlupdate);
           
 if($updateresult){ 
     
 require 'vendor/autoload.php';
 require_once 'class.phpmailer.php';
        
  $mail = new PHPMailer;
  $mail->IsSMTP();
  $mail->Host='smtp.elasticemail.com';
  $mail->Port ='';
  $mail->SMTPAuth= true;
  $mail->Username ='';
  $mail->Password= '';
  $mail->SMTPSecure= 'TLS';
  $mail->From= '';
  $mail->AddAddress($email);
  $mail->WordWrap=50;
  $mail->IsHTML(true);
  $mail->Subject = 'Verification code for Verify Your Email Address';
  $message_body='<p>For verify your email address, enter this verification code when prompted: <b>' .$otp. '</b>.</p> <p>Sincerely, </p>';
  $mail->Body= $message_body;


      if($mail->Send())
      { 
       echo '<script>alert("Please Check Your Email for Verification Code")</script>';
      header('location:otpverify.php?code=' . $activation_code);
      } 
      else{
        $message=$mail->ErrorInfo;
      }

          }
      }

  }




  else{
  echo "inserting";

require 'vendor/autoload.php';
require_once 'class.phpmailer.php';

  $mail = new PHPMailer;
  $mail->IsSMTP();
  $mail->Host='smtp.elasticemail.com';
  $mail->Port ='';
  $mail->SMTPAuth= true;
  $mail->Username ='';
  $mail->Password= '';
  $mail->SMTPSecure= 'TLS';
  $mail->From= '';
  $mail->AddAddress($email);
  $mail->IsHTML(true);
  $mail->WordWrap=50;
  $mail->Subject= 'Verification code for Verify Your Email Address';
  $message_body=' <p>For verify your email address, enter this verification code when prompted: <b>' .$otp. '</b>.</p> <p>Sincerely, </p>';
  $mail->Body= $message_body;

  
  // if(!$mail->Send())
  // { 
  //   echo "not working". $mail->ErrorInfo;
  // }

      if($mail->Send())
      { 
        
      $sqlinsert="INSERT INTO  user (`name`, email, `password`, otp, activation_code,`status`) VALUES( '".$name."','".$email."','".$password."','".$otp."','".$activation_code."','active')";
    
      $insertresult =mysqli_query($conn ,$sqlinsert);

      if($insertresult){
        echo "data inserted";

          echo '<script>alert("Please Check Your Email for Verification Code")</script>';
          header('location:otpverify.php?code='. $activation_code);
      }
      else{
      
          echo '<script>alert("oops somethimg wrong failed to insert a data")</script>';
      }
      }
      else{
          $message=$mail->ErrorInfo;
         
      }
  }


 }

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registeration</title>
    <style>



  .container{
 
    width: 100%;
    height: 70%;
    margin-top:110px;
    /* background-color: rgb(4, 56, 39); */
}
.container .card{

    width: 50%;
    height: 80%;
    background-color:#fafaf5;
    margin:auto;
    padding: 10px;
    margin-top:10px;
    border-radius:5%;
   

}

.container .card input{
 
    font-size:18px;
    display:block;
    margin-top:10px;
    padding :5px 5px;
}

.group1 input{
    padding: 5px 5px;
width:30%;
border-radius:5%;
margin-left:250px;
font-size:18px;
background-color:white;
font-weight:bolder;

  }
  
  .group1 input:hover{
    background-color: #830000;
    color:white

  }
  
  .group2 i,
  .group3 i{
    color:#b4b4b4;
    margin-top:-45px;
    margin-left:550px;
  }
  .form__text a{
color:blue;
font-size:20px;
margin-left:250px;
  }
input {
      /* display: block; */
      width: 60%;
      height:15%;
      box-sizing: border-box;
      border-radius:5px;
      border: 1px solid #f0f0d7;
      outline: none;
      margin-left:150px;
      background: #eeeeee;
      transition:  0.2s, border-color 0.2s;
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
    margin-top:120px;
    position:absolute;
  }
  #stage{
       position: absolute;
       margin-left: 1380px;
       margin-top:135px;
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
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
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


<div class="container" id='signup_page'>
  
<div class="card">
    <h2>Registraion Form</h2>

    <form action="" method ="POST">

    <input type="hidden" name="otp" value="<?php echo $otp; ?>"  >
    <input type="hidden" name="activation_code" value="<?php echo $activation_code; ?>">
    <input type="hidden" name="name"  value="<?php echo $name; ?>">
   
    <div class= "group">
    <!-- <label for="name">Name</label> -->
    <input type="text"  id="name" name="name" autocomplete="name"  placeholder="Enter Name" required>
    </div> 

    <div class= "group3">
    <!-- <label for="email">Email</label> -->
    <input type="email" class="emailgroup" id="email" name="email" autocomplete="email"  placeholder="Enter Email" required>
    <i class='bx bx-envelope  email-icon bx-sm' ></i>
    </div>

    <div class="group2">
    <!-- <label for="password">Password</label> -->
    <input type="password"  id="password" name="password" placeholder="Enter password" required>
    <i  id="togglepassword" class='bx bx-show show1 bx-sm'></i>
    </div>
  
    <div class="group1">
    <input type="submit"  name="register" value="signup" >
    </div>  
      
    <p class="form__text">
        <a class="form__link" id="linkLogin" href="Login.php" >Already have an account? Sign in</a>
    </p>
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
      <script>
          
  const togglepassword = document.querySelector('#togglepassword');
const password=document.querySelector('#password');

togglepassword.addEventListener('click', function(e){

const type=password.getAttribute('type')==='password' ? 'text' : 'password';
password.setAttribute('type',type);
this.classList.toggle('bxs-hide');
});


const input = document.querySelector(".emailgroup");
const emailIcon = document.querySelector(".email-icon");

      input.addEventListener("keyup", () =>{
     
      let pattern = /^[^ ]+@gmail+\.[a-z]{2,3}$/;
                      
      if(input.value === ""){
        console.log("state 1");
        emailIcon.classList.replace("bx-check-circle", "bx-envelope");
        return emailIcon.style.color = "#b4b4b4";//hash
      }
      if(input.value.match(pattern)){

        console.log("state 2");
        emailIcon.classList.replace("bx-envelope", "bx-check-circle");
        return emailIcon.style.color = "#4bb543"//green
      }
   
      emailIcon.classList.replace("bx-check-circle", "bx-envelope");
      return emailIcon.style.color = "#de0611"//red
});


      </script>

</body>
</html>






