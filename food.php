<?php
require("connect-db.php");
require("friend-db.php");



if (!($_POST['actionBtn'] == "Add Food") && !($_POST['actionBtn'] == "Delete") && !($_POST['actionBtn'] == "Update") && !($_POST['actionBtn'] == "Confirm Update")) {
  $food = selectFood($_POST['food_to']);
}

$food_info_to_update = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Add Food"))
  {
    $previous=$_POST['Rname'];
    addFood($previous, $_POST['name'], $_POST['price']);
    $food = selectFood($previous);
  }
  else if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Delete"))
  {
    deleteFood($_POST['Food_to_delete'],$_POST['name']);
    $food = selectFood($_POST['Food_to_delete']);
  }
  else if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Update"))
  {
    $food_info_to_update = getFoodByName($_POST['food_to_update'], $_POST['name']);
    $food = selectFood($_POST['food_to_update']);
  }

  if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Confirm Update"))
  {
    updateFood($_POST['Rname'], $_POST['name'], $_POST['price']);
    $food =  selectFood($_POST['Rname']);
  }
}
// else{
//   $food =  selectFood($_POST['food_to']);
// }

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
  <h1>Food List for <?php echo $_POST['Rname']?></h1> 
  <button class="btn btn-primary" onclick="event.preventDefault(); window.location.href='simpleform.php'">Home</button>
  <form name="mainForm" action="food.php" method="post">   
  <div class="row mb-3 mx-3">
    Restaurant Name:
    <input type="text" class="form-control" name="Rname" required
           value="<?php if ($food_info_to_update != null) echo $food_info_to_update['Rname']; ?>"
    />        
  </div>
  <div class="row mb-3 mx-3">
    Food name:
    <input type="text" class="form-control" name="name" required
    value="<?php if ($food_info_to_update != null) echo $food_info_to_update['Name']; ?>"
    />        
  </div>
  <div class="row mb-3 mx-3">
    price:
    <input type="text" class="form-control" name="price" required
    value="<?php if ($food_info_to_update != null) echo $food_info_to_update['price']; ?>"
    />        
  </div>
  <div class="row mb-3 mx-3">
  <input type="submit" class="btn btn-primary" name="actionBtn" value="Add Food" title = "click to insert Restaurant"/>
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
    <th width="30%">name   
    <th width="30%">price
    <th width="30%">Update
    <th width="30%">Delete
    <th width="30%">Review 
  </tr>
  </thead>
<?php foreach ($food as $running_variable): ?>
  <tr>
     <td><?php echo $running_variable['Rname']; ?></td>
     <td><?php echo $running_variable['Name']; ?></td>        
     <td><?php echo $running_variable['price']; ?></td>
     <td>
      <form action="food.php" method ="post">
        <input type="submit" name="actionBtn" value="Update" class = "btn btn-dark"/>
        <input type="hidden" name="food_to_update" value="<?php echo $running_variable['Rname']; ?>"/>
        <input type="hidden" name="name" value="<?php echo $running_variable['Name']; ?>"/>
      </form>
      </td>
      <td>
      <form action="food.php" method ="post">
        <input type="submit" name="actionBtn" value="Delete" class = "btn btn-danger"/>
        <input type="hidden" name="Food_to_delete" value="<?php echo $running_variable['Rname']; ?>"/>
        <input type="hidden" name="name" value="<?php echo $running_variable['Name']; ?>"/>
      </form>
      </td>  
      <td>
      <form action="food_review.php" method ="post">
        <input type="submit" name="actionBtn" value="Review" class = "btn btn-primary"/>
        <input type="hidden" name="Name" value="<?php echo $running_variable['Name']; ?>"/>
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