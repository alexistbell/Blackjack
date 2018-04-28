var CardGame;

(function() {
	var instance;
	CardGame = function(){
		if(instance){
			return instance;
		}

		instance = this;
    }
})();

CardGame.prototype.getCard = function() {
    $.ajax({
        url:'ajax.php?do=getJsonCard',
        complete: function(response) {
            console.log(response.responseJSON);
            var imageSrc = response.responseJSON.image_src;
            $('#playersHand').append("<img src = '" + imageSrc + "' data = '" + imageSrc + "'>");
            game.playerHit();
        },
        error: function() {
            console.log("Did not get valid response");
        }
    });
}

CardGame.prototype.playerHit = function(){
    $.ajax({
        url:'ajax.php?do=hit',
        complete: function(response) {
            console.log(response);
        },
        error: function(){
            console.log("Did not get valid on hit");
        }
    });
}

CardGame.prototype._bindButtons = function(){
    this.$hitButton.on('click', this.getCard);
}

CardGame.prototype._makeSelectors = function(){
    this.$hitButton = $('#hit');
    this.$dealerCardUp = $('#dealerCardUp');
    this.$dealerCardDown = $('#dealerCardDown');
    this.$playerCard1 = $('#playerCard1');
    this.$playerCard2 = $('#playerCard2');
    //this.$playersHand = $('#playersHand');
}

CardGame.prototype._init = function(){
    this._makeSelectors();
    this._bindButtons();
}

$(function(){
    window.game = new CardGame();
    window.game._init();  
})

