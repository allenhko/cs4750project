<?php
require("connect-db.php");
require("friend-db.php");


if (!($_POST['actionBtn'] == "Add Food") && !($_POST['actionBtn'] == "Delete") && !($_POST['actionBtn'] == "Update") && !($_POST['actionBtn'] == "Confirm Update")) {
  $food = selectAllFoodReview($_POST['Name']);
}

$food_info_to_update = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Add Review"))
  {
    $previous=$_POST['Name'];
    addFoodReview($previous, $_POST['review_id'], $_POST['taste_score']);
    $food = selectAllFoodReview($previous);
  }
  else if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Delete"))
  {
    deleteFoodReview($_POST['review_id']);
    $food = selectAllFoodReview($_POST['Review_to_delete']);
  }
  else if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Update"))
  {
    $food_info_to_update = getFoodReviewByName($_POST['review_id']);
    $food = selectAllFoodReview($_POST['Review_to_update']);
  }

  if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Confirm Update"))
  {
    updateFoodReview($_POST['Name'], $_POST['review_id'], $_POST['taste_score']);
    $food = selectAllFoodReview($_POST['Name']);
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
  <h1>Food Review List</h1> 
  <form name="mainForm" action="food_review.php" method="post">   
  <div class="row mb-3 mx-3">
    Review ID:
    <input type="text" class="form-control" name="review_id" required
           value="<?php if ($food_info_to_update != null) echo $food_info_to_update['review_id'];?>"
    />     
  </div>
  <div class="row mb-3 mx-3">
    Food Name:
    <input type="text" class="form-control" name="Name" required
           value="<?php if ($food_info_to_update != null) echo $food_info_to_update['Name'];?>"
    />     
  </div>
  <div class="row mb-3 mx-3">
    Taste Score:
    <input type="text" class="form-control" name="taste_score" required
    value="<?php if ($food_info_to_update != null) echo $food_info_to_update['taste_score']; ?>"
    />        
  </div>
  <div class="row mb-3 mx-3">
  <input type="submit" class="btn btn-primary" name="actionBtn" value="Add Review" title = "click to insert Restaurant"/>
  </div>
  <div class="row mb-3 mx-3">
  <input type="submit" class="btn btn-dark" name="actionBtn" value="Confirm Update" title = "click to confirm update"/>
  </div>  
  
  </form>
  
<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="30%">Review ID         
    <th width="30%">Food name
    <th width="30%">taste score 
    <th width="30%">Update
    <th width="30%">Delete 
  </tr>
  </thead>
<?php foreach ($food as $running_variable): ?>
  <tr>
     <td><?php echo $running_variable['review_id']; ?></td>
     <td><?php echo $running_variable['Name']; ?></td>        
     <td><?php echo $running_variable['taste_score']; ?></td>
     <td>
      <form action="food_review.php" method ="post">
        <input type="submit" name="actionBtn" value="Update" class = "btn btn-dark"/>
        <input type="hidden" name="Review_to_update" value="<?php echo $running_variable['Name']; ?>"/>
        <input type="hidden" name="review_id" value="<?php echo $running_variable['review_id']; ?>"/>
      </form>
      </td>
      <td>
      <form action="food_review.php" method ="post">
        <input type="submit" name="actionBtn" value="Delete" class = "btn btn-danger"/>
        <input type="hidden" name="Review_to_delete" value="<?php echo $running_variable['Name']; ?>"/>
        <input type="hidden" name="review_id" value="<?php echo $running_variable['review_id']; ?>"/>
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