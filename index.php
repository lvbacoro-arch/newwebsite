<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- REGISTER FORM -->
    <div class="container" id="registerForm">
        <h1 class="title">Register</h1>

        <form method="post" action="register.php">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="fName" id="fName" required>
                <label for="fName">First Name</label>
            </div>

            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="lName" id="lName" required>
                <label for="lName">Last Name</label>
            </div>

            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="regEmail" required>
                <label for="regEmail">Email</label>
            </div>

            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="regPassword" required>
                <label for="regPassword">Password</label>
            </div>

            <input type="submit" class="btn" value="Sign Up" name="signup">
        </form>

        <p class="or">----- or -----</p>

        <div class="icons">
            <i class="fab fa-google"></i>
            <i class="fab fa-facebook-f"></i>
        </div>

        <div class="links">
            <p>Already have an account?</p>
            <button id="signInButton">Sign In</button>
        </div>
    </div>

    <!-- LOGIN FORM -->
    <div class="container" id="loginForm" style="display: none;">
        <h1 class="title">Sign In</h1>

        <form method="post" action="register.php">
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" id="loginEmail" required>
                <label for="loginEmail">Email</label>
            </div>

            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="loginPassword" required>
                <label for="loginPassword">Password</label>
            </div>

            <p class="recover">
                <a href="#">Recover Password?</a>
            </p>

            <input type="submit" class="btn" value="Sign In" name="signIn">
        </form>

        <div class="icons">
            <i class="fab fa-google"></i>
            <i class="fab fa-facebook-f"></i>
        </div>

        <div class="links">
            <p>Don't have an account yet?</p>
            <button id="signUpButton">Sign Up</button>
        </div>
    </div>

    <!-- SCRIPT TO SWITCH FORMS -->
    <script>
        document.getElementById("signInButton").onclick = function () {
            document.getElementById("registerForm").style.display = "none";
            document.getElementById("loginForm").style.display = "block";
        }

        document.getElementById("signUpButton").onclick = function () {
            document.getElementById("loginForm").style.display = "none";
            document.getElementById("registerForm").style.display = "block";
        }
    </script>

</body>
</html>

