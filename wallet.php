<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

if (!empty($_POST)) {

    
    require_once('cookies/valida.php');

   
    $errors = validaPayment($_POST);

    
    if (!is_array($errors) && !is_string($errors)) {

        require_once('cookies/configDb.php');

        
        $db = connectDB();

        			
        if (is_string($db)) {
         
            echo ("Fatal error! Please return later.");
            die();
        }

        
        $owner = trim($_POST['owner']);
        $cardnum = trim($_POST['cardnum']);
        $cvv = trim($_POST['cvv']);
        $cardname = $_POST['cardname'];
        $amount = $_POST['amount'];

        $query = "SELECT cardnum FROM wallet WHERE cardnum=?";

        		
        $statement = mysqli_prepare($db, $query);

        if (!$statement) {
            
            echo "Something went wrong. Please try again later.1";
            die();
        }

       
        $result = mysqli_stmt_bind_param($statement, 's', $cardnum);
        if (!$result) {
           
            echo "Something went wrong. Please try again later.2";
            die();
        }

        
        $result = mysqli_stmt_execute($statement);

        if (!$result) {
           
            echo "Something went very wrong. Please try again later.3";
            die();
        }

        
        $result = mysqli_stmt_get_result($statement);

        if (!$result) {
            
            echo "Something went wrong. Please try again later.4";
            die();
        } elseif (mysqli_num_rows($result) == 0) {

            $query = "INSERT INTO wallet (owner, cardnum, cvv, cardname, amount) VALUES (?,?,?,?,?)";
			
            $statement = mysqli_prepare($db, $query);

            if (!$statement) {
                
                echo "Something went wrong. Please try again later.5";
                die();
            }

            
            $result = mysqli_stmt_bind_param($statement, 'sssss', $owner, $cardnum, $cvv, $cardname, $amount); 
            if (!$result) {
                
                echo "Something went wrong. Please try again later.6";
                die();
            }

            //execute the prepared statement
            $result = mysqli_stmt_execute($statement);

            if (!$result) {
                
                echo "Something went very wrong. Please try again later.7";
                die();
            } else {

                //user registered - close db connection
                $result = closeDb($db);

                header("Location: index.php");
                exit();
            }
        } else {
            $existingRecords = array('cardnum' => false);

          				
            while ($row = mysqli_fetch_assoc($result)) {

                if ($row['cardnum'] == $cardnum) {
                    $existingRecords['cardnum'] = true;
                }
            } 															
        } 
    } elseif (is_string($errors)) {
     
        echo $errors;

        unset($errors);
    }
}
?>
<?php
    if (!empty($existingRecords)) {

    if ($existingRecords['cardnum']) {
        
        echo "This Card Number already exist in our records.";
    }
} 
?>

<!DOCTYPE html>
<html>

<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <meta http-equiv="X-UA-Compatible" content="IE=9" />
 <title>TF2 Trader's Hub</title>
 <link rel="shortcut icon" href="https://steamcdn-a.akamaihd.net/apps/tf2/blog/images/favicon.ico" />
 <link rel="stylesheet" href="../TH/css/main.css" />

 <link rel="preconnect" href="https://fonts.googleapis.com">
 <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

 <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">

 <link href="http://fonts.cdnfonts.com/css/tf2-build" rel="stylesheet">

 <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>

