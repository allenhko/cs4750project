<?php
require("connect-db.php");
require("friend-db.php");


if (!($_POST['actionBtn'] == "Add Food") && !($_POST['actionBtn'] == "Delete") && !($_POST['actionBtn'] == "Update") && !($_POST['actionBtn'] == "Confirm Update")) {
  $food = selectAllReview($_POST['Rname']);
}

$food_info_to_update = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Add Review"))
  {
    $previous=$_POST['Rname'];
    addReview($previous, $_POST['Text'], $_POST['Ratings'], $_POST['Date'], $_POST['ReviewID'], $_POST['ReviewType']);
    $food = selectAllReview($previous);
  }
  else if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Delete"))
  {
    deleteReview($_POST['ReviewID']);
    $food = selectAllReview($_POST['Review_to_delete']);
  }
  else if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Update"))
  {
    $food_info_to_update = getReviewByName($_POST['ReviewID']);
    $food = selectAllReview($_POST['Review_to_update']);
  }

  if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Confirm Update"))
  {
    updateReview($_POST['Rname'], $_POST['Text'], $_POST['Ratings'], $_POST['Date'], $_POST['ReviewID'], $_POST['ReviewType']);
    $food =  selectAllReview($_POST['Rname']);
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
  <h1>Restaurant Reviews for <?php echo $_POST['Rname']?></h1> 
  <button class="btn btn-primary" onclick="event.preventDefault(); window.location.href='simpleform.php'">Home</button>

  <form name="mainForm" action="restaurant_review.php" method="post">   
  <div class="row mb-3 mx-3">
    Restaurant Name:
    <input type="text" class="form-control" name="Rname" required
           value="<?php if ($food_info_to_update != null) echo $food_info_to_update['Rname'];?>"
    />     
  </div>
  <div class="row mb-3 mx-3">
    Review ID:
    <input type="text" class="form-control" name="ReviewID" required
           value="<?php if ($food_info_to_update != null) echo $food_info_to_update['ReviewID'];?>"
    />     
  </div>
  <div class="row mb-3 mx-3">
    Text:
    <input type="text" class="form-control" name="Text" required
    value="<?php if ($food_info_to_update != null) echo $food_info_to_update['Text']; ?>"
    />        
  </div>
  <div class="row mb-3 mx-3">
    Rating:
    <input type="text" class="form-control" name="Ratings" required
    value="<?php if ($food_info_to_update != null) echo $food_info_to_update['Ratings']; ?>"
    />        
  </div>
  <div class="row mb-3 mx-3">
    date:
    <input type="text" class="form-control" name="Date" required
    value="<?php if ($food_info_to_update != null) echo $food_info_to_update['Date']; ?>"
    />        
  </div>
  <div class="row mb-3 mx-3">
    ReviewType:
    <input type="text" class="form-control" name="ReviewType" required
    value="<?php if ($food_info_to_update != null) echo $food_info_to_update['ReviewType']; ?>"
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
    <th width="30%">Restaurant         
    <th width="30%">text
    <th width="30%">ratings
    <th width="30%">date
    <th width="30%">ID
    <th width="30%">Type  
    <th width="30%">Update
    <th width="30%">Delete 
  </tr>
  </thead>
<?php foreach ($food as $running_variable): ?>
  <tr>
     <td><?php echo $running_variable['Rname']; ?></td>
     <td><?php echo $running_variable['Text']; ?></td>        
     <td><?php echo $running_variable['Ratings']; ?></td>
     <td><?php echo $running_variable['Date']; ?></td>
     <td><?php echo $running_variable['ReviewID']; ?></td>
     <td>
      <form action="restaurant_review.php" method ="post">
        <input type="submit" name="actionBtn" value="Update" class = "btn btn-dark"/>
        <input type="hidden" name="Review_to_update" value="<?php echo $running_variable['Rname']; ?>"/>
        <input type="hidden" name="ReviewID" value="<?php echo $running_variable['ReviewID']; ?>"/>
      </form>
      </td>
      <td>
      <form action="restaurant_review.php" method ="post">
        <input type="submit" name="actionBtn" value="Delete" class = "btn btn-danger"/>
        <input type="hidden" name="Review_to_delete" value="<?php echo $running_variable['Rname']; ?>"/>
        <input type="hidden" name="ReviewID" value="<?php echo $running_variable['ReviewID']; ?>"/>
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