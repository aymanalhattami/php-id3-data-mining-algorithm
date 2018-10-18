<?php
    /*
     * This section to handle the class attribute and the selected attributes
     *
     */

    include 'database.php';

    if (isset($_POST['run'])) {
        if (empty($_POST['columns'])) {
            echo "You Should Choose some of columns";
            return;
        }

        $table = $_POST['tableName'];
        $classAttribute = $_POST['ClassAttribute'];
        $tableColumns = $_POST['columns'];
        $deleteLastEle = array_pop($tableColumns); // delete the last element(last column) of the array
        $deleteFirstEle = array_shift($tableColumns); // delete the first element(first column) of the array
        $tableColumnsNum = count($tableColumns);

        $rootEle = getRootEle($table, $tableColumns, $classAttribute);
        $rootDistinctValues = DistValue($rootEle, $table);
        $rootDistinctValuesNum = count($rootDistinctValues);

        /************************************************************************************************************************/

        for($counter = 0; $counter < $rootDistinctValuesNum; $counter++)
        {
            $newDataset[$counter] = L2Dataset($table, $rootEle, $rootDistinctValues[$counter]);
        }

        echo "<pre>";
        print_r($newDataset);
        echo "</pre>";
        /************************************************************************************************************************/
    }

    function getRootEle($table, $tableColumns, $classAttribute)
    {
        $entropy = Entropy($classAttribute, $table);

        //counter starts from 1, because we donot need first item which is the Day column
        //counter stops before the last item, becuase we also donot need last item which is the class attribute
        for ($counter = 0; $counter < count($tableColumns); $counter++) {
            $information[$tableColumns[$counter]] = information($table, $tableColumns[$counter]);
            $gain[$tableColumns[$counter]] = gain($table, $tableColumns[$counter]);
        }

        $maxGainValue = max($gain);

        $rootEle = array_keys($gain, $maxGainValue);
        $rootEle = $rootEle[0];
        $indexOfRootEle = array_search($rootEle, $tableColumns);
        unset($tableColumns[$indexOfRootEle]);
        $tableColumns = array_values($tableColumns);//to reindex the array, because the unset() function donot reindex the array after deletion process

        return $rootEle;
    }



?>