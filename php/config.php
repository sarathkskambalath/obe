<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'obearchitects_com_obe');
define('DB_PASSWORD', 'obe@2019');
define('DB_NAME', 'obearchitects_com_obe');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}


define('PENDING', 'Pendding');
define('PROGRESSING', 'Progressing');
define('COMPLETED', 'Completed');

define('ROOTPATH', __DIR__);
$status_array = array('1'=>'Under Construction','2'=>'Design Competition','3'=>'Completed');
$category_array = array('sports'=>'Sports','publicncultural'=>'Public & Cultural','education'=>'Education','mosques'=>'Mosques','villas'=>'Villas','commercial'=>'Commercial');


/**
 *
 */
class SendEmail
{

  function __construct()
  {
    // code...
  }

  //SEND EMAIL FOR CONTACT US
  Public function send_contact_us($DataArray){  

    //SENDING TO OBE ADMIN
      $to      = $DataArray['email'];
      $subject = $DataArray['subject'];

      $message = "
      <html>
      <head>
      <title>".$DataArray['subject']."</title>
      </head>
      <body>
      <p>Hi Admin,</p>
      <table>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Mobile</th>
        <th>Message</th>
      </tr>
      <tr>
        <td>".$DataArray['name']."</td>
        <td>".$DataArray['email']."</td>
        <td>".$DataArray['mobile']."</td>
        <td><p>".$DataArray['message']."</p></td>
      </tr>
      </table>
      </body>
      </html>
      ";

      // Always set content-type when sending HTML email
      $headers = "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

      // More headers
      $headers .= 'From: <'.$DataArray['from'].'>' . "\r\n";

      mail($to,$subject,$message,$headers);

    //Sending to CLIENT
      $to      = $DataArray['email'];
      $subject = 'Thank You For Contacting Us.';

      $message = "
      <html>
      <head>
      <title>Thank You For Contacting Us</title>
      </head>
      <body>
      <p>Hi ".$DataArray['name'].",</p>
      <p><br>
       Thank you for Contacting Us. Our Supporting team will contact you soon on either your Email ID or in Mobile Number.</p>
      <p><br> With Regards <br> Admin</p>
      </body>
      </html>
      ";

      // Always set content-type when sending HTML email
      $headers = "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

      // More headers
      $headers .= 'From: <'.$DataArray['from'].'>' . "\r\n";

      mail($to,$subject,$message,$headers);
    //DONE HERE
  }

}

$objSendEmail = new SendEmail();

?>
