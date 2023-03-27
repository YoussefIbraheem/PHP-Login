<?php 
//APPLICATION VALIDATION
ini_set('session.gc_maxlifetime', (3600*24*30*12));
session_set_cookie_params(3600*24*30*12);
session_start();
header("refersh:0");
if(isset($_POST['submit'])){

    $appName = $_POST['appname'];
    $appEmail = $_POST['appemail'];
    $phoneNumber = $_POST['phone'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $website = $_POST['website'];
    $appErrors = [];
    $phonePattern = "/^[0][1-9]\d{9}$|^[1-9]\d{9}$/";
    $namePattern = "/^[A-Z][A-Za-z_ ]{1,}$/";
    $profile= $_FILES['profilepicture'];
    $cv = $_FILES['cv'];
    $project = $_FILES['project'];
    $fileTypes = ['jpg' , 'jpeg' , 'png' , 'gif' , 'pdf' , 'docx', 'doc' , 'pptx' , 'zip' , 'rar'];
    $fileTypesPics = ['jpg' , 'jpeg' , 'png' , 'gif'];
    $fileTypesDocs = ['pdf' , 'docx', 'doc' , 'pptx'];
    $profExt = strtolower(pathinfo($profile['name'],PATHINFO_EXTENSION));

    //NAME VALIDATION
    if(empty($appName)){
        $appErrors [] = "Please enter your full name";

    }elseif (strlen($appName) < 5) {
        $appErrors [] = "full name must be more than 5 characters";
    }elseif (!preg_match( $namePattern , $appName)) {
        $appErrors [] = "Name Must start with Uppercase";
         //PHONE NUM VALIDATION
    }elseif (empty($phoneNumber)) {
        $appErrors [] = "Please enter your Phone Number";
    }elseif (strlen($phoneNumber) < 11) {
        $appErrors [] = "Phone number must be at least 11 digits";
    }elseif (!preg_match( $phonePattern , $phoneNumber)) {
        $appErrors [] = "Please adhere to the phone number format";
         // EMAIL VALIDATION
    }elseif (!filter_var($appEmail, FILTER_VALIDATE_EMAIL)) {
        $appErrors [] = "Please Adhere to Email format ex@ex.com ";
        //WEB VALIDATION
    }elseif (!filter_var($website, FILTER_VALIDATE_URL)&&!empty($website)) {
        $appErrors [] = "Please enter valid URL ";
    }
    //PROFILE VALIDATION
    elseif (empty($profile['name'])) {
        $appErrors [] = "Please enter a profile Picture ";
    }
    
    if (!in_array($profExt,$fileTypesPics)) {
        $appErrors [] = "Please enter Profile Picture with valid format ";
    }
    
    if ( $profile['size']/(1024*1024) > 5  ) {
        $appErrors [] = "Please make sure that the file doesnt exceed 5mb size";
        //CV VALIDATION
    }elseif (empty($cv['name'])) {
        $appErrors [] = "Please enter your CV ";

    }
    
    foreach($cv['name'] as $key => $value){
        if (!in_array(strtolower(pathinfo($value,PATHINFO_EXTENSION)),$fileTypes)) {
            $appErrors [] = "Please enter CV files with valid format ";
        }
    }

    foreach ($cv['size'] as $key => $value) {
        if ($value /(1024*1024) > 100  ) {
            $appErrors [] = "Please make sure that the CV files doesnt exceed 5mb size";
            //PROJECT VALIDATION
        }
    }

    if (empty($project['name'])) {
            $appErrors [] = "Please enter your Projects ";
    }
    
    foreach ($project['name'] as $key => $value) {
        if (!in_array(strtolower(pathinfo($value,PATHINFO_EXTENSION)),$fileTypes)) {
            $appErrors [] = "Please enter Project files with valid format ";
    }
    }
    foreach ($project['size'] as $key => $value) {
        if ($value /(1024*1024) > 100  ) {
            $appErrors [] = "Please make sure that the CV files doesnt exceed 5mb size";
            //PROJECT VALIDATION
        }
    }

   if (empty($gender)) {
        $appErrors [] = "Please pick gender or pick 'Other' if you prfer not to say";
    }elseif (empty($dob)) {
        $appErrors [] = "Please set a date of birth";
    }

if(!empty($appErrors)){
    //DISPLAY ERRORS
    $_SESSION['apperrors'] = $appErrors;
    header('location:application.php');
}else{
    //FLIES UPLOAD
    move_uploaded_file($profile['tmp_name'],"profile/$profile[name]");
    $profilePic = array_slice(scandir('profile'),2) ;
    
    
    foreach ($cv['tmp_name'] as $key => $value) {
        $cvName = $cv['name'][$key]; 
        move_uploaded_file($value,"CVs/$cvName");
    }
    
    foreach ($project['tmp_name'] as $key => $value) {
        $projectName = $project['name'][$key]; 
        move_uploaded_file($value,"projects/$projectName");
    }
    
   
}
    ?>
    <!-- SUMMMARY HTML PAGE -->
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <title>Summary</title>
    </head>
    <body>
        <div class="w-75 m-auto p-5 shadow-lg rounded">
            <div class="p-5">
                
                <h1>My Summary</h1>
                <ul class="py-3">
                <li><h3>Full Name:</h3></li>
                <p> <?php echo $appName ;?></p>
                <li><h3>Email:</h3></li>
                <p> <?php echo $appEmail ;?></p>
                <li><h3>Phone Number:</h3></li>
                <p> <?php echo $phoneNumber ;?></p>
                <li><h3>Personal Website:</h3></li>
                <p><?php if(empty($website)){
                    echo "No URL Entered";
                }else{
                    echo $website; 
                } ;?></p>
                <li><h3>Date Of Birth:</h3></li>
                <p> <?php echo $dob ;?></p>
                <li><h3>Profile Picture:</h3></li>
                <div>
                <?php 
                echo "<div class='row'>
                <div class='col-md-12'>
                    <div>
                        <img class='w-25' src='profile/$profile[name]' alt=''>
                    </div>
                </div>
            </div>"
                ?>
              </div>
              <li><h3>CVs/Resume:</h3></li>
              <div> 
                  <?php
                  $cvPics = array_slice(scandir('CVs'),2) ;
                  echo "<ol>"; 

                  foreach ($cvPics as $key => $value) {
                      
                      echo "<li><a href='CVs/$value' download>CVs/$value</a></li>";
                     
                  }
                  echo "</ol>";
                  ?>
             
              </div>
              <li><h3>Projects:</h3></li>
              <div> 
                  <?php 
                  $projectPics = array_slice(scandir('projects'),2) ;
                  echo "<ol>"; 
                  foreach ($projectPics as $key => $value) {
                      
                      echo "<li><a href='CVs/$value' download>CVs/$value</a></li>";
                     
                  }
                  echo "</ol>";
                  ?>
             
              </div>
              </ul>
<!-- RETRIVE DATA FOR EDITING -->
                <form action="application.php" method="POST" enctype="multipart/form-data">
                    <input name="editname" value= "<?php echo $appName; ?>" type="hidden">
                    <input name="editemail" value= "<?php echo $appEmail; ?>" type="hidden">
                    <input name="editphone" value= "<?php echo $phoneNumber; ?>" type="hidden">
                    <input name="editdob" value= "<?php echo $dob; ?>" type="hidden">
                    <input name="editweb" value= "<?php echo $website; ?>" type="hidden">
                   <input name="editprofile" value= "<?php echo $profile['name']; ?>" type="hidden">
                   <input name="editcv" value= "<?php echo $cv['name']; ?>" type="hidden">
                   <input name="editproject" value= "<?php echo $project['name']; ?>" type="hidden">
                    <button type="submit" name="edit" class="btn btn-info btn-lg">Edit</button> 
                   <button type="submit" name="delete" class="btn btn-danger btn-lg">Delete</button> 
                   <button name="logout" class="btn m-2 btn-warning"><a class="text-decoration-none text-white" href="index.php">LogOut</a></button>
                    
                </form>
                


            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
    </html>
    <?php 
}




?>
