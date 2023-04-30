<?php
session_start();
require("connect-db.php");
require("friend-db.php");

$friends = selectFriends($_SESSION['username']);
$friendsS;
$username_err="";
$username="";
if($_SERVER["REQUEST_METHOD"] == "POST"){

    if (!empty($_POST['actionBtn'])){
        if($_POST['actionBtn']=="friend"){
            addFriends($_SESSION['username'],$_POST['name']);
            $friends=selectFriends($_SESSION['username']);
            $friendsS=NULL;
        }
        if($_POST['actionBtn']=="unfriend"){
            deleteFriends($_SESSION['username'],$_POST['name']);
            $friends=selectFriends($_SESSION['username']);            
        }
    }
    if(empty($_POST['actionBtn'])){
        if($_POST["User_Name"]==""){
                $username_err="Please enter a username.";
        }
        if($_POST["User_Name"]==$_SESSION["username"]){
            $username_err="You can't friend your own account.";
        }
        $username=$_POST["User_Name"];

        if(empty($username_err)){
            $pw=getPW($username);
            if(empty($pw)){
                $username_err="User does not exist. Please enter valid username and password.";
            }

            $ad=checkFriends($_SESSION["username"],$username);
            if(!empty($ad)){
                $username_err="User is already added into your friendslist.";
            }
            if(empty($username_err)){
                $friendsS=searchUser($username);
            }
        }
    }   

}

?>

<!-- 1. create HTML5 doctype -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  
  <!-- 2. include meta tag to ensure proper rendering and touch zooming -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- 
  Bootstrap is designed to be responsive to mobile.
  Mobile-first styles are part of the core framework.
   
  width=device-width sets the width of the page to follow the screen-width
  initial-scale=1 sets the initial zoom level when the page is first loaded   
  -->
  
  <meta name="author" content="your name">
  <meta name="description" content="include some description about your page">  
    
  <title>Bootstrap example</title>
  
  <!-- 3. link bootstrap -->
  <!-- if you choose to use CDN for CSS bootstrap -->  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  
  <!-- you may also use W3's formats -->
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  
  <!-- 
  Use a link tag to link an external resource.
  A rel (relationship) specifies relationship between the current document and the linked resource. 
  -->
  
  <!-- If you choose to use a favicon, specify the destination of the resource in href -->
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />

       
</head>

<body>
<div class="container">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">  
  <div class="row mb-3 mx-3">
    <label> UserName </label>
    <input type="text" name="User_Name" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
    <span class="invalid-feedback"><?php echo $username_err; ?></span>
  </div>
  <div class="row mb-3 mx-3">
  <input type="submit" class="btn btn-primary"value="Search User" title = "Search Users"/>
  </div> 
</form>
</div>


<div class="container">
  <h1>Friends List</h1> 
  
<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="30%">Friend Name    
    <th width="30%">Check Follows
    <th width="30%">Unfriend?    
  </tr>
  </thead>
<?php foreach ($friends as $running_variable): ?>
  <tr>
     <td><?php echo $running_variable['Friends_computing_ID']; ?></td>
     <td>
     <form action="follows.php" method ="post">
        <input type="submit" name="actionBtn" value="check Follows" class = "btn btn-dark"/>
        <input type="hidden" name="follows_to" value="<?php echo $running_variable['Friends_computing_ID'] ?>"/>
      </form>
    </td>
      <td>
      <form action="friends.php" method ="post">
        <input type="submit" name="actionBtn" value="unfriend" class = "btn btn-danger"/>
        <input type="hidden" name="name" value="<?php echo $running_variable['Friends_computing_ID']; ?>"/>
      </form>
      </td>  
            
  </tr>
<?php endforeach; ?>
</table>

<h1>Friends Search Result:</h1>
<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="30%">Friend Name    
    <th width="30%">Add Friend
  </tr>
  </thead>
<?php foreach ($friendsS as $running_variable): ?>
  <tr>
     <td><?php echo $running_variable['computing_id']; ?></td>
      <td>
      <form action="friends.php" method ="post">
        <input type="submit" name="actionBtn" value="friend" class = "btn btn-primary"/>
        <input type="hidden" name="name" value="<?php echo $running_variable['computing_id']; ?>"/>
      </form>
      </td>  
            
  </tr>
<?php endforeach; ?>
</table>
</div>   





  <!-- CDN for JS bootstrap -->
  <!-- you may also use JS bootstrap to make the page dynamic -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->
  
  <!-- for local -->
  <!-- <script src="your-js-file.js"></script> -->  
  
</div>    
</body>
</html>