<?php

    const OPENTAG = "<script language='javascript'>";
    const CLOSETAG = "</script>";

    function gameOver()
    {
        $script = OPENTAG . flipDealerCard() . disableButtons() . CLOSETAG;
        return $script;
    }

    function flipDealerCard()
    {
        $script = "var imageLoc = document.getElementById('dealerCardDown').getAttribute('data'); document.getElementById('dealerCardDown').src=imageLoc;";
        return $script;
    }

    function disableButtons()
    {
        $script = "document.getElementById('hit').disabled = true; document.getElementById('stand').disabled = true;";
        return $script;
    }

    function newDealerCard($imageSrc)
    {
        $script = OPENTAG . "$('#dealersHand).append('<img src = '" . $imageSrc . "' data = '" . $imageSrc . "'>)" . CLOSETAG;
        return $script;
    }
?>