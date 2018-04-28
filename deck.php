<?php 

    const SERVERNAME = "localhost";
    const USERNAME = "root";
    const PASSWORD = "root";
    const DB = "myDatabase";

    class Card {
        public $suit;
        public $value;
        public $imageSrc;

        function __construct($suit, $value, $imageSrc){
            $this->suit = $suit;
            $this->value = $value;
            $this->imageSrc = $imageSrc;
        }

        function asArray()
        {
            $cardArray = array('card_value' => $this->value, 'suit' => $this->suit, 'image_src' => $this->imageSrc);
            return $cardArray;
        }
    }

    function getCard($player)
    {
        $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $foundCard = false;

        do{
            $getMin = "SELECT MIN(idCards) FROM Cards";
            $getMax = "SELECT MAX(idCards) FROM Cards";

            $minQuery = $conn->query($getMin);
            $maxQuery = $conn->query($getMax);

            $min = $minQuery->fetch_assoc();
            $max = $maxQuery->fetch_assoc();

            $randomID = mt_rand($min["MIN(idCards)"], $max['MAX(idCards)']);

            $sql = "SELECT idCards, CardValue, Suit, ImageLocation, CardName, InPlay FROM Cards WHERE idCards = " . $randomID;
        
            $result = $conn->query($sql);
            $cardData = $result->fetch_assoc();

            //if card is not InPlay, it is usable. We have found a card, we need to update status of this card.
            if(!$cardData["InPlay"])
            {
                $foundCard = true;
                $id = $cardData["idCards"];
                $updateSql = 'UPDATE Cards SET InPlay = 1 WHERE idCards = ' . $id;
                if($conn->query($updateSql) === FALSE){
                    echo "error updating: " . $conn->error;
                }
            }
                
            //add new card to play if we found one
            if($foundCard)
            {
                $card = new Card($cardData["Suit"], $cardData["CardValue"], $cardData["ImageLocation"]);
                $addToHand = "INSERT INTO Hands (CardId, HandOwner) VALUES ('$id', '$player')";
                if($conn->query($addToHand) === FALSE){
                    echo "error adding to hand: " . $conn->error;
                }    
                if(!$conn->commit())
                {
                    echo "commit failed";
                }
            } 

        } while($foundCard = false);

        $conn->close();
        return $card;       
    }

    function initDeck()
    {
        $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $getAll = "SELECT idCards FROM Cards WHERE InPlay = 1";
        $result = mysqli_query($conn, $getAll);
        $allCards = $result->fetch_assoc();

        if($allCards !== NULL && count($allCards) > 0)
        {
            foreach($allCards as $c => $c_value){
                $sqlUpdate = 'UPDATE Cards SET InPlay = 0 WHERE ' . $c_value;
                if($conn->query($sqlUpdate) === FALSE){
                    echo "error updating: " . $conn->error;
                }
            }
        }

        $trunc = "TRUNCATE TABLE Hands";
        if($conn->query($trunc) === FALSE){
            echo "did not delete old Hands " . $conn->error;
        }

        $conn->close();
    }

    function getHand($player)
    {
        $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $getCards = "SELECT CardId FROM Hands WHERE HandOwner = '$player'";
        $cardData = $conn->query($getCards);
        $values = array();

        foreach($cardData as $c => $c_value)
        {
            $sql = "SELECT CardValue, ImageLocation FROM Cards WHERE idCards = " . $c_value["CardId"];
            $result = mysqli_query($conn, $sql);
            $cardValues = $result->fetch_assoc();
            array_push($values, $cardValues);
        }
        $conn->close();

        return $values;
    }


    

?>
