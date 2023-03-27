<?php 
//REGISTER VALIDATION
ini_set('session.gc_maxlifetime', (3600*24*30*12));
session_set_cookie_params(3600*24*30*12);
session_start();

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $errors = [];
    $passPattern = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/" ;

    //USER NAME Validation
    if(empty($name)){
        $errors [] = "please enter User Name";
    }elseif (strlen($name) < 2) {

        $errors [] = "please Make sure that your User Name is longer than 2 letters";
        //EMAIL Validation
    }elseif(empty($email)){
        $errors [] = "please enter email";
    }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors [] = "Please adhere to the Email format ex@ex.com";
    }
    //PASSWORD Validation
    elseif(empty($password)){
        $errors [] = "please enter Password";
    }elseif (!preg_match($passPattern, $password)) {
        $errors [] = "Please Make Sure that your password is more than 8 characters and contains at least 1 uppercase, lowercase, number and special character";
    }
        
      
       
     if(!empty($errors)){
        $_SESSION['errors'] = $errors ;
        header('location: Register.php');
        
    } 


   if(empty($errors)){
       $_SESSION['accounts'][]= ['name'=> $name , 'email' => $email , 'password'=> $password];
       setcookie('status', 'exist' ,time()+3600);
       header('location: index.php');
      
   }
   

}
?>
<!-- //LOGIN PAGE HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
<div class="w-75 p-5 m-auto shadow-lg rounded">
    <h2 class="py-2">Login</h2>
    <form action="application.php" method="POST">
        <label for="">Email</label>
        <input name="useremail" class="form-control my-2" type="email">
        <label for="">Password</label>
        <input name="userpassword" class="form-control my-2" type="password">
        <span>Don't Have an account? you can <a href="Register.php">Register</a>!</span>
        <br>
        <button name="login" class=" my-3 btn btn-lg btn-outline-success" type="submit">Login</button>
    </form>
</div>

<div class="w-50 m-auto py-3">
    
        <?php 
        //REGISTER SUCCESS NOTIFICATION
        if(isset($_COOKIE['status'])){

            echo "<div class='alert alert-success'><ul>";

            
               echo "<li><p>Registered successfully</p></li>";
            

            echo "</ul></div>";
           setcookie('status' , null);
        }
        
        //LOGIN ERROR NOTIFICATION
        if(!empty($_SESSION['loginerrors'])){
            echo "<div class='alert alert-danger'><ul>";

            foreach ($_SESSION['loginerrors'] as $key => $value) {
                echo "<li><p>$value</p></li>";
            }
              
            

            echo "</ul></div>";
            $_SESSION['loginerrors'] = null ;
        }
        
        ?>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>  

<?php 


?>
