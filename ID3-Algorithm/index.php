<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/font-awesome.min.css" />
        <link rel="stylesheet" href="css/style.css" />
    </head>
</html>
<body>
    <?php include 'database.php'; ?>

    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <h1 class="h1 text-center">ID3 Algorithm</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <form method="POST" action="" class="form-horizontal">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Select Table:</label>
                                <div class="col-md-8">
                                    <select name="table" class="form-control">
                                        <?php
                                        foreach(getTables() as $table)
                                        {
                                            $counter = 0;
                                            ?>
                                            <option name="<?php echo $table[$counter]; ?>"><?php echo $table[$counter]; ?></option>
                                            <?php
                                            ++$counter;
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="submit" name="apply" value="Apply" class="btn btn-primary btn-sm" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed table-hover">
                        <tr>
                            <th>Day</th>
                            <th>Outlook</th>
                            <th>Temperature</th>
                            <th>Humidity</th>
                            <th>Wind</th>
                            <th>Play</th>
                        </tr>
                        <?php
                        foreach(getAll() as $w)
                        {
                            ?>
                            <tr>
                                <td><?= $w->Day ?></td>
                                <td><?= $w->Outlook ?></td>
                                <td><?= $w->Temperature ?></td>
                                <td><?= $w->Humidity ?></td>
                                <td><?= $w->Wind ?></td>
                                <td><?= $w->Play ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <form method="POST" action="result.php" class="form-inline">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group pull-left">
                                <label class="col-md-7 control-label">Selected Class Attribute:</label>
                                <div class="col-md-5">
                                    <select name="class_attribute" class="form-control">
                                        <?php
                                            $columns_names = array();
                                            $counter = 0;
                                            $length = count(getColumnsNames());

                                            foreach(getColumnsNames() as $col_name)
                                            {
                                                ++$counter;
                                                $columns_names[] = $col_name -> Field;

                                                if($length == $counter)
                                                {
                                                    echo '<option selected value="' . $col_name -> Field . '">' . $col_name -> Field . '</option>';
                                                }
                                                else
                                                {
                                                    echo '<option value="' . $col_name -> Field . '">' . $col_name -> Field . '</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div>
                                            <h3>Selected Attributes:</h3>
                                            <?php
                                            foreach($columns_names as $col_name)
                                            {
                                            ?>
                                                <input type="checkbox" checked name="attributes[]" value="<?= $col_name; ?>" class="form-control" />
                                                <label class="control-label"><?= $col_name; ?></label>
                                                <br />
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="submit" name="run" value="Run" class="btn btn-primary btn-sm" />
                            </div>
                            <div class="form-group">
                                <input type="submit" name="runWithDetails" value="Run With Details" class="btn btn-primary btn-sm" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</body>

