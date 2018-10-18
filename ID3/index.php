<?php include 'database.php'; ?>

<?php
    /*
     * This section to handle the selected table
     */
    $table = "weathers";
    if(isset($_POST["select"]))
        $table = $_POST['table'];
?>



<?php
    /*
     * This part for testing the application
     * */
    /*echo "Entropy is " . Entropy("play", $table) . "<br />";
    echo "Information is " . information($table, "wind") . "<br />";
    echo "Gain is " . gain($table, "wind") . "<br />";*/
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ID3 Algorithm </title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/nprogress.css" rel="stylesheet">
    <link href="css/prettify.min.css" rel="stylesheet">
    <link href="css/custom.min.css" rel="stylesheet">
      <link rel="stylesheet" href="css/styleID3.css" />
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
              <div class="row">
                  <div class="col-md-8">
                      <div class="table-choose">
                          <form action="index.php" method="post">
                              <div class="form-group">
                                  <label for="table" class="control-label col-md-2">Select Table: </label>
                                  <div class="col-md-4">
                                      <select name="table" id="table" class="form-control select-table">
                                          <?php
                                          foreach(getTables('id3') as $tab)
                                          {
                                              ?>
                                              <option <?php if($table == $tab) echo "selected"; ?> value="<?php echo $tab ?>"><?php echo $tab; ?></option>
                                              <?php
                                          }
                                          ?>
                                      </select>
                                  </div>
                                  <div class="col-md-1">
                                      <input type="submit" name="select" value="Select" class="bt btn-primary" />
                                  </div>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_content">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                       <table class="table table-bordered">
                            <thead>
                              <tr>
                                    <?php
                                        echo "<h2>Data From Table $table</h2>";
                                        $columns = columnName("id3",$table);
                                        $count = 0;
                                        while($count < count($columns))
                                        {
                                            echo "<th>".$columns[$count]."</th>";
                                            $count++;
                                        }
                                    ?>
                              </tr>
                            </thead>
                            <tbody>
                                    <?php
                                        $count2 = 0;
                                        $tableData = "select * from $table";
                                        $tableShow = mysqli_query($con,$tableData);
                                        while($tableResult = @mysqli_fetch_assoc($tableShow)){
                                        echo "<tr>";
                                            foreach($tableResult as $key => $value){
                                                echo "<td>".$value."</td>";
                                            }
                                        echo "</tr>";
                                        }
                                ?>
                            </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form action="result.php" method="post">
                        <div class="col-md-5">
                            <div class="form-group">
                                <input type="hidden" value="<?php echo $table ?>" name="tableName" />
                                <label for="columns" class="col-md-5 control-label">Selected Class Attribute</label>
                                <div class="col-md-5">
                                    <select name="ClassAttribute" class="form-control select-column">
                                        <?php
                                            $columns = columnName("id3",$table);
                                            $count = 0;
                                            while($count < count($columns))
                                            {
                                         ?>
                                                <option <?php if($count == count($columns) - 1) echo "selected"; ?> value='<?php echo $columns[$count]; ?>'><?php echo $columns[$count]; ?></option>
                                        <?php
                                            $count++;
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7" style="border: dashed">
                            <h2>Select Attributes:</h2>
                            <div class="form-group">
                                <?php
                                    $columns = columnName("id3",$table);
                                    $count = 0;
                                    while($count < count($columns))
                                    {
                                        echo "<input type='checkbox' checked class='' class='form-control' name='columns[]' value='$columns[$count]' />&nbsp;";
                                        echo "<label class='control-label'>$columns[$count]</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                        $count++;
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="submit" name="run" value="Run" class="btn btn-primary btn-sm" />
                                <input type="submit" name="runWithDetails" value="Run With Details" class="btn btn-primary btn-sm" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/fastclick.js"></script>
    <script src="js/nprogress.js"></script>
    <script src="js/bootstrap-wysiwyg.min.js"></script>
    <script src="js/jquery.hotkeys.js"></script>
    <script src="js/prettify.js"></script>
    <script src="js/custom.min.js"></script>
  </body>
</html>