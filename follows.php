<?php
session_start();

require("connect-db.php");
require("friend-db.php");

if(!isset($_SESSION["loggedin"])){
    header("location: login.php");
    exit;
  }
  

if(empty($_SESSION["follows_to"])){
    $followedRestaurants = selectFollows($_POST['follows_to']);
    $_SESSION["follows_to"]=$_POST['follows_to'];
}
else{
    $followedRestaurants = selectFollows($_SESSION['follows_to']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Follow"))
  {
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
      followRestaurant($_POST['followRestaurant'], $_SESSION["username"]);
      $followedRestaurants = selectFollows($_SESSION['follows_to']);
  }

  if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Unfollow"))
  {
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
      unfollowRestaurant($_POST['unfollowRestaurant'], $_SESSION["username"]);
      $followedRestaurants = selectFollows($_SESSION['follows_to']);
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
<h1>Follow List</h1> 
<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4 center" style="width:150%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="30%">Name        
    <th width="30%">Address        
    <th width="30%">Type
    <th width="30%">Food
    <th width="30%">Follow
    <th width="30%">Review  
  </tr>
  </thead>
<?php foreach ($followedRestaurants as $restaurant): ?>
  <tr>
     <td><?php echo $restaurant['Rname']; ?></td>
     <td><?php echo $restaurant['address']; ?></td>        
     <td><?php echo $restaurant['type']; ?></td>
     <td>
      <form action="food.php" method ="post">
        <input type="submit" name="actionBtn" value="Food" class = "btn btn-dark"/>
        <input type="hidden" name="food_to" value="<?php echo $restaurant['Rname']; ?>"/>
      </form>
      </td>    
      <?php $followed = isset($restaurant['Rname']) && $restaurant['Rname'] == selectFollows($_SESSION["username"]);?>
      <td>
      <form action="follows.php" method ="post">
            <input type="submit" name="actionBtn" value="<?php if (checkIfUserFollows($_SESSION['username'], $restaurant['Rname'])) echo "Unfollow"; else echo "Follow";?>" class = "btn btn-dark"/>
            <input type="hidden" name="<?php if (checkIfUserFollows($_SESSION['username'], $restaurant['Rname'])) echo "unfollowRestaurant"; else echo "followRestaurant";?>" value="<?php echo $restaurant['Rname']; ?>"/>
      </form>
      </td>
      <td>
      <form action="restaurant_review.php" method ="post">
        <input type="submit" name="actionBtn" value="Review" class = "btn btn-primary"/>
        <input type="hidden" name="Rname" value="<?php echo $restaurant['Rname']; ?>"/>
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