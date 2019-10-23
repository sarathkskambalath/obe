<?php
// Include CHeck Login file
require_once "../include/checklogin.php";
$_PHP_SELF = $_SERVER['PHP_SELF'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 10px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>
<body>
  <?php // Include CHeck Login file
  require_once "../include/navbar.php";
  ?>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Projects List</h2>
                        <a href="create.php" class="btn btn-success pull-right">Add New Projects</a>
                    </div>
                    <div class="row">
                        <form action="" name="search">
                        	<div class="form-group-">
                              <div class="input-group col-sm-6 pull-right">
                                  <div class="col-sm-9" style="padding:0">
                                    <input type="text" class="form-control" name="searchcontent" id="searchcontent" aria-label="" aria-describedby="basic-addon1" placeholder="Search Here..." value="<?=@$_GET['searchcontent']?>">
                                  </div>
                                  <div class="col-sm-3" style="padding:0">
                                    <button class="btn btn-success btn-outline-secondary" type="submit" name="891651"><i class="fa fa-search" aria-hidden="true"></i>Search</button>
                                  </div>
                              </div>
                          </div>
                        </form>
                        <div class="clearfix"><br></div>
                    </div>
                    <div class="row">  <div class="clearfix"><br></div></div>
                    <?php
                    // Include config file
                    require_once "../../php/config.php";

                    $page         = 0;
                    $rec_limit    = 20;
                    $pagenolimit  = 2;
                    $nuofpage     = 0;
                    $searchcontent= '';
                    $SearchCluse  = '';

                    /* Get SEARCH DATA */
                    if(isset($_GET['searchcontent'])){
                      $searchcontent = $_GET['searchcontent'];
                      $SearchCluse   = 'WHERE title LIKE "%'.$searchcontent.'%" OR
                                         category LIKE "%'.$searchcontent.'%" OR
                                         location LIKE "%'.$searchcontent.'%" OR
                                         client LIKE "%'.$searchcontent.'%"
                                       ';
                    }

                    /* Get total number of records */
                     $sql = "SELECT count(id) FROM projects ".$SearchCluse." ;";
                     $retval = mysqli_query( $link, $sql );

                     if(! $retval ) {
                        die('Could not get data: ' . mysqli_error());
                     }
                     $row = mysqli_fetch_array($retval, MYSQLI_NUM );
                     $rec_count = $row[0];

                     if($rec_count>=1){
                       $nuofpage = $rec_count / $rec_limit;

                       if( !empty(explode('.',$nuofpage)[1]) ){
                         $nuofpage     = explode('.',$nuofpage)[0];
                       }else {
                         $nuofpage     = (explode('.',$nuofpage)[0])-1;
                       }
                     }

                    if(isset($_GET['page'])){
                      $page         = $_GET{'page'};
                      $offset       = $rec_limit * $page ;
                      $nuofpage     = $rec_count / $rec_limit;

                      if( !empty(explode('.',$nuofpage)[1]) ){
                        $nuofpage     = explode('.',$nuofpage)[0];
                      }else {
                        $nuofpage     = (explode('.',$nuofpage)[0])-1;
                      }

                    }else {
                        $page         = 0;
                        $offset       = 0;
                     }

                    $SRN = $offset;
                    // Attempt select query execution
                    $sql = "SELECT * FROM projects  ".$SearchCluse." ORDER BY `id` DESC LIMIT ".$offset.", ".$rec_limit;
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Title</th>";
                                        echo "<th>Client</th>";
                                        echo "<th>Category</th>";
                                        echo "<th>Location</th>";
                                        echo "<th width='90px'>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                  $SRN++;
                                    echo "<tr>";
                                        echo "<td class='text-uppercase'>" . $SRN . "</td>";
                                        echo "<td class='text-uppercase'>" . $row['title'] . "</td>";
                                        echo "<td class='text-uppercase'>" . $row['client'] . "</td>";
                                        echo "<td class='text-uppercase' style='white-space: nowrap'>" . str_replace("_"," ",$row['category']) . "</td>";
                                        echo "<td class='text-uppercase'>" . $row['location'] . "</td>";
                                        echo "<td style='min-width: 90px;'>";
                                            echo "<a href='read.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                            echo "<a href='update.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil text-warning'></span></a>";
                                            echo "<a href='delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash text-danger'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }

                    // Close connection
                    mysqli_close($link);
                    ?>

                    <?php
                      $previoslink = $page-1;
                      $next        = $page+1;
                    ?>

                    <?php /*PAGINATION*/ ?>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item <?= ($page<=0)?'disabled':''?>"><a href = "<?=($page<1)?'#':$_PHP_SELF;?>" class="page-link" tabindex="-1">First</a></li>
                            <li class="page-item <?= ($page<=0)?'disabled':''?>"><a href = "<?=($page<1)?'#':$_PHP_SELF."?page=".$previoslink;?>" class="page-link" tabindex="-1">Previous</a></li>

                            <?php $looplimi  = ($page+$pagenolimit)>=$nuofpage?($nuofpage):($page+$pagenolimit);?>
                            <?php $loopstart = ($page+$pagenolimit)>($nuofpage)?(($page+1)-$pagenolimit):( ($page-1)<0?$page:$page-1);?>

                            <?php for($i=$loopstart;$i<=$looplimi;$i++): ?>
                                  <?php if ($i<0) { continue;} ?>
                                 <li class="page-item <?= ($page==$i)?'active':''?>"><a href="<?=$_PHP_SELF."?page=".$i;?>" class="page-link"><?=$i+1;?></a></li>
                            <?php endfor; ?>

                             <li class="page-item <?= ($page>=$nuofpage)?'disabled':''?>"><a href="<?= ($page>=$nuofpage)?'#':$_PHP_SELF."?page=".$next;?>" class="page-link">Next</a></li>
                            <li class="page-item <?= ($page>=$nuofpage)?'disabled':''?>"><a href = "<?=($page>=$nuofpage)?'#':$_PHP_SELF."?page=".$nuofpage;?>" class="page-link" tabindex="-1">Last</a></li>
                        </ul>
                    </nav>

                </div>
            </div>
        </div>
    </div>
</body>
</html>
