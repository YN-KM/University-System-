<?php session_start();
require_once '../service.php';
require_once "../serviceApi.php";
Service::_connect($dbservername, $dbusername, $dbname, $dbpass);
if (!isset($_SESSION['userid'])) {
    $redirect_page = './index.php';
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
     <link rel="stylesheet" href="../css/fonts.css">
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../css/fonts.css">
    <link rel="stylesheet" href="../style.css">
    <title>Document</title>
</head>
<body>

<?php
        $sql = "SELECT u.firstname,u.lastname,r.comment,r.date,r.id,a.title FROM user u INNER JOIN request r on u.id=r.user_id INNER JOIN attestation a on r.attestation_id=a.id WHERE r.finished = 'accept'";
        $result = Service::$conn->query($sql);
         ?>

    <div class="nav-bar">
       <h1>Welcome to employee section</h1>
       <div class="links">
           <a  href="request.php">Requests</a>
           <a class="active" href="finished.php">Finished request</a>
           <a class="logout" href="../logout.php">Log Out</a>
       </div>
    </div>
<table id="example" class="display">
    <thead>
        <tr>
            <th>first name</th>
            <th>last name</th>
            <th>attestation</th>
            <th>comment</th>
            <th>date</th>
            <th>finish</th>
        </tr>
    </thead>
    <tbody>
        <?php  while ($row = $result->fetch_assoc()){
       echo "<tr>
            <td>".$row["firstname"]."</td>
            <td>".$row["lastname"]."</td>
            <td>".$row["title"]."</td>
            <td>".$row["comment"]."</td>
            <td>".$row["date"]."</td>
            <td class='undo'><form action='../router.php' method='POST'> <input type='hidden' name='id' value='".$row["id"]."'/><button type='submit' name='undo'><i class='fas fa-undo'></i></button></form></td>
            </tr>";}
 ?>
    </tbody>
</table>


<script>
$(document).ready(function() {
  $('#example').DataTable();
} );</script>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

</body>

</html>