<?php include 'database.php'; ?>

<?php
    if(isset($_POST['run']))
    {
        $classAttribute = $_POST['class_attribute'];
        $classes = classAttributeValues($classAttribute);

        $no = $classes[0][0];
        $yes = $classes[1][0];

        $noNum = valueNum($classAttribute, $no);
        $yesNum = valueNum($classAttribute, $yes);
        $rowsNum = rowsNum();

        $data = array($rowsNum[0], $noNum[0],$yesNum[0]);
        echo entropy($data);


        if(isset($_POST['attributes']))
        {
            echo '<pre>';
            print_r($_POST['attributes']);
            echo '</pre>';
        }
    }


    if(isset($_POST['runWithDetails']))
    {
        $classAttribute = $_POST['class_attribute'];
        echo $classAttribute;


        if(isset($_POST['attributes']))
        {
            echo '<pre>';
            print_r($_POST['attributes']);
            echo '</pre>';
        }
    }