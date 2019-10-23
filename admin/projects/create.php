<?php
// Include config file
require_once "../../php/config.php";

// Include CHeck Login file
require_once "../include/checklogin.php";

// Define variables and initialize with empty values
$title = $client = $category =  $location = $description = $images = $status = $pdate = "";
$title_err = $client_err = $category_err = $location_err = $description_err = $images_err = $pdate_err = $status_err = "";
$imagesArray = array();

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate title
    $input_title = trim($_POST["title"]);
    if(empty($input_title)){
        $title_err = "Please enter a title.";
    }else{
        $title = $input_title;
    }

    // Validate client
    $input_client = trim($_POST["client"]);
    if(empty($input_client)){
        $client_err = "Please enter an client.";
    } else{
        $client = $input_client;
    }

    // Validate category
    $input_category = trim($_POST["category"]);
    if(empty($input_category)){
        $category_err = "Please enter the category.";
    } else{
        $category = $input_category;
    }

    /**/
    // Check if file was uploaded without errors
    if(isset($_FILES["photo"]) and !empty($_FILES['photo']['name'][0]) ){

        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");

      for( $i=0 ; $i < count($_FILES['photo']['name']) ; $i++ ) {

          if(isset($_FILES['photo']) && $_FILES['photo']["error"][$i] == 0){


                  $filename = $_FILES['photo']["name"][$i];
                  $filetype = $_FILES['photo']["type"][$i];
                  $filesize = $_FILES['photo']["size"][$i];

                  // Verify file extension
                  $ext = pathinfo($filename, PATHINFO_EXTENSION);
                  if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");

                  // Verify file size - 5MB maximum
                  //  $maxsize = 5 * 1024 * 1024;
                  //  if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");

                  // Verify MYME type of the file
                  if(in_array($filetype, $allowed)){
                      // Check whether file exists before uploading it
                      if(file_exists("../../images/upload/" . $filename)){
                          //echo $filename . " is already exists. uSE THIS : 132".$filename ;
                          $filename = date('YmdHis').$filename;
                      }
                      if($filename){
                          move_uploaded_file($_FILES['photo']["tmp_name"][$i], "../../images/upload/" . $filename);
                          //echo "Your file was uploaded successfully.";
                          $imagesArray[] = $filename;
                      }
                  } else{
                    echo '<div class="alert alert-danger" role="alert">
                            Error: There was a problem uploading your file. Please try again.
                          </div>';
                  }

          }else{
            echo '<div class="alert alert-danger" role="alert">
                    Error: ' . $_FILES['photo']["error"][$i].'
                  </div>';
          }

      }

    }



    /**/

    $pdate       = date("Y-m-d", strtotime( trim($_POST["pdate"]) ) );
    $location    = trim($_POST["location"]);
    $description = trim($_POST["description"]);
    $images      = json_encode($imagesArray);
    $status      = $_POST["status"];



    // Check input errors before inserting in database
    if(empty($title_err) && empty($client_err) && empty($category_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO projects (title , client , category , location , pdate , description , images , status)
        VALUES ('".$title."', '".$client."', '".$category."','".$location."','".$pdate."','".$description."','".$images."','".$status."')";

        if (mysqli_query($link, $sql)) {
          /*  echo '<div class="alert alert-success text-center" role="alert">
                    New record created Successfully
                  </div>';*/
            header("location: index.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($link);
        }

    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
  <?php // Include CHeck Login file
  require_once "../include/navbar.php";
  ?>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add project record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group <?php echo (!empty($title_err)) ? 'has-error' : ''; ?>">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" value="<?php echo $title; ?>">
                            <span class="help-block"><?php echo $title_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($client_err)) ? 'has-error' : ''; ?>">
                            <label>Client</label>
                            <input type="text" name="client" class="form-control" value="<?php echo $client; ?>">
                            <span class="help-block"><?php echo $client_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($category_err)) ? 'has-error' : ''; ?>">
                            <label>Category</label>
                            <select  name="category" class="form-control">
                              <option value="">Select</option>
                              <?php
                                if(!empty($category_array)){
                                  foreach ($category_array as $value => $option) {
                                    if($category == $value){
                                      echo '<option selected value="'.$value.'">'.$option.'</option>';
                                    }else{
                                      echo '<option value="'.$value.'">'.$option.'</option>';
                                    }

                                  }
                                }
                              ?>
                            </select>
                            <span class="help-block"><?php echo $category_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($location_err)) ? 'has-error' : ''; ?>">
                            <label>Location</label>
                            <input type="text" name="location" class="form-control" value="<?php echo $location; ?>">
                            <span class="help-block"><?php  echo $location_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($pdate_err)) ? 'has-error' : ''; ?>">
                            <label>Date</label>
                            <input type="text" name="pdate" class="form-control datepicker" autocomplete="off" value="<?= ($pdate)?date("d/m/Y", strtotime( trim($pdate) ) ):date("d/m/Y");?>">
                            <span class="help-block"><?php  echo $pdate_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($description_err)) ? 'has-error' : ''; ?>">
                            <label>Description</label>
                             <textarea name="description" class="form-control"><?php echo $description; ?></textarea>
                            <span class="help-block"><?php echo $description_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($images_err)) ? 'has-error' : ''; ?>">
                            <label>Images</label>
                            <input type="file" id="photo" name="photo[]" class="form-control" multiple>
                            <div id="imgPreviewDiv" class="col-sm-12"><img src="" class="img-rounded preview-img" width="100px" style="object-fit:contains" /></div>
                            <span class="help-block"><?php echo $images_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($status_err)) ? 'has-error' : ''; ?>">
                            <label>Status</label>
                            <select  name="status" class="form-control">
                              <?php
                                if(!empty($status_array)){
                                  foreach ($status_array as $svalue => $status) {
                                      echo '<option value="'.$svalue.'">'.$status.'</option>';
                                  }
                                }
                              ?>
                            </select>
                            <span class="help-block"><?php echo $status_err;?></span>
                        </div>

                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
                <div class="clear-fix">
                  <br /> <br /> &nbsp; <br /> <br /> <br />
                </div>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
      $( function() {
        $( ".datepicker" ).datepicker();


        /*UPLOAD IMAGE PREVIEW*/
        function readURL(input) {

          $('#imgPreviewDiv').find('.preview-img').remove();

          if (input.files && input.files[0]) {

            console.log(input.files[0]);
            var temp = input.files[0];
            input.files[0] = input.files[1];
            input.files[1] = temp;
            console.log(input.files[0]);

            $.each(input.files,function(index,data){
              var reader = new FileReader();

              reader.onload = function(e) {
                $('#imgPreviewDiv').append('<img src="'+e.target.result+'" class="img-rounded preview-img" width="100px" style="object-fit:contains" alt="Cinque Terre">');
              }

              reader.readAsDataURL(input.files[index]);
            });

          }
        }

        $("#photo").change(function() {
          readURL(this);
        });
      } );
    </script>

</body>
</html>
