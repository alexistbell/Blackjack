<?php 
    header('Content-type: application/json');
    include 'deck.php';

    function getJsonCard()
    {
        $card = getCard("player");
        $cardArray = $card->asArray();
        $post_data = json_encode($cardArray);
        return $post_data;
    }

    if($_GET['do'] === "getJsonCard"){
        $post_data = getJsonCard();
        echo $post_data;
    } else if ($_GET['do'] === "hit"){
        $post_data = checkGameState("hit");
        echo $post_data;
    }
?>
