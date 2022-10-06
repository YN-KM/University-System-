<?php
session_start();
require_once './service.php';
require_once './router.php';
Service::_connect($dbservername, $dbusername, $dbname, $dbpass); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="../favicon.ico" type="image/ico">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <link rel="icon" href="favicon.ico" type="image/ico">
    <link rel="stylesheet" href="./css/fonts.css">
    <link rel="stylesheet" href="./css/all.css">
    <link rel="stylesheet" href="./css/fontawesome.css">
    <link rel="stylesheet" href="style.css">
    <title>Admin/affairs</title>
</head>

<body>
    <?php
    $sql = "SELECT * FROM user WHERE (role = 'employee')";
    $result = Service::$conn->query($sql);
    ?>

        <div class="nav-bar">
            <h1> Welcome to Admin page</h1>
            <div class="links">
                <a class="logout" href="./logout.php">Log Out</a>
            </div>
        </div>



        <div class="role" style="margin:50px 20px">
            <h2>Employees permissions </h2>
            <table id="example" class="display">
                <thead>
                    <tr>
                        <th>first name</th>
                        <th>last name</th>
                        <th>email</th>
                        <th>phone num</th>
                        <th>permission</th>
                        <th>remove</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) {
                        echo "<tr>
            <td>" . $row["firstname"] . "</td>
            <td>" . $row["lastname"] . "</td>
            <td>" . $row["email"] . "</td>
            <td>" . $row["phone"] . "</td>
            <td>" . $row["role"] . "</td>
            <td class='remove'><form action='./router.php' method='POST'> <input type='hidden' name='id' value='" . $row["id"] . "'/><button type='submit' name='remove'><i class='fas fa-user-minus'></i></button></form></td>
        </tr>";
                    }
                    ?>

                </tbody>
            </table>
        </div>
        <div class="employees">
        <form class="sign-up" action="router.php" method="POST">
            <h2>Add employees <i class="fas fa-arrow-circle-down"></i></h2>

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
            <input class="btn" type="submit" value="ADD" name="add">
        </div>

        <script>
            $(document).ready(function() {
                $('#example').DataTable();
            });
        </script>
<script>let createInpts = document.querySelectorAll('.employees  input');
createInpts.forEach(input => {
    input.addEventListener("focus", e => {
      input.parentElement.classList.add("focus");
    });
    input.addEventListener("blur", e => {
        input.parentElement.classList.remove("focus");
      })
});</script>
<script src="main.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
</body>

</html>