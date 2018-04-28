<!DOCTYPE html>
<html>
<head>
	<title>PHP Blackjack</title>
</head>
<body>
    <?php 
        include 'deck.php';
        include 'scoring.php';

        initDeck();
    ?>
        <div id = "dealersHand">
        <h2>Dealer's Hand</h2>
            <?php 
                $dealerCardUp = getCard("dealer");
                echo "<img src =$dealerCardUp->imageSrc data = $dealerCardUp->imageSrc id='dealerCardUp'>";
                $dealerCardDown = getCard("dealer");
                $cardBack = "./images/cardBack.png";
                echo "<img src = $cardBack data = $dealerCardDown->imageSrc id='dealerCardDown'>";
            ?>           
            
    </div>
    <div id = "playersHand">
        <h2>Player's Hand</h2>
            <?php 
                global $playerCards;

                $playerCard1 = getCard("player");
                echo "<img src =$playerCard1->imageSrc data = $playerCard1->imageSrc id='playerCard1'>";
                $playerCard2 = getCard("player");
                echo "<img src =$playerCard2->imageSrc data = $playerCard2->imageSrc id='playerCard2'>";
            ?>           
    </div>

    <div id = "winner">
        <?php 
            function checkGameState($lastMove)
            {
                $gameState = checkForWinner();
                switch ($gameState){
                    case "Dealer wins!":
                        echo gameOver();
                        break;
                    case "Player wins!":
                        echo gameOver();
                        break;
                    default:
                        break;
                }

                if($lastMove === "hit" && $gameState === "No winner yet"){
                    echo "<p>Player hit</p>";
                    echo dealersTurn();
                }
                return $gameState;
            }

            echo checkGameState("startGame");
        ?>
    </div>
    <button type = "button" id="hit">Hit</button><button type = "button" id="stand">Stand</button>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script type = "text/javascript" src = "script.js"></script>
    <script type = "text/javascript" src = "card.js"></script>

</body>
</html>

<!-- <?php 
    if(in_array('do', $_GET))
    {
        if($_GET['do'] === "hit"){
            $post_data = checkGameState("hit");
            echo $post_data;
        }
    }
?> -->