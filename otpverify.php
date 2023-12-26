
<?php
include "config.php";


// session_start();

// if (isset($_SESSION['activation'])) {
// $activation_code = $_SESSION['activation'];
// echo " Activation Code: " . $activation_code . "<br>";
// }

// $sql = "SELECT activation_code  FROM user WHERE  activation_code = '".$activation_code."' ";
// $result = mysqli_query($conn, $sql);

date_default_timezone_set("America/Los_Angeles");

if(isset($_POST['verify'])){


  
    if(isset($_GET['code'])){
        
        $activation_code =$_GET['code'];
        $otp =$_POST['otp'];

        $sqlselect="SELECT *FROM user WHERE activation_code = '".$activation_code."' ";

        $resultselect=mysqli_query($conn, $sqlselect);


        
        if(mysqli_num_rows($resultselect)>0){
         

            $rowselect =mysqli_fetch_assoc($resultselect);
            $rowOtp =$rowselect['otp'];
            $rowsinuptime=$rowselect['signup_time'];
            $rowsinuptime=date('d-m-y h:i:s', strtotime($rowsinuptime));
            $dateObject = new DateTime($rowsinuptime);

// Modify the date by adding 1 minute
$dateObject->modify('+1 minutes');

// date_modify($rowsinuptime,'+1 minutes');
$timeup = $dateObject->format('d-m-y h:i:s');
            // $timeup =date_formate($rowsinuptime,'d-m-y h:i:s');

            if($rowOtp!==$otp){
                echo "<script> alert ('please provide correct OTP..!')</script>";
            }
            else{
                $currentDateTime = date('d-m-y h:i:s');

                if($currentDateTim>=$timeup){
                    echo"<script> alert('your time is up..try it again ..')</script>";
                    header("Refresh:1; url=registration.php");
                }
                else{
                    $sqlupdate ="UPDATE  user SET status ='active' WHERE otp ='".$otp."' AND activation_code ='".$activation_code."' ";
                    $resultupdate=mysqli_query($conn,$sqlupdate);

                    if($resultupdate){
                        echo "<script>alert('your account suuccessfully activated')</script>";
                        header("Refresh:1; url=Login.php");
                    }
                }
                }
            }

            else{
           
            header("Location:Login.php" );
            }

    }
    else{
        echo "not verfied";
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

    
    .wrapper{
    position: absolute;
    width:500px;
    height: 200px;
    background-color:#fafaf5;
    margin-top:160px;
    margin-left:450px;
    border-radius:2%;

}
input:focus{
    border-color:#93938e;
     
  }
input{
    height:15%;
      box-sizing: border-box;
      background: #eeeeee;
      outline: none;
      transition:  0.2s, border-color 0.2s;
    background-color:#ebeae7;
    margin:auto;
    padding :10px 10px;
  font-size:18px;
    width:70%;
    border-radius:5%;
   padding:10px 10px;
   margin-left:100px;
   margin-top:10px;
   border:none;

}
.group1 input:hover{    
    background-color: #f48b12;
    color:white
}

.group1 input{
font-weight:bolder;
width: 30%;
border-radius:5%;
margin-left:170px;
margin-top:10px;

}
.group input:focus{
    border-color:#f6f67d;
     
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
    margin-top:160px;
    position:absolute;
  }
  #stage{
       position: absolute;
       margin-left: 1380px;
       margin-top:170px;
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


<div class="wrapper">
        <div class="otp">
            <h2>OTP Verify</h2>
         
            <form action="" method="POST">
                <div class="group">
                <input type="hidden" name="activation_code" value="<?php echo $activation_code; ?>">
                <!-- <label for="otp">OTP</label> -->
                <input type="text" id="otp" name="otp" placeholder="Enter The OTP To Verify the email" autocomplete="off">
                </div>
                
                <div class="group1">
                <label for="verify"></label>
                <input type="submit" id="verify" name="verify" value="verify">
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