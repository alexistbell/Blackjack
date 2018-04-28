<?php

include 'injections.php';

function getHandValues($values)
    {
        $sums = array(0,0);
        for($i =0; $i < count($values); $i++)
        {
            $isAce = FALSE;
            //=== does not pass correctly
            if($values[$i]["CardValue"] == 1)
            {
                $isAce = TRUE;
            }
            if($isAce)
            {
                $sums[0] += 1;
                $sums[1] += 11;
            } else {
                $sums[0] += $values[$i]["CardValue"];
                $sums[1] += $values[$i]["CardValue"];
            }
        }
        return $sums;
    }

    function checkForWinner()
    {
        $dealerHand = getHand("dealer");
        $playerHand = getHand("player");

        $dealerHandValues = getHandValues($dealerHand);
        $playerHandValues = getHandValues($playerHand);
        //this specific case would only happen on turn one. It's unlikely but it would be a push
        //checkinng index of [1] because an Aces value of 11 is always added to second index
        //check for bust on [0] because that accoutns for Ace = 1
        if($dealerHandValues[1] === 21 && $playerHandValues [1] === 21){
            return "Push";
        } else if($dealerHandValues[1] === 21 || $playerHandValues[0] > 21)
        {
            //need code to show dealer's other card.
            return "Dealer wins!";
        } else if ($playerHandValues[1] === 21 || $dealerHandValues[0] > 21){
            return "Player wins!";
        } else{
            return "No winner yet";
        }
    }

    function dealersTurn()
    {
        $dealerHand = getHand("dealer");
        $dealerHandValues = getHandValues($dealerHand);
        if($dealerHandValues[0] < 17 || $dealerHandValues[1] !== 21)
        {
            $card = getCard("dealer");
            $script = newDealerCard($card->imageSrc);
            return $script;
        } else {
            return "";
        }
    }
?>