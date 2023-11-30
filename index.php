<?php
    include("database.php")
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script defer src="checker.js"></script>
</head>
<body>
    
    <div class="container" id="container">      
        <div class="form-container sign-up">
            
            

            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post" id="form">
                <h1>Create Account</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <span>or use your email for registeration</span>
                <input type="text" placeholder="First Name" name="first-name" id="firstname" required >
                <input type="text" placeholder="Middle Name" name="middle-name" required>
                <input type="text" placeholder="Last Name" name="last-name" >
                <input type="text" placeholder="username" name="username-1" id="username" required>
                <input type="text" placeholder="Address" name="address" required>
                <input type="date" placeholder="birthday" name="birthday" >
                <input type="email" placeholder="Email" name="email-1" id="email" required>
                <input type="tel" placeholder="Contact" name="contact" required>
                <input type="password" placeholder="Password" name="password-1" id="password" required>
                <button type="submit" name="submit" value="submit">submit</button>
                <button type="reset" name="reset" value="reset" onclick="showResetNotification()">reset</button>

                <script>
                    function showResetNotification() {
                        alert("Sign up cancelled");
                    }</script>

                <?php
                    if($_SERVER["REQUEST_METHOD"] == "POST"){
                        $firtname = filter_input(INPUT_POST, "first-name", FILTER_SANITIZE_SPECIAL_CHARS);
                        $middlename = filter_input(INPUT_POST, "middle-name", FILTER_SANITIZE_SPECIAL_CHARS);
                        $lastname = filter_input(INPUT_POST, "last-name", FILTER_SANITIZE_SPECIAL_CHARS);
                        $username = filter_input(INPUT_POST, "username-1", FILTER_SANITIZE_SPECIAL_CHARS);
                        $address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_SPECIAL_CHARS);
                        $birthday = filter_input(INPUT_POST, "birthday", FILTER_SANITIZE_SPECIAL_CHARS);
                        $email = filter_input(INPUT_POST, "email-1", FILTER_SANITIZE_SPECIAL_CHARS);
                        $contact = filter_input(INPUT_POST, "contact", FILTER_SANITIZE_SPECIAL_CHARS);
                        $password = filter_input(INPUT_POST, "password-1", FILTER_SANITIZE_SPECIAL_CHARS);
                        $duplicateEmail = mysqli_query($conn, "SELECT * FROM registration WHERE email = '$email'");   
                        $duplicateUsername = mysqli_query($conn, "SELECT * FROM registration WHERE username = '$username'");
                        $duplicateContact = mysqli_query($conn, "SELECT * FROM registration WHERE contact = '$contact'");
                        
                        if(empty($firtname)){
                            echo"please enter a first name";
                        }
                        elseif(empty($middlename)){
                            echo"please enter a middle name";
                        }
                        elseif(empty($lastname)){
                            echo"please enter a last name";
                        }
                        elseif(empty($username)){
                            echo"please enter a username";
                        }
                        elseif(empty($address)){
                            echo"please enter a address";
                        }
                        elseif(empty($birthday)){
                            echo"please enter a birthday";
                        }
                        elseif(empty($email)){
                            echo"please enter a email";
                        }
                        elseif(empty($contact)){
                            echo"please enter a contact";
                        }
                        elseif(empty($password)){
                            echo"Please enter a password";
                        }
                        elseif(mysqli_num_rows($duplicateEmail) > 0){
                            echo"<script> alert('E-mail already in use. ') </script>";
                        }
                        elseif(mysqli_num_rows($duplicateUsername) > 0){
                            echo"<script> alert('Username already exist. ') </script>";
                        }
                        elseif(mysqli_num_rows($duplicateUsername) > 0){
                            echo"<script> alert('Contact number already in use. ') </script>";
                        }
                        else{
                            $hash = password_hash($password, PASSWORD_DEFAULT);
                            $sql = "INSERT INTO registration (first_name, middle_name, last_name, username, address, birthday, email, contact, password)
                                    VALUES ('$firtname','$middlename','$lastname','$username','$address','$birthday','$email','$contact','$password')";
                                mysqli_query($conn,$sql);
                                echo"<script> alert('Sign up complete!!') </script>";
                        
                        }
                        
                    }

                    
                    
                ?>
                        
            </form>

        </div>  
        <div class="form-container sign-in">
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
                <h1>Sign In</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                    
                </div>
                <span>or use your email password</span>
                <input type="text" placeholder="username" name="username-2" required>
                <input type="password" placeholder="Password" name="password-2" required>
                <a href="#">Forget Your Password?</a>
                <button type="submit" name="login" value="login">login</button>
                
                <?php
                    if(isset($_POST["login"])){

                        $username1= filter_input(INPUT_POST, "username-2", FILTER_SANITIZE_SPECIAL_CHARS);
                        $password1 = filter_input(INPUT_POST, "password-2", FILTER_SANITIZE_SPECIAL_CHARS);
                        $result = mysqli_query($conn, "SELECT * FROM registration WHERE username = '$username1'");
                        $row = mysqli_fetch_assoc($result);
                        if(mysqli_num_rows($result) > 0){
                            if($password1 == $row["password"]){
                                $_SESSION["login"] = true;
                                $_SESSION["id"] = $row["id"];
                                header("Location:member.html");
                            }
                            else{
                                echo"<script> alert('Wrong password, Please try again') </script>";
                            }
                        }
                        else{
                            echo"<script> alert('Username are not registered') </script>";
                        }
                    

                        if(empty($username1)){
                            echo"<p style='color: red;'>Please Enter a Username</p>";
                        }

                        elseif(empty($password1)){
                            echo"<p style='color: red;'>Please Enter a Password</p>";
                        }
                        
                    }
                ?>

            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>

                    
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Friend!</h1>
                    <p>Register with your personal details to use all of site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>





<?php

    mysqli_close($conn);
?>