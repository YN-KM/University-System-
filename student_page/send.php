<?php
session_start();
require_once '../service.php';
Service::_connect($dbservername, $dbusername, $dbname, $dbpass);
if (!isset($_SESSION['userid'])) {
    $redirect_page = '../index.php';
    header('location:' . $redirect_page);
}
?>
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
    <link rel="icon" href="../favicon.ico" type="image/ico">
    <link rel="stylesheet" href="../css/fonts.css">
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../css/fontawesome.css">
    <link rel="stylesheet" href="../style.css">
    <title>send request</title>
</head>

<body>
    <?php
    $sql = "SELECT id, firstname, lastname FROM user WHERE (id=" . $_SESSION['userid'] . ") ";
    $result = Service::$conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $fullname = $row["firstname"] . " " . $row["lastname"];
        }
    } ?>
    <div class="container">
        <div class="nav-bar">
            <h1> Welcome <span><?php echo $fullname; ?></span></h1>
            <div class="links">
                <a href="./profile.php?id=<?php echo $_SESSION['userid'] ?>">Profile</a>
                <a class="active" href="send.php?id=<?php echo $_SESSION['userid'] ?>">send request</a>
                <a class="logout" href="../logout.php">Log Out</a>
            </div>
        </div>

        <div class="send-content">
            <h2>write your request</h2>
            <form action="../router.php" method="POST">
                <div class="request-title">
                    <label for="request-type">Request type :</label>
                    <select name="request" id="">
                        <?php
                        $sql1 = "SELECT id,title FROM attestation";
                        $result1 = mysqli_query(Service::$conn, $sql1);
                        if (mysqli_num_rows($result1) > 0) {
                            while ($row1 = mysqli_fetch_assoc($result1)) {
                                echo "<option value= " . $row1["id"] . ">" . $row1["title"] . " </option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <textarea name="message" placeholder="your message" rows="10"></textarea>
                <button type="submit" name="send"><i class="fas fa-paper-plane" style="margin-right:10px"></i>Send</button>
                <span class="success-msg"> <?php 
                if(isset($_SESSION['sent']))
                echo $_SESSION['sent']."<i class='far fa-check-circle'></i>"?></span>
            </form>
        </div>
    </div>
<?php
        $sql2 = "SELECT u.id,r.comment,r.date,r.id,r.finished,a.title FROM user u INNER JOIN request r on u.id=r.user_id INNER JOIN attestation a on r.attestation_id=a.id WHERE u.id = $_SESSION[userid]";
        $result2 = Service::$conn->query($sql2);
         ?>
         <div style="margin:50px">
         <h2 class="myrequest">my request : </h2>
    <table id="example" class="display" >
                <thead>
                    <tr>
                        <th>request type</th>
                        <th>comment</th>
                        <th>date</th>
                        <th>request status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row2 = $result2->fetch_assoc()) {
                        echo "<tr>
            <td>" . $row2["title"] . "</td>
            <td>" . $row2["comment"] . "</td>
            <td>" . $row2["date"] . "</td>
            <td>" . $row2["finished"] . "</td>
            </tr>";}
            ?>
            </tbody>
     </table>
     </div>
</body>

<script>
$(document).ready(function() {
  $('#example').DataTable();
} );</script>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>


</html>