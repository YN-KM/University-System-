<?php
session_start();
require_once '../service.php';
Service::_connect($dbservername, $dbusername, $dbname, $dbpass); 
if(!isset($_SESSION['userid'])){
    $redirect_page = '../index.php';
    header('location:'.$redirect_page);  
}?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../favicon.ico" type="image/ico">
    <link rel="stylesheet" href="../css/fonts.css">
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../css/fontawesome.css">
    <link rel="stylesheet" href="../style.css">
    <title>profile</title>
</head>
<body>
<?php
        $sql = "SELECT * FROM user WHERE (id=".$_SESSION['userid'].") ";
        $result = Service::$conn->query($sql);
            $row = $result->fetch_assoc();
            $fullname=$row["firstname"]. " " . $row["lastname"];

?>
<div class="container">
       <div class="nav-bar">
       <h1> Welcome <span> <?php echo $fullname; ?></span></h1>
       <div class="links">
           <a class="active" href="./profile.php?<?php echo $_SESSION['userid'] ?>">Profile</a>
           <a href="send.php?id=<?php echo $_SESSION['userid'] ?>">send request</a>
           <a class="logout"href="../logout.php">Log Out</a>
       </div>
       </div>
       <div class="profile-content">
           <form action="../router.php" method="POST">
           <div class="info-field">
                <label for="info">first name</label>
                <input type="text" value="<?php echo $row["firstname"]?>" maxlength="15" name="fname" required>
            </div>
            <div class="info-field">
                <label for="info">last name</label>
                <input type="text"value="<?php echo $row["lastname"]?>" maxlength="15" name="lname" required>
            </div>
            <div class="info-field">
                <label for="info">email</label>
                <input type="text" value="<?php echo $row["email"]?>" maxlength="15" name="email" required>
            </div>
            <div class="info-field">
                <label for="info">phone </label>
                <input type="text" value="<?php echo $row["phone"]?>" maxlength="15" name="phone" required>
            </div>
            <div class="info-field select-info">
                <label for="major"> Major </label>
                <select class="select" name="major" id="major">
                    <?php
                    $sql1 = "SELECT id,name FROM major";
                    $result1 = mysqli_query(Service::$conn, $sql1);
                    if (mysqli_num_rows($result1) > 0) {
                        while ($row1 = mysqli_fetch_assoc($result1)) {
                            if($row["id_major"] == $row1["id"] ){
                                echo "<option selected  value= " . $row1["id"] . ">" . $row1["name"] . " </option>";
                            }
                            else{
                                echo "<option  value= " . $row1["id"] . ">" . $row1["name"] . " </option>";
                            }
                            
                        }
                    }
                    ?> 
                </select>
            </div>
            <div class="info-field select-info">
                <label for="year">Education year </label>
                <select class="select" name="year" id="year">
                     <?php
                    $sql2 = "SELECT id, title FROM year";
                    $result2 = mysqli_query(Service::$conn, $sql2);
                    if (mysqli_num_rows($result2) > 0) {
                        while ($row2 = mysqli_fetch_assoc($result2)) {
                            if($row["id_year"] == $row2["id"] ){
                                echo "<option selected value= ". $row2["id"] . ">" . $row2["title"] . " year</option>";
                            }
                            else{
                                echo "<option  value= " . $row2["id"] . ">" . $row2["title"] ." year </option>";
                            }
                            
                        }
                    } ?> 
                </select>
            </div>
            <button type="submit" name='update'><i class="fas fa-edit" style="margin-right:5px"></i>Update</button>
            <span class="success-msg"> <?php 
                if(isset($_SESSION['updated']))
                echo $_SESSION['updated'] .'<i class="far fa-check-circle"></i>'?></span>
           </form>
      
   </div> 
</body>
</html>