var Card = function(image_src, card_value, suit){
    //debugger;
    this.image_src = image_src;
    if(card_value === undefined || suit === undefined)
    {
        this.cardFromImageString(image_src);
    } else {
        this.card_value = card_value;
        this.suit = suit;
    }

}

Card.prototype.cardFromImageString = function(imageSrc){
    //this should give us somethign like KC or King of Clubs
    var workingString = imageSrc.slice(9, -4);
    this.suit = workingString.slice(-1);
    var cardName = workingString.slice(0,-1);
    switch(cardName){        
        case 'A':
            this.card_value = 1;
            break;
        case 'J':
        case 'Q':
        case 'K':
            this.card_value = 10;
            break;
        default:
            this.card_value = parseInt(cardName);
            break;       
    }
}