// when card is clicked, execute function to store an array of the 4 cards. When the array consists
// of 4 cards, automatically execute the submit button function which 

// keep track of each clicked card and their attributes
let clickedCards = [];
let completedCount = 0;
let numWins = 0;
let lastCardId = 0;

// turn data-cards into an array for each card

function cardClicked(event) {
    //switch card background color
    if (clickedCards.length >= 4) {
        submitConnection();
        return;
    }

    event.currentTarget.classList.toggle("active");
    const clickedCardText = event.currentTarget.textContent;
    const cardGroupId = event.target.dataset.groupId;
    const cardInfo = {
        text: clickedCardText,
        groupId: cardGroupId
    }
    lastCardId = cardGroupId;
    clickedCards.push(cardInfo);

    /*
    console.log("clickedCardsData", clickedCardsData);
    console.log("clickedCardText", clickedCardText);
    clickedCards.push(clickedCardText);
    console.log(clickedCards);
    */
}

// check if each element in the connection matches the correct answer. if yes, add
function submitConnection() {
    const cards = document.querySelectorAll('box');
    console.log("last card id", lastCardId);
    console.log("clickedCards", clickedCards);
    
    for (let i = 0; i < clickedCards.length; i++) {
        const card = clickedCards[i];
        
        if (card.groupId !== lastCardId) {
            console.log("failed");
            return;
        }
    }

    // increase number of wins
    numWins += 1;
    console.log("numWins", numWins);
    // remove all cards and restart for the next group
    clickedCards = [];
    completedCount++;
}

function initialize() {
    console.log('initializing madeVersion.js')
    const cards = document.querySelectorAll('.box');
    cards.forEach(card => {
        card.addEventListener("click", cardClicked);
         
    });

    // const cardClicked = document.getElementById('card');
    /*
    if (cardClicked) {
        cardClicked.addEventListener("click", switchCardBackground);
    }
    */
}

document.addEventListener('DOMContentLoaded', initialize);