<body style="width: 100%; margin: 0; background-color: black">
 <div class="homepage">
     <h1 class="loginHeader">ADD FUNDS</h1>
     <div class="loginBreak"></div>
     <div class="loginFormContainer">
         <img class="loginLogo" src="../TH/img/logo.png" />
         <form class="loginForm" action="" method="POST">
             <input class="loginInput" type="text" id="owner" name="owner" placeholder="owner" value=""<?php

                                                                                                                                                                                                                    if (!empty($errors) && isset($errors['owner'][0])) { #this is done to keep the value inputted by the user if this field is valid but others are not
                                                                                                                                                                                                                        echo $_POST['owner'];
                                                                                                                                                                                                                    }

                                                                                                                                                                                                                    ?>><br>
             <?php
                if (!empty($errors) && isset($errors['owner'][0])) { 
                    echo $errors['owner'][1] . "<br>";
                }
                ?>
             <input class="loginInput" type="text" id="cardnum" name="cardnum" placeholder="cardnum" value=""<?php

                                                                                                                                                                                                    if (!empty($errors) && isset($errors['cardnum'][0])) {
                                                                                                                                                                                                        echo $_POST['cardnum'];
                                                                                                                                                                                                    }

                                                                                                                                                                                                    ?>><br>
             <?php
                if (!empty($errors) && isset($errors['cardnum'][0])) {
                    echo $errors['cardnum'][1] . "<br>";
                }
                ?>
              <input class="loginInput" type="text" id="cvv" name="cvv" placeholder="cvv" value=""<?php

                    if (!empty($errors) && isset($errors['cvv'][0])) {
                         echo $_POST['cvv'];
                    }

                ?>><br>
            <?php
                if (!empty($errors) && isset($errors['cvv'][0])) {
                    echo $errors['cvv'][1] . "<br>";
                }
                ?>
             <div class="teamPickContainer">

                 <label>
                     <input type="radio" id="visa" name="cardname" value="Visa" <?php
                                                                                                                                        if (!empty($errors) && isset($errors['cardname'][0]) && $_POST['cardname'] == "Visa") {
                                                                                                                                            echo "checked";
                                                                                                                                        }
                                                                                                                                        ?>>

                     <img class="teamPick" src="../TH/img/visa" width="10%">
                 </label>
                 <label>
                     <input type="radio" id="mastercard" name="cardname" value="Mastercard" <?php
                                                                                                                                        if (!empty($errors) && isset($errors['cardname'][0]) && $_POST['cardname'] == "Mastercard") {
                                                                                                                                            echo "checked";
                                                                                                                                        }
                                                                                                                                        ?>>
                     <img class="teamPick" src="../TH/img/mastercard" width="10%">
                 </label>


                 <?php
                    if (!empty($errors) && isset($errors['cardname'][0])) {
                        echo $errors['cardname'][1] . "<br>";
                    }
                    ?>
             </div>
             <div class="teamPickContainer">

<label>
    <input type="radio" id="eu5" name="amount" value="5EUR" <?php
                                                                                                                       if (!empty($errors) && isset($errors['amount'][0]) && $_POST['amount'] == "5EUR") {
                                                                                                                           echo "checked";
                                                                                                                       }
                                                                                                                       ?>>

    <img class="teamPick" src="../TH/img/cinco" width="10%">
</label>
<label>
    <input type="radio" id="eu10" name="amount" value="10EUR" <?php
                                                                                                                       if (!empty($errors) && isset($errors['amount'][0]) && $_POST['amount'] == "10EUR") {
                                                                                                                           echo "checked";
                                                                                                                       }
                                                                                                                       ?>>
    <img class="teamPick" src="../TH/img/dez" width="10%">
</label>


<?php
   if (!empty($errors) && isset($errors['amount'][0])) {
    echo $errors['amount'][1] . "<br>";
}
   ?>
</div>
             <input class="loginButton" type="submit" value="VALIDATE">
         </form>
         <img style="width:300px" src="../TH/img/soldierRegister.png" data-aos="fade-left" data-aos-delay="200" data-aos-duration="1500" />
     </div>

     <div class="footerArea">
         <div class="footerLogos">
             <a href="https://www.valvesoftware.com/en/about"><img class="footerLogoImg" src="https://cdn.cloudflare.steamstatic.com/apps/dota2/images/dota_react/valve_logo.png" /></a>
             <a href="https://necm.utad.pt/"><img class="footerLogoImg" src="../TH/img/cmLogo.png" /></a>
         </div>

         <div class="footerLegal">
             Team Fortress is a trademark of Valve Corporation, TF2 Trader's Hub is
             a fan creation and is not affiliated with Valve or Steam.
         </div>
     </div>
 </div>
 <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
 <script>
     AOS.init();
 </script>
</body>

</html>