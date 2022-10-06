<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'server/vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'service.php';

Service::_connect($dbservername,$dbusername,$dbname,$dbpass);


class authentication {

	public static function login($email,$password){

        session_start();
		$sql = "SELECT * FROM user WHERE (email='".$email."' AND password='".$password."')";

            $result = Service::$conn->query($sql);
            $row = $result -> fetch_assoc();
                if($email==$row['email'] && $password==$row['password']){
                    $_SESSION['userid'] = $row['id'];
                    if($row['role']=='student'){
                        $redirect_page = './student_page/send.php?id='.$_SESSION['userid'];
                    header('location:'.$redirect_page);
                    }
                    elseif($row['role']=='employee'){
                        $redirect_page = './employe/request.php?id='.$_SESSION['userid'];
                        header('location:'.$redirect_page);
                    }else{
                        $redirect_page = './admin.php?id='.$_SESSION['userid'];
                        header('location:'.$redirect_page);
                }
                }
                else {
                    $_SESSION["wrong_data"] = "Wrong Email or Password !";
                    $redirect_page = './index.php';
                    header('location:'.$redirect_page);
                }

    }
 
	public static function register($fname,$lname,$email,$phone,$major,$year,$password){

        

		$sql = "INSERT INTO user(firstname,lastname, email,password,phone,role,id_year,id_major) VALUES ('".$fname."','".$lname."','".$email."','".$password."','".$phone."','student',".$year.",".$major.")";
        $result = Service::$conn->query($sql);
            if (!$result) {
                echo "no record created successfully:(". Service::$conn->error;
                die("Query failed");
            }

            header("Location:./index.php");
    }

    public static function update($fname,$lname,$email,$phone,$major,$year){
        session_start();
        $sql="UPDATE user set firstname='".$fname."',lastname='".$lname."',email='".$email."',phone='".$phone."',id_year=".$year.",id_major=".$major." WHERE id=".$_SESSION['userid']."";
        $result = Service::$conn->query($sql);
        $_SESSION["updated"] = " Your profile details have been updated ";
        if (!$result) {
            echo "no record updated successfully:(". Service::$conn->error;
            die("Query failed");
        }
        $_SESSION["updated"] = " Your profile details have been updated ";
        $redirect_page = './student_page/profile.php?id='.$_SESSION['userid'];
        header('location:'.$redirect_page);
    }

    public static function SendRequest($attestation,$comment){
        session_start();
         $date= date('Y/m/d');
         $userid=$_SESSION['userid'];
         $sql = "INSERT INTO request(date,comment,user_id,attestation_id,finished) VALUES ('".$date."','".$comment."','".$userid."','".$attestation."','hold')";
         $result = Service::$conn->query($sql);
         if (!$result) {
             echo "no record inserted successfully:(". Service::$conn->error;
             die("Query failed");
         }
         $_SESSION["sent"] = " Request has been sent successfully ";
         header('Location:./student_page/send.php?id='.$_SESSION['userid']);
        }



        public static function finishRequest($id){
            session_start();
            $sql="UPDATE request set finished='accept' where id=". $id;
             $result = Service::$conn->query($sql);
             if (!$result) {
                 echo "no record inserted successfully:(". Service::$conn->error;
                 die("Query failed");
             }
             $sql1="SELECT r.id , u.firstname ,u.email FROM request r INNER JOIN user u ON r.user_id = u.id WHERE r.id=".$id;
             $result1 = Service::$conn->query($sql1);
             $row1 = $result1->fetch_assoc();
             $msg="Hello ".strtoupper($row1['firstname'])." , Your Request has been accepted, please come to the office tomorrow morning ";
             $subject = "Request Finished";
             authentication::sendEmail($subject ,$row1['email'] , $msg);
             header('location:./employe/request.php');
             
            }



            public static function rejectRequest($id){
                session_start();
                $sql="UPDATE request set finished='reject' where id=". $id;
                 $result = Service::$conn->query($sql);
                 if (!$result) {
                     echo "no record inserted successfully:(". Service::$conn->error;
                     die("Query failed");
                 }
                 $sql1="SELECT r.id , u.firstname ,u.email FROM request r INNER JOIN user u ON r.user_id = u.id WHERE r.id=".$id;
                 $result1 = Service::$conn->query($sql1);
                 $row1 = $result1->fetch_assoc();
                 $msg="Hello ".strtoupper($row1['firstname'])." , Your Request has been rejected ";
                 $subject = "Request rejected";
                 authentication::sendEmail($subject , $row1['email'], $msg);
                 header('location:./employe/request.php');
                 
                }



                 public static function undoRequest($id){
                session_start();
                $sql="UPDATE request set finished='hold' where id=". $id;
                 $result = Service::$conn->query($sql);
                 if (!$result) {
                     echo "no record inserted successfully:(". Service::$conn->error;
                     die("Query failed");
                 }
                 header('location:./employe/finished.php');
                 
                }




                public static function removeemploye($id){
                    session_start();
                    $sql="DELETE FROM user WHERE id=". $id;
                     $result = Service::$conn->query($sql);
                     if (!$result) {
                         echo "no record inserted successfully:(". Service::$conn->error;
                         die("Query failed");
                          }
                          header('location:./admin.php');
                     }

                     public static function addemploye($fname,$lname,$email,$phone){
                
                    $strig="qwertyuioplkjhgfdsazxcvbnm0123456789QWERTYUIOPLKJHGFDSAZXCVBNM0123456789";
                    $password=substr(str_shuffle($strig),0,8);
                        $sql = "INSERT INTO user(firstname,lastname, email,password,phone,role) VALUES ('".$fname."','".$lname."','".$email."','".$password."','".$phone."','employee')";
                        $result = Service::$conn->query($sql);
                        $msg="Hello ".strtoupper($fname).", You have been appointed as a Student Affairs Officer,Your account password is '".$password."' .";
                        $subject = "employee account";
                        authentication::sendEmail($subject ,$email, $msg);
                            if (!$result) {
                                echo "no record created successfully:(". Service::$conn->error;
                                die("Query failed");
                            }
                            header('location:./admin.php');
                    }
                    
                    
                    public static function sendEmail($subject , $email , $msg){
                        $mail = new PHPMailer(true);                              
                        try {
                            //Server settings                           
                           $mail->isSMTP(true);                                     
                           $mail->Mailer = "smtp";

                            $mail->Host = "smtp.gmail.com";
                            //Set this to true if SMTP host requires authentication to send email
                            $mail->SMTPAuth = true;
                            $mail->Port = 587;
                            $mail->SMTPSecure = 'tls';   
                            //Provide username and password
                            $mail->Username = "yam.22.sam@gmail.com";
                            $mail->Password = "sxvgwvwkkgaakdps";
                            $name = "YamSam-Affaire";
                            $mail->email_from = "yam.22.sam@gmail.com";
                            $to = $email;
                            //Recipients
                            $mail->setFrom($mail->Username, $name);
                            $mail->addAddress($to);     // Add a recipient
                            $mail->addReplyTo($email, $name);
                        
                            //Content
                            //$mail->isHTML(true);                                 
                            $mail->Subject = $subject;
                            $mail->Body    = $msg;
                            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                        
                            $mail->send();
                            echo json_encode([
                                'status' => 'success',
                            ]);
                        } catch (Exception $e) {
                            echo json_encode([
                                'status' => 'error',
                                'data' => [
                                    'Unable to send message. Try again later',
                                ],
                            ]);
                        }
                    }
    }
