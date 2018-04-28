<?php 

    $xml=simplexml_load_file("config.xml");

    $servername = $xml -> server;
    $username = $xml -> user;
    $password = $xml -> password;
    $db = $xml -> database;

    // Create connection
    $conn = new mysqli($servername, $username, $password, $db);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    $suits = array('H', 'D', 'C', 'S');
    $names = array('A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K');
    for($iS = 0; $iS < count($suits); $iS++)
    {
        for($iN = 0; $iN < count($names); $iN++)
        {
            //set value of card based on name
            $value = 0;
            switch($names[$iN])
            {
                case 'A':
                    $value = 1;
                    break;
                case 'J':
                case 'Q':
                case 'K':
                    $value = 10;
                    break;
                default;
                    $value = $iN +1;
                    break;
            }

            //build image string
            $imageLocation = "./images/" . $names[$iN] . $suits[$iS] . ".png";
            //build query string
            $sql = "INSERT INTO Cards (CardValue, Suit, CardName, ImageLocation)
            VALUES ($value, '$suits[$iS]', '$names[$iN]', '$imageLocation')";



            if($conn->query($sql) === TRUE){
                echo $suits[$iS] . $names[$iN] . " added";
            } else{
                echo "Error: " . $sql . "<br />" . $conn->error;
            }
        }
    }
    $conn->close();
?>