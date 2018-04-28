<?php 

    const SERVERNAME = "localhost";
    const USERNAME = "root";
    const PASSWORD = "t3cht0n!c";
    const DB = "myDatabase";

    function getCard($player)
    {
        $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $sql = "SELECT * FROM Cards WHERE InPlay = 0";
        $result = $conn->query($sql);
        $cardData = $result->fetch_assoc();
        
        $max = count($cardData) -1;

        $random = mt_rand(0, $max);
        
        $id = $cardData[$random]["idCards"];

        $updateSql = 'UPDATE Cards SET InPlay = 1 WHERE idCards = ' . $id;
        if($conn->query($updateSql) === FALSE){
            echo "error updating: " . $conn->error;
        }

        $card = new Card($cardData["Suit"], $cardData["CardValue"], $cardData["ImageLocation"]);
        $addToHand = "INSERT INTO Hands (CardId, HandOwner) VALUES ('$id', '$player')";
        if($conn->query($addToHand) === FALSE){
            echo "error adding to hand: " . $conn->error;
        }    
        if(!$conn->commit())
        {
            echo "commit failed";
        }

        $conn->close();
        return $card;       
    }

    getCard("player");
?>
