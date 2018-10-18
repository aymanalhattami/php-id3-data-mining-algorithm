<?php
    require("include\conn.php");

    $classAttribute = 'Play';
    if(isset($_POST['classAttribute']))
    {
        $classAttribute = $_POST['classAttribute'];
    }

    /*******************************************************************************************************************/
    /*
     * Return: the tables in specific database
     */
    function getTables($database)
    {
        global $con;
        $query = "SHOW TABLES in $database";
        $result = mysqli_query($con, $query);
        if($result)
        {
            $i = 0;
            while($row = mysqli_fetch_array($result))
            {
                $tables[$i] = $row["Tables_in_$database"];
                $i++;
            }
            return $tables;
        }
    }


    //return the name of the columns
    function columnName($Database,$Table)
    {
        $columnsName = array();
        global $con;
        $sql2 = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='$Database' AND `TABLE_NAME`='$Table'";
        $result2 = mysqli_query($con,$sql2);
       if($result2)
       {
            $ii = 0;
            while($row = mysqli_fetch_assoc($result2))
            {
                $columnsName[$ii] = $row['COLUMN_NAME'];
                $ii++;
            }
            
           return $columnsName;
        }
        else
        {
            return 0;
        }
    }


    /*
     * return: the distinct value of specific column
     */
    function DistValue($Column,$Table)
    {
        $DistValues = array();
        global $con;
        $sql = "SELECT DISTINCT($Column) FROM $Table";
        $result = mysqli_query($con,$sql);

        if($result)
        {
            $i = 0;
            while($row = mysqli_fetch_assoc($result))
            {
                $DistValues[$i] = $row[$Column];
                $i++;
            }
            return $DistValues;
        }
        else
        {
            return 0;
        }
    }

    /*
     * return: the number of rows in specific table
     */
    function RowsNumber($Column,$Table)
    {
        global $con;
        $numberCol = "select $Column from $Table";
        $nColResult = mysqli_query($con,$numberCol);
        $ColumnNumber = @mysqli_num_rows($nColResult);
        return $ColumnNumber;
    }

    /*
     * return: the number of duplication of specific value in specific column
     */
    function valueNum($table, $column, $value)
    {
        global $con;
        $query = "SELECT COUNT($column) FROM $table WHERE $column ='" . $value . "'";
        $result = mysqli_query($con,$query);
        return mysqli_fetch_array($result);
    }

    function howMany($table = 'weathers', $column1 = 'Play', $value1 = 'no', $column2  = 'Outlook', $value2 = 'sunny')
    {
        global $con;
        $query = "SELECT COUNT($column1) FROM $table WHERE $column1 = '" . $value1 . "'AND $column2 = '" . $value2 . "'";
        $result = mysqli_query($con, $query);
        return mysqli_fetch_array($result);
    }

    /*
     * Calculate the entropy value of the table
     */
    function Entropy($Column,$Table)
    {
        global $con;                                 // for the connection with database
        $numberOfCol = RowsNumber($Column,$Table);    // Bring the number of column to divided by it
        $DistVal = DistValue($Column,$Table);           // Bring Each value without Duplication .
        $valsNumber = count($DistVal);                  // Bring the number of distnect valu for help to calculat the Entropy
        $count = 0;                                     // Counter for help to calculat the Entropy
        $numOfDuplicat = array();                       // Array for storing the Duplication for Each Value 
        
        
        while($count < count($DistVal))
        {
            $valDuplicat = "select $Column from $Table where $Column = '".$DistVal[$count]."'";    
            $valQuery = mysqli_query($con,$valDuplicat);
            $valRe = mysqli_num_rows($valQuery);
            $numOfDuplicat[$count] = $valRe;
            $count++;
        }

        $Entropy = 0;
        $count2 = 0;
        while($count2 < count($DistVal))
        {
             $Entropy = $Entropy + ($numOfDuplicat[$count2]/$numberOfCol)*log($numOfDuplicat[$count2]/$numberOfCol,2);
            ++$count2;
        }
        return abs($Entropy);
    }

    /*
     * Calculate the information value
     */
    function information($table, $column)
    {
        global $classAttribute;

        //$entropy = Entropy($classAttribute, $table); // entropy
        $rowsNumber = RowsNumber($column, $table); // number of all row in the table
        $distinctValue = DistValue($column,$table); // store the distinct values of the column in the $distinctValue array;
        $numOfDistinctValue = count($distinctValue); // store the number of distinct values in $numOfDistinctValue  array;
        $distinctValueNumber = null; // array to store the how many each value is duplicated in the column;
        $classAttributeValues = DistValue($classAttribute, $table); // store the distinct values of class attribute
        $numClassAttributeValues = count($classAttributeValues);
        $howManyInClassAttr = null;
        $entropyResult = null;

        //loop to get the how many each distinct value is duplicated in the column
        for($i = 0; $i < $numOfDistinctValue; $i++)
        {
            $distinctValueNumber[$i] = valueNum($table, $column, $distinctValue[$i]);
        }

        //loop to get the relationship  between classAttribute and column(outlook)
        for($j = 0; $j < $numOfDistinctValue; $j++)
        {
            for($k = 0; $k < $numClassAttributeValues; $k++)
            {
                $howManyInClassAttr[$j][$k] = howMany($table, $classAttribute, $classAttributeValues[$k], $column, $distinctValue[$j]);
            }
        }

        //this loop do calculate the information
        for($counter1 = 0; $counter1 < $numOfDistinctValue; $counter1++)
        {
            $division = $distinctValueNumber[$counter1][0]/$rowsNumber;

            //loop to calculate the entropy of each distinct value of the variable $column
            for($counter2 = 0; $counter2 < $numClassAttributeValues; $counter2++)
            {
                $probability = $howManyInClassAttr[$counter1][$counter2][0]/$distinctValueNumber[$counter1][0];
                $log = log($probability, 2);
                $entropyResult[$counter1][$counter2] = $probability * $log;
                if(is_nan($entropyResult[$counter1][$counter2])) $entropyResult[$counter1][$counter2] = 0;
            }

            //summation of each distinct value entropy
            $entropySummation;
            for($counter3 = 0; $counter3 < $numClassAttributeValues; $counter3++)
            {
                @$entropySummation[$counter1] += $entropyResult[$counter1][$counter3];
            }

            $avjMultiEntropy[$counter1] = $entropySummation[$counter1] * $division;
        }

        $information;
        for($counter4 = 0; $counter4 < count($avjMultiEntropy); $counter4++)
        {
            @$information += $avjMultiEntropy[$counter4];
        }

        return abs($information);
    }

    /*
     * calculate the gain value
     */
    function gain($table, $column)
    {
        global $classAttribute;
        return Entropy($classAttribute, $table) - information($table, $column);
    }


    function L2Dataset($table, $column, $value)
    {
        global $con;
        $q = "SELECT * FROM $table WHERE $column = '" .  $value . "'";
        $result = mysqli_query($con, $q);

        if($result)
        {
            $c = 0;
            while ($row = mysqli_fetch_array($result))
            {
                $dataset[$c] = $row;
                $c++;
            }
            return $dataset;
        }
    }


?>