<?php 
//LOGIN VALIDATION
ini_set('session.gc_maxlifetime', (3600*24*30*12));
session_set_cookie_params(3600*24*30*12);
session_start();

if(isset($_POST['login'])){
    $loginErrors = [];
    $userEmail = $_POST['useremail'];
    $userPassword = $_POST['userpassword'];
    $passPattern = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/" ;

  if(empty($userEmail)){
        $loginErrors [] = "Please enter email";
    }elseif (empty($userPassword)) {
        $loginErrors [] = "Please enter Password";
    }elseif (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        $loginErrors[] = "Please Adhere to Email format ex@ex.com ";
    }elseif (!preg_match($passPattern, $userPassword)) {
        $loginErrors[] = "Please Enter Valid Password ";
    }
    elseif(empty($_SESSION['accounts'])){
        $loginErrors[] = "No Accounts added Please Register "; 
    }elseif(!in_array($userEmail ,array_column($_SESSION['accounts'],'email'))){
        $loginErrors[] = "Account Not Found! Try again or <a href='Register.php'>Register</a>";
    }elseif ($userPassword != $_SESSION['accounts'][array_search($userEmail , array_column($_SESSION['accounts'],'email'))]['password']) {
        $loginErrors[] = "Incorrect Password Please Try again";
    }
    
    ///the line 22 : 28 is used to locate the enterd email and to see if its registerd 
    ///if true, $accountLocation returns the number of the array by using array_cloumn to create an array of the chosen proprites (email), then array_search manage look for the entered email so it can be matched with array that has the email then return the index of that array so we take and retrive the located array's password then pass it to the validation on line 28 to check if the entered email is accompinated with the correct password...
  

    if(!empty($loginErrors)){
        $_SESSION['loginerrors'] = $loginErrors ;
        header('location:index.php');
    }
}

?>
<!-- APPLICATION HTML PAGE -->

        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Application</title>
</head>
<body>
    <div class="w-75 m-auto p-5 shadow-lg rounded">
    <div class="">
        <h1>My Application</h1>
        <form enctype="multipart/form-data" action="summary.php" method="post">
           <label for="">Full Name *</label>
           <input class="form-control m-2" value="<?php if(isset($_POST['edit'])){echo $_POST['editname'];} ?>" name="appname" type="text"> 
           <label for="">Email *</label>
           <input class="form-control m-2" value="<?php if(isset($_POST['edit'])){echo $_POST['editemail'];} ?>" name="appemail" type="email">
           <label for="">Phone Number *</label>
           <input class="form-control  m-2" value="<?php if(isset($_POST['edit'])){echo $_POST['editphone'];} ?>" name="phone" type="number">
           <label for="">Personal Web</label>
           <input class="form-control  m-2" value="<?php if(isset($_POST['edit'])){echo $_POST['editweb'];} ?>" name="website" type="url">
           <label for="">Date Of Birth *</label>
           <br>
           <input class=" form-control form-control-sm   m-2" value="<?php if(isset($_POST['edit'])){echo $_POST['editdob'];} ?>" name="dob" type="date">
           <br>
           <label for="">Gender *</label>
           <br>
           <label for="">Male</label>
           <input class="m-2" name="gender" value="Male" checked type="radio">
           <label for="">Female</label>
           <input class="m-2" name="gender" value="female" type="radio">
           <label for="">Other</label>
           <input class="m-2" name="gender" value="other" type="radio">
           <br>
           <label for="">Upload Profile Picture *</label>
           <input class=" m-2 form-control form-control-sm" value="<?php if(isset($_POST['edit'])){echo $_POST['editname'];} ?>" name="profilepicture" type="file">
           <label for="">Upload CV/Resume *</label>
           <input class=" m-2 form-control form-control-sm" name="cv[]" type="file" multiple>
           <label for="">Upload Projects *</label>
           <input class=" m-2 form-control form-control-sm" name="project[]" type="file" multiple>
           <button type="submit" name="submit" class="btn btn-success m-2">Add Application</button>
           <button name="logout" class="btn m-2 btn-warning"><a class="text-decoration-none text-white" href="index.php">LogOut</a></button>
        </form>
        <br>
</div>
    </div>
    

    <div div class="w-50 m-auto py-3">
    <?php 
    // FORM DELETION NOTIFICATION
    if(isset($_POST['delete'])){
        echo "<div class='alert alert-success'><ul>";
        echo "<li>Form Deleted</li>";
        echo "</ul></div>";
        $profilePic = array_slice(scandir('profile'),2) ;
        $cvPics = array_slice(scandir('CVs'),2) ;
        $projectPics = array_slice(scandir('projects'),2) ;
        foreach ($profilePic as $key => $value) {
            unlink("profile/$value");
        }
        foreach ($cvPics as $key => $value) {
            unlink("CVs/$value");
        }
        foreach ($projectPics as $key => $value) {
            unlink("projects/$value");
        }
    }
    //APPLICATION ERROR NOTIFICATION
    if(!empty($_SESSION['apperrors'])){

        echo "<div class='alert alert-danger'><ul>";

        foreach ($_SESSION['apperrors'] as $key => $value) {
            echo "<li><p>$value</p></li>";
        }
          
        

        echo "</ul></div>";
        $_SESSION['apperrors'] = null ;
    }
   
    
    ?>
    </div>
    
   
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>



