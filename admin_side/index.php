<?php 
include('login_process.php');
include('conn.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Clearance Signing System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/127fba62e2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/login.css">
    <link rel="shortcut icon" href="images/STI LOGO.png" type="image/x-icon">
</head>

<body>
    <header>
        <div class="yellow"></div>
        <div class="blue"> CLEARANCE SIGNING SYSTEM</div>
    </header>

    <main>
        <img src="images/loginthumbnail.jpg" alt="STI Poster">
        <form action="index.php" method="POST" autocomplete="off">
            <label class="access_level">ADMIN LOGIN</label>
            <div class="container">
                <div class="login_container">
                <div class="login">
                    <?php // include('successPrompt.php'); ?>
                    <?php include('errors.php'); ?>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            var successPrompt = document.getElementById('successPrompt');
                            var errorPrompt = document.getElementById('errorPrompt');
                            if (successPrompt) {
                                successPrompt.style.display = 'block';
                                setTimeout(function () {
                                    successPrompt.style.display = 'none';
                                }, 3000); // 3000 milliseconds = 3 seconds
                            }
                            if (errorPrompt) {
                                errorPrompt.style.display = 'block';
                                setTimeout(function () {
                                    errorPrompt.style.display = 'none';
                                }, 5000); // 5000 milliseconds = 5 seconds
                            }
                        });
                    </script>
                    
                    <input type="text" class="username" placeholder="Username" name="user">
                    <br>
                    <input type="password" class="username" placeholder="Password" name="pass" id="password-input">
                    <br>
                    <div class="checkbox-link-container">
                        <div class="checkbox-container">
                            <input type="checkbox" class="checkbox-show-pass" id="show-password-checkbox">
                            <label class="checkbox-label" for="show-password-checkbox">Show Password</label>
                        </div>
                        <!-- <a href="#" class="forgot-password-link">Forgot Password?</a> -->
                    </div>
                    <button type="submit" name="login" id="login-btn">LOGIN</button>
                    <br>
                    <br>
                    <label class="or">or</label>
                    <br>
                    <!-- <button type="submit" class="msO365">
                        <i class='bx bxl-microsoft'></i>
                        <span>Microsoft O365 Login</span>
                    </button> -->
                    <div class="ms_btn">
                        <a href="login_using_msO365/signin.php" class="msO365">
                            <div class="flex-row">
                                <i class='bx bxl-microsoft' id="ms-O365-icon"></i>
                                <label class="ms-icon-label" for="ms-O365-icon">Microsoft O365 Login</label>
                            </div>
                        </a>
                    </div>
                </div>

                <script>
                    // Get the password input and the show password checkbox
                    const passwordInput = document.getElementById('password-input');
                    const showPasswordCheckbox = document.getElementById('show-password-checkbox');

                    // Add an event listener to the checkbox
                    showPasswordCheckbox.addEventListener('change', function () {
                        // If the checkbox is checked, set the type of the password input to "text"; otherwise, set it to "password"
                        passwordInput.type = this.checked ? 'text' : 'password';
                    });
                </script>

                </div>
            </div>
        </form>
    </main>

    <footer>
        <div class="footer">
            <a href="https://sti.edu/" class="stiOfficial">STI College Official Website</a>

            <h3 class="socials">Socials</h3>
            <a href="https://web.facebook.com/alabang.sti.edu" class="social_links"><i class="fa-brands fa-facebook"></i><span> STI College Alabang</span></a>
            <a href="https://www.instagram.com/sti_college/" class="social_links"><i class="fa-brands fa-instagram"></i><span> @sti_college</span></a>
            <a href="https://x.com/sticollege?s=20" class="social_links"><i class='fa-brands fa-x-twitter'></i><span> @sticollege</span></a>
        </div>
        <div class="copyright">
            <p class="text">Copyright &copy; <span id="current-year"></span> STI College Alabang. All rights reserved.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="js/copyright.js"></script>
</body>

</html>