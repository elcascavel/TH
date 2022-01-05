<?php
include("includes/header.php");

if(!isset($userLoggedIn)) {
	header("Location: index.php");
}

if (isset($_POST['cancel'])) {
    header("Location: profile.php");
}

if (isset($_POST['closeAccount'])) {
    require_once('cookies/configDb.php');
    $db = connectDB();

    $close_query = "DELETE from users WHERE username = ?";
    $statement = mysqli_prepare($db, $close_query);

    if (!$statement) {
        echo "Error preparing statement. Try again later";
        die();
    }

    $result = mysqli_stmt_bind_param($statement, 's', $userLoggedIn);

        if (!$result) {
            echo "Error binding parameters to prepared statement. Please try again later";
            die();
        }

        $result = mysqli_stmt_execute($statement);

        if (!$result) {
            echo "Error executing prepared statement.";
            die();
        }
        $result = closeDb($db);
        session_destroy();
        header("Location: index.php");
}

?>
<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="row justify-content-md-center">
    <div class="col-sm-6">
    <div class="card-header">
    <h4 class="mt-2">Close Account</h4>
    </div>
    <div class="card-body p-4">
        <span class="text-danger h4">Warning!</span>
        <p>Are you sure you want to close your account, <?php echo $userLoggedIn;?>?</p>
    </div>
<form action="close_account.php" method="POST">
    <input class="btn btn-outline-danger btn-sm" type="submit" name="closeAccount" id="closeAccount" value="Close it!">
    <input class="btn btn-outline-primary btn-sm" type="submit" name="cancel" value="No, take me back!">
</form>
    </div>
    </div> 
    

    
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>