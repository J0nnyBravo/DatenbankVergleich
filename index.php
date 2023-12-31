<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<?php

    $servername = "localhost";
    $username = "Wednesday";
    $password = "mirza";
    $dbname = "DatenbankVergleich";


    //MYSQLI

    $connMySqli = new mysqli($servername, $username, $password, $dbname);

    $timeAverage = 0;

    for ($i = 0; $i < 500; $i++) {
        $time_start = microtime(true);

        $sql = "SELECT * FROM TestTable";

        $result = mysqli_query($connMySqli, $sql);

        while ($row = mysqli_fetch_assoc($result)){
            //echo $row["rndInt"]."<br>";
        }
        $time_end = microtime(true);
        $time = $time_end - $time_start;
        //echo "MYSQLI: $time seconds<br>";
        $timeAverage = $timeAverage +$time;
        //echo $timeAverage;
    }
    $timeAverage = $timeAverage / 500;
    echo "Druchschnitt-SQLI: $timeAverage <br>";



    $connMySqli->close();

    $time_start = 0;
    $time_end = 0;
    $timeAverage = 0;


    //PDO
    $time_start = microtime(true);

    $connPdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    for ($i = 0; $i < 500; $i++) {

        $stmt = $connPdo->prepare("SELECT * FROM TestTable");
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        while ($row = $stmt->fetch()) {
            //echo $row["rndInt"]."<br>";
        }

        $time_end = microtime(true);
        $time = $time_end - $time_start;

        //echo "PDO: $time seconds <br>";
        $timeAverage = $timeAverage +$time;

    }
    $timeAverage = $timeAverage / 500;
    echo "Druchschnitt-PDO: $timeAverage <br>";

    $connPdo = null;


    // TESTDATA INSERT

//    for ($i = 0; $i < 100000; $i++) {
//        $rnd = random_int(0, 9999);
//        $sql = "INSERT INTO TestTable (rndInt)
//            VALUES ('$rnd')";
//        $conn->query($sql);
//    }

//    if ($conn->query($sql) === TRUE) {
//        echo "New record created successfully";
//    } else {
//        echo "Error: " . $sql . "<br>" . $conn->error;
//    }









?>

</body>
</html>
