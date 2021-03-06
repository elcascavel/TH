<!DOCTYPE html>
<html>
    <?php
include "includes/header.php";
include "includes/form_handlers/index_handler.php";
?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=9">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TF2 Trader's Hub</title>
        <link rel="shortcut icon" href="https://steamcdn-a.akamaihd.net/apps/tf2/blog/images/favicon.ico">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
        <link rel="stylesheet" href="../TH/css/main.css">
    </head>

    <body style="width:100%;margin:0;background-color:black">
        <div class="homepage">
            <div class="headerParent">
                <a class ="headerLogo" href="index.php"></a>
                <div class="headerNavItems">
                    <a class="navLink" href="trade.php">
                        Trade
                    </a>
                    <a class="navLink" href="buy.php">
                        Buy
                    </a>
                    <a class="navLink" href="contact.php">
                        Contact
                    </a>
                </div>
                <div class="navSide">
                    <div class="navSideContent">
                        <a class="accountActions" href="login.php" >

                        <?php
if (!isset($userLoggedIn)) {
    echo "Login";
}
?>
                         </a>

                         <a class="accountActionsLogin">
                       <?php

if (isset($userLoggedIn)) {
    if ($money == 0) {
        echo "<h5>$userLoggedIn <span class='badge bg-success'>0???</span></h5>";
    } else {
        echo "<h5>$userLoggedIn <span class='badge bg-success'>$money ???</span></h5>";
    }

}
?>
                        </a>



                        <?php
if (isset($userLoggedIn) && $userLoggedIn == $_SESSION['username']) {
    echo '<div class="accountActionsButtonContainer">
                                <form action="profile.php" method="POST" name="formModifica">
                                <input class="profileActionButton profileActionAccountImg" type="submit" name="modificar" value="">
                            </form>
                                <a class="profileActionButton profileActionWalletImg" href="wallet.php"> </a>
                                <a class="profileActionButton profileActionLogoutImg" href="logout.php"> </a>
                                </div>';
}
?>


                        <a class="accountActions" href="register.php">
                        <?php
if (!isset($userLoggedIn)) {
    echo "Sign Up";
}

?>
                         </a>
                    </div>
                </div>
            </div>
            <div class= "backgroundHeader">
                <div class="backgroundVideoContainer">
                    <video class="backgroundVideo" autoplay="" preload="auto" loop="" playsinline muted>
                        <source type="video/mp4" src="../TH/img/video.mp4">
                    </video>
                </div>
                <div class="quoteContainer" data-aos="fade-right" data-aos-delay="500" data-aos-duration="2500">
                    <div>
                        <div class="quote">
                            Trade, buy or sell TF2 items
                        </div>
                        <div class="quoteCredits">
                            TF2 Trader's Hub is safe and efficient.
                        </div>
                    </div>
                </div>
                <div class="headerFade"></div>
            </div>

</div>
<div class="container-fluid">
<div class="slider">
    <div class="slide-track">
        <?php
foreach ($shop_result as $item) {
    echo "<div class='slide'><img style='width: 200px' src=" . $item['item_image'] . ">
                </div>";
}
?>
    </div>
</div>
</div>
<?php
include "footer.php";
?>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
    </body>
</html>