<?php
function information($table = 'weathers', $column = 'outlook')
{
    global $classAttribute;

    //$entropy = Entropy($classAttribute, $table); // entropy
    //echo '<br />' . $entropy . '<br />';
    $rowsNumber = RowsNumber($column, $table); // number of all row in the table
    echo '<br />Rows Number: ' . $rowsNumber . '<br />';
    $distinctValue = DistValue($column,$table); // store the distinct values of the column in the $distinctValue array;
    echo '<pre>Distinct Values of ' . $column . '<br />';
    print_r($distinctValue);
    echo '</pre>';
    $numOfDistinctValue = count($distinctValue); // store the number of distinct values in $numOfDistinctValue  array;
    echo "<br /> Number of distinct values of column $column is " . $numOfDistinctValue . '<br />';
    $distinctValueNumber = null; // array to store the how many each value is duplicated in the column;
    echo '<br />' . $distinctValueNumber . '<br />';
    $classAttributeValues = DistValue($classAttribute, $table); // store the distinct values of class attribute
    echo '<pre>Class Attr Values are <br />';
    print_r($classAttributeValues);
    echo '</pre>';
    $numClassAttributeValues = count($classAttributeValues);
    echo '<br />Number of class attr values are ' . $numClassAttributeValues . '<br />';
    $howManyInClassAttr = null;
    $entropyResult = null;

    //loop to get the how many each distinct value is duplicated in the column
    for($i = 0; $i < $numOfDistinctValue; $i++)
    {
        $distinctValueNumber[$i] = valueNum($table, $column, $distinctValue[$i]);
    }

    echo "<pre>Number of duplication of each distinct value in $column column <br />";
    print_r($distinctValueNumber);
    echo '</pre>';

    //loop to get the relationship  between classAttribute and column(outlook)
    for($j = 0; $j < $numOfDistinctValue; $j++)
    {
        for($k = 0; $k < $numClassAttributeValues; $k++)
        {
            $howManyInClassAttr[$j][$k] = howMany($table, $classAttribute, $classAttributeValues[$k], $column, $distinctValue[$j]);
        }
    }

    echo "<pre>Number of duplication of each distinct value in $column column <br />";
    print_r($howManyInClassAttr);
    echo '</pre>';

    //this loop do calculate the information
    for($counter1 = 0; $counter1 < $numOfDistinctValue; $counter1++)
    {
        echo "<h1>Inside loop 3 </h1>";
        echo "Number of distinct value of the column $column " . $numOfDistinctValue . '<br />';
        echo "Counter1 value is " . $counter1 . '<br />';
        $division = $distinctValueNumber[$counter1][0]/$rowsNumber;
        echo "division value is " . $division . '<br />';
        echo "ditinct value numbers is " . $distinctValueNumber[$counter1][0] . '<br />';
        echo "rows number is " . $rowsNumber . '<br />';
        //loop to calculate the entropy of each distinct value of the variable $column
        for($counter2 = 0; $counter2 < $numClassAttributeValues; $counter2++)
        {
            echo "<h1>Inside loop 3 - 1 </h1>";
            $probability = $howManyInClassAttr[$counter1][$counter2][0]/$distinctValueNumber[$counter1][0];
            echo "probabilty value is " . $probability . '<br />';
            echo "how many duplication in class attribute is " . $howManyInClassAttr[$counter1][$counter2][0] . '<br />';
            echo "how many duplication in $column of each distinct value is " . $distinctValueNumber[$counter1][0] . '<br />';
            $log = log($probability, 2);
            echo "log value is " . $log . '<br />';
            $entropyResult[$counter1][$counter2] = $probability * $log;
            if(is_nan($entropyResult[$counter1][$counter2])) $entropyResult[$counter1][$counter2] = 0;
        }

        echo "<pre>The Final result of entropy for each distinct value<br />";
        print_r($entropyResult);
        echo '</pre>';

        //summation of each distinct value entropy
        $entropySummation[0] = 0;
        for($counter3 = 0; $counter3 < $numClassAttributeValues; $counter3++)
        {
            echo "<h1>Indsid loop 3 - 2</h1>";
            $entropySummation[$counter3] += $entropyResult[$counter1][$counter3];
            echo "<pre>The summation of enropy is: <br />";
            print_r($entropySummation[$counter3]);
            echo '</pre>';
        }
    }

    /*$valuesResult[$counter1] = $division * $entropyResult;

    $infoResult = 0;
    for($counter3 = 0; $counter3 < count($valuesResult); $counter3++)
    {
        $infoResult += $valuesResult[$counter3];
    }
    echo '<br />' . abs($infoResult) . '<br />';*/
}