<?php 
///THIS METHOD IS USED INSTEAD OF COOKIES AS I NEEDED TO STORE INPUTS IN ARRAYS!!
ini_set('session.gc_maxlifetime', (3600*24*30*12));
session_set_cookie_params(3600*24*30*12);
session_start();


?>
<!-- REGISTER HTML PAGE -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Jobs Finder</title>
</head>
<body>
<div class="w-50 py-3 m-auto text-center">
    <h1>Welcome To Jobs Finder</h1>
</div>

<div class="w-75 p-5 m-auto shadow-lg rounded">
    <h2 class="py-2">Register</h2>
    <form action="index.php" method="POST">
        <label for="">User Name</label>
        <input name="name" class="form-control my-2" type="text">
        <label for="">Email</label>
        <input name="email" class="form-control my-2" type="email">
        <label for="">Password</label>
        <input name="password" class="form-control my-2" type="password">
        <span>Already Regsitered? you can<a href="index.php">Login</a></span>
        <br>
        <button name="submit" class=" my-3 btn btn-lg btn-outline-success" type="submit">Register</button>
    </form>
</div>


<div class="w-50 m-auto py-3">
    
        <?php 
        //ERRORS
        if(!empty($_SESSION['errors'])){


            echo "<div class='alert alert-danger'><ul>";

            foreach ($_SESSION['errors'] as $key => $value) {
               echo "<li>$value</li>";
            }

            echo "</ul></div>";

            $_SESSION['errors'] = null ;
        }
        
        ?>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>




