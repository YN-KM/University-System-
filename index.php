
<?php
session_start();
require_once './service.php';
Service::_connect($dbservername, $dbusername, $dbname, $dbpass); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="favicon.ico" type="image/ico">
    <link rel="stylesheet" href="./css/fonts.css">
    <link rel="stylesheet" href="./css/all.css">
    <link rel="stylesheet" href="./css/fontawesome.css">
    <link rel="stylesheet" href="style.css">
    <title>YamSam</title>
</head>

<body>
    <div class=" form " id="login">
        <form class="sign-in" method="POST" action="./router.php">
            <h2>Login</h2>
            <div class="input-field">
                <i class="fas fa-envelope"></i>
                <input type="email" placeholder="Email" name="email" required>
            </div>
            <div class="input-field">
                <i class="fas fa-lock"></i>
                <input type="password" placeholder="Password" name="password" required>
            </div>
            <span class="wrong-msg">
                <?php 
                if(isset($_SESSION['wrong_data']))
                echo $_SESSION['wrong_data'] ?>
            </span>
            <input class="btn" type="submit" value="login" name="login">
            <p id="sign-up-btn" class="switch">Create new account?</p>
            <img src="images/sign-in.svg" alt="">
        </form>
        <img src="images/graduation.svg" alt="" srcset="">
        

    </div>
    <div class="form registr" id="registr">
        <form class="sign-up" action="router.php" method="POST">
            <h2>Create account</h2>

            <div class="input-field">
                <i class="fas fa-user"></i>
                <input type="text" placeholder="First Name" maxlength="15" name="fname" required>
            </div>
            <div class="input-field">
                <i class="fas fa-users"></i>
                <input type="text" placeholder="Last Name" maxlength="15" name="lname" required>
            </div>
            <div class="input-field">
                <i class="fas fa-phone-alt"></i>
                <input type="tel" placeholder="phone number" name="phone" required>
            </div>
            <div class="input-field">
                <i class="fas fa-envelope"></i>
                <input type="email" placeholder="Email" name="email" required>
            </div>
            <div class="input-field">
                <i class="fas fa-lock"></i>
                <input type="password" placeholder="Password" name="password" required>
            </div>
            <div class="input-field select-input">
                <label for="major">Your Major :</label>
                <select class="select" name="major" id="major">
                    <?php
                    $sql1 = "SELECT id,name FROM major";
                    $result1 = mysqli_query(Service::$conn, $sql1);
                    if (mysqli_num_rows($result1) > 0) {
                        while ($row1 = mysqli_fetch_assoc($result1)) {
                            echo "<option value= " . $row1["id"] . ">" . $row1["name"] . " </option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="input-field select-input">
                <label for="role">Education year :</label>
                <select class="select" name="year" id="year">
                    <?php
                    $sql = "SELECT id, title FROM year";
                    $result = mysqli_query(Service::$conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value= " . $row["id"] . ">" . $row["title"] . " year </option>";
                        }
                    } ?>
                </select>
            </div>

            <input class="btn" type="submit" value="Create" name="Create">
            <p id="sign-in-btn" class="switch">Already have an account</p>
        </form>
        <img  src="images/access.svg" alt="">
    </div>

    <script src="main.js"></script>
</body>

</html>