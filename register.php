<?php
// Include config file

session_start();

require("connect-db.php");
require("friend-db.php");

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: simpleform.php");
    exit;
}
// Define variables and initialize with empty values
$username = $password = $confirm_password = $age= $schoolyear= $firstname=$lastname=$email="";
$username_err = $password_err = $confirm_password_err = $sy_err= $age_err=$fn_err=$ln_err=$email_err="";
 
// Processing form data when form is submitted

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{        
                $check=selectUser($_POST["username"]);              
                if(!empty($check)){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 4){
        $password_err = "Password must have atleast 4 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }  

    $param_password = password_hash($password, PASSWORD_DEFAULT);

    if($_POST["schoolyear"]<1 || $_POST["schoolyear"]>4){
        $sy_err="Please enter a valid school year";
    }     
    if(empty($_POST["schoolyear"])){
        $sy_err="Please enter school year";
    }


    if($_POST["age"]<18 || $_POST["age"]>100){
        $age_err="Please enter a valid age";
    }
    if(empty($_POST["age"])){
        $age_err="Please enter age";
    }


    if(empty($_POST["firstname"])){
        $fn_err="Please enter first name";
    }


    if(empty($_POST["lastname"])){
        $ln_err="Please enter last name";
    }


    if(!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/',trim($_POST["email"]))){
        $email_err="Please enter valid email";
    }

    if(empty($_POST["email"])){
        $email_err="Please enter email";
    }


    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)&& empty($age_err)&& empty($sy_err)){
        addUser($username,$_POST["email"],$_POST["firstname"],$_POST["lastname"],$password,$_POST["schoolyear"],$_POST["age"]);
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Computing_id</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <label>email</label>
                <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <label>first name</label>
                <input type="text" name="firstname" class="form-control <?php echo (!empty($fn_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $firstname; ?>">
                <span class="invalid-feedback"><?php echo $fn_err; ?></span>
            </div>
            <div class="form-group">
                <label>last name</label>
                <input type="text" name="lastname" class="form-control <?php echo (!empty($ln_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lastname; ?>">
                <span class="invalid-feedback"><?php echo $ln_err; ?></span>
            </div>
            <div class="form-group">
                <label>school year</label>
                <input type="number" name="schoolyear" class="form-control <?php echo (!empty($sy_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $schoolyear; ?>">
                <span class="invalid-feedback"><?php echo $sy_err; ?></span>
            </div>
            <div class="form-group">
                <label>age</label>
                <input type="number" name="age" class="form-control <?php echo (!empty($age_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $age; ?>">
                <span class="invalid-feedback"><?php echo $age_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>