<?php
// Include CHeck Login file
require_once "../include/checklogin.php";
?>

<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "../../php/config.php";

    // Prepare a select statement
    $sql = "SELECT * FROM projects WHERE id = ?";

    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);

        // Set parameters
        $param_id = trim($_GET["id"]);

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                // Retrieve individual field value
                /*$name = $row["name"];
                $address = $row["address"];
                $salary = $row["salary"];*/
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }

        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close($link);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
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
                        <h1>View Record</h1>
                        <a href="update.php?id=<?=$row["id"]; ?>" class="btn btn-primary">Edit</a>
                    </div>
                    <div class="form-group">
                        <label>Ttile</label>
                        <p class="form-control-static"><?php echo $row["title"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>client</label>
                        <p class="form-control-static"><?php echo $row["client"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>category</label>
                        <p class="form-control-static"><?php echo $row["category"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>location</label>
                        <p class="form-control-static"><?php echo $row["location"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Date</label>
                        <p class="form-control-static"><?php echo date("d/m/Y", strtotime(@$row["pdate"])); ?></p>
                    </div>
                    <div class="form-group">
                        <label>description</label>
                        <p class="form-control-static"><?php echo $row["description"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>images</label> <br />

                        <?php
                        $imagesArr = json_decode($row["images"]);
                        $imagesArr = array_reverse($imagesArr);

                        foreach ($imagesArr as $key => $imgsrc): ?>
                              <img src="//<?=$_SERVER['SERVER_NAME']?>/jithin01/images/upload/<?= $imgsrc?>" width="100px" class="rounded"
                               style="object-fit: contain;height: 100px;">
                        <?php endforeach; ?>
                    </div>
                    <div class="form-group">
                        <label>status</label>
                        <p class="form-control-static"><?php
                          if($row["status"] == 1){ echo PENDING;}
                          else if($row["status"] == 2){ echo PROGRESSING;}
                          else if($row["status"] == 3){ echo COMPLETED;}  ?></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
