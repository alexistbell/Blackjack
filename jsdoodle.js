
//flip dealer card
var imageLoc = document.getElementById('dealerCardDown').getAttribute('data'); 
document.getElementById('dealerCardDown').src=imageLoc;

//disable buttons
document.getElementById('hit').disabled = true;
document.getElementById('stand').disabled = true;

