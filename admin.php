<?php
include("includes/header.php");
require 'includes/form_handlers/admin_handler.php';

if ($userIsAdmin == 0) {
    header("Location: index.php");
}
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=9">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TF2 Trader's Hub - Admin</title>
    <link rel="shortcut icon" href="https://steamcdn-a.akamaihd.net/apps/tf2/blog/images/favicon.ico">
    <link rel="stylesheet" href="../TH/css/main.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body style="background-color:#282a36;">
    <div class="container mt-2">
        <h1 class="text-white">Admin Panel</h1>
        <form action="admin.php" method="POST">
            <input class="btn btn-outline-info btn-sm" type="submit" name="returnProfile" id="returnProfile" value="Return to your profile">
        </form>
        <?php echo "<h5 class='text-white'; class='mt-2'>Welcome, $userLoggedIn</h5>"; ?>
        <div class="row-md-2">
            <?php
            $table = "";

            $table .= "
        <table class='table table-hover table-light table-striped table-bordered align-middle text-center'>
        <thead>
        <tr>
        <th scope='col'>#</th>
        <th scope='col'>Username</th>
        <th scope='col'>Date Created</th>
        <th scope='col'>Role</th>
        <th scope='col'>Action</th>
        </tr>
        </thead>
        ";
            foreach ($user_result as $user) {
                $adminCheck = $user['is_admin'];
                $is_adminString = "Make";
                if ($adminCheck) {
                    $adminCheck = "Admin";
                    $is_adminString = "Remove";
                } else {
                    $adminCheck = "User";
                    $is_adminString = "Make";
                }
                $table .= "
            <tr>
            <td>" . $user['id_users'] . "</td>
            <td><img class='adminPanelAvatar' src=" . $user['user_pic'] . "><b>" . $user['username'] . "</b></td>
            <td>" . date("jS F, Y", strtotime($user['signup_date'])) . "</td>
            <td>" . $adminCheck . "</td>
            <td><form action='admin.php' method='post'><input type='hidden' name='id' value=" . $user['id_users'] . "><button type='submit' name='setAdmin' class='btn btn-primary btn-sm'>" . $is_adminString . " admin</button> <input type='hidden' name='id' value=" . $user['id_users'] . "><button type='submit' name='deleteUser' class='btn btn-danger btn-sm'>Delete user</button></td></form>
            </tr>
            ";
            }
            echo $table . "</table>";
            ?>
        </div>
        <div class="row-md-2">
            <h2 class="text-white mt-5">Items</h2>
            <div class="col">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary float-start mb-2" data-bs-toggle="modal" data-bs-target="#addItemModal">
                    Add Item
                </button>

                <!-- Modal -->
                <div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addItemModal">Add a new item!</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="admin.php" id="addItem_form" method="POST">
                                    <div class="mb-3">
                                        <label for="item-name" class="col-form-label">Item Name</label>
                                        <input type="text" class="form-control" id="item-name" name="item-name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="item-description" class="col-form-label">Description</label>
                                        <textarea class="form-control" id="item-description" name="item-description"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="price" class="col-form-label">Price</label>
                                        <input type="text" class="form-control" id="item-price" name="item-price">
                                    </div>
                                    <div class="mb-3">
                                        <select class="form-select form-select-sm" name="item-rarity" aria-label="Item rarity select">
                                            <option value="Normal">Normal</option>
                                            <option value="Unique">Unique</option>
                                            <option value="Genuine">Genuine</option>
                                            <option value="Unusual">Unusual</option>
                                        </select>
                                    </div>
                                    <div>
                                        <p class="text-muted">You may add an image to the item by editing it.<p>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <input name="addItem_button" type="submit" class="btn btn-primary" value="Add item">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <?php
            $table = "";

            $table .= "
         <table class='table table-hover table-light table-striped table-bordered align-middle text-center'>
         <thead>
         <tr>
         <th scope='col'>#</th>
         <th scope='col'>Item Name</th>
         <th scope='col'>Price</th>
         <th scope='col'>Action</th>
         </tr>
         </thead>
         ";

            foreach ($shop_result as $item) {
                if ($item['rarity'] == "Unusual") {
                    $itemRarity = "#8650AC";
                } else if ($item['rarity'] == "Unique") {
                    $itemRarity = "rgb(125, 109, 0)";
                } else if ($item['rarity'] == "Genuine") {
                    $itemRarity = "#4D7455";
                } else {
                    $itemRarity = "#B2B2B2";
                }
                $table .= "
             <tr>
             <td>" . $item['id'] . "</td>
             <td><img class='adminPanelAvatar' src=" . $item['item_image'] . "><b><p style='color:$itemRarity; display:inline'>" . $item['product'] . "</p></b></td>
             <td>???" . $item['price'] . "</td>
             <td><form action='admin.php' id='editItem_form' method='post'><input type='hidden' name='item_id' value=" . $item['id'] . "><button data-bs-toggle='modal' type='button' data-bs-target='#editItemModal".$item['id']."' class='btn btn-primary btn-sm'>Edit item</button> <button data-bs-toggle='modal' type='button' data-bs-target='#changeImageModal".$item['id']."' class='btn btn-primary btn-sm'>Change Image</button> <button type='submit' name='deleteItem_button' class='btn btn-danger btn-sm'>Delete item</button></td>
             </tr>
             ". "<div class='modal fade' id='editItemModal".$item['id']."'tabindex='-1' aria-labelledby='editItemModalLabel' aria-hidden='true'>
             <div class='modal-dialog'>
                 <div class='modal-content'>
                     <div class='modal-header'>
                         <h5 class='modal-title'>Edit your item!</h5>
                         <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                     </div>
                     <div class='modal-body'>
                             <div class='mb-3'>
                                 <label for='item-name' class='col-form-label'>Item Name</label>
                                 <input type='text' class='form-control' id='item-name' name='item-name' value='".htmlspecialchars($item['product'], ENT_QUOTES)."'>
                             </div>
                             <div class='mb-3'>
                                 <label for='item-description' class='col-form-label'>Description</label>
                                 <textarea class='form-control' id='item-description' name='item-description' style='height: 100px'>". $item['item_description']."</textarea>
                             </div>
                             <div class='mb-3'>
                                 <label for='price' class='col-form-label'>Price (???)</label>
                                 <input type='text' class='form-control' id='item-price' name='item-price' value='".$item['price']."'>
                             </div>
                             <div class='mb-3'>
                                 <select class='form-select form-select-sm' name='item-rarity' aria-label='Item rarity select'>
                                     <option value='Normal'>Normal</option>
                                     <option value='Unique'>Unique</option>
                                     <option value='Genuine'>Genuine</option>
                                     <option value='Unusual'>Unusual</option>
                                 </select>
                             </div>
                     </div>
                     <div class='modal-footer'>
                         <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                         <input name='updateItem_button' type='submit' class='btn btn-primary' form ='editItem_form' value='Save changes'>
                         </form>
                     </div>
                 </div>
             </div>
         </div>
         <div class='modal fade' id='changeImageModal".$item['id']."' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h5 class='modal-title'>Change your item's image!</h5>
        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>
      <form method='POST' action='upload.php' id='change_image' enctype='multipart/form-data'>
      <div class='row justify-content-center'>
      <div class='col-md-6'><input class='form-control form-control-sm' id='formFileSm' type='file' name='itemPicture'></div>
      <input type='hidden' name='product_id' value=" . $item['id'] . ">
      </div>
      <div class='row justify-content-center mb-2'>
      <div class='col-md-4'>
      <input class='btn btn-primary btn-sm mt-2' type='submit' name='editItem_form' value='Change Item Image'>
      </div>
      </div>
      </div>
    </div>
  </div>
</div>";
            }
            echo $table . "</table>";
            ?>   
        </div>
        <div class="row-md-2 mt-5">
        <h2 class="text-white">Messages</h2>
        <?php
            $table = "";

            $table .= "
        <table class='table table-hover table-light table-striped table-bordered align-middle text-center'>
        <thead>
        <tr>
        <th scope='col'>#</th>
        <th scope='col'>Name</th>
        <th scope='col'>Message</th>
        <th scope='col'>Date Sent</th>
        <th scope='col'>Action</th>
        </tr>
        </thead>
        ";
            foreach ($contact_result as $contact) {
                $table .= "
            <tr>
            <td>" . $contact['id_message'] . "</td>
            <td>". $contact['name'] ."</td>
            <td>". $contact['message'] ."</td>
            <td>" . date("jS F, Y", strtotime($contact['send_date'])) . "</td>
            <td><form action='admin.php' id='message_form' method='post'><input type='hidden' name='message_id' value=" . $contact['id_message'] . "><button type='submit' name='readMessage_button' class='btn btn-success btn-sm'>Read message</button></td></form>
            </tr>
            ";
            }
            echo $table . "</table>";
            ?>
        </div>
    </div>
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
  <div id="liveToast" class="toast bg-danger text-white border-0 <?php echo $toastClass ?>" role="alert" aria-live="assertive" aria-atomic="true">
<div class="d-flex">
    <div class="toast-body">
      <?php
      if (!empty($errors)) { # Equal to "if ( !empty($errors) && $errors['username'][0] == true ){" #presents an error message if this field has invalid content
            if (isset($errors['item_name']) && $errors['item_name'][0] == true)
            {
                echo "<p>" . $errors['item_name'][1] . "</p>";
            }

            if (isset($errors['item_description']) && $errors['item_description'][0] == true) {
                echo "<p>" . $errors['item_description'][1] . "</p>";
            }

            if (isset($errors['item_price']) && $errors['item_price'][0] == true) {
                echo "<p>" . $errors['item_price'][1] . "</p>";
            }

            if (isset($errors['admin_error']) && $errors['admin_error'][0] == true) {
                echo "<p>" . $errors['admin_error'][1] . "</p>";
            }

            if (isset($errors['delete_user']) && $errors['delete_user'][0] == true) {
                echo "<p>" . $errors['delete_user'][1] . "</p>";
            }
        }
    else {
        echo $toastMessage;
    }
      ?>
    </div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  </div>
</div>
<?php
include "footer.php";
?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>