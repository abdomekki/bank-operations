<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php
        $id=$_POST["id"];
        $deposit=$_POST["deposit"];
        include "connection.php";
        $newdepo=new deposit();
        $newdepo->idDeposit($id,$deposit);
        

      
        

    ?>
</body>
</html>