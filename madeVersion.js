// when card is clicked, execute function to store an array of the 4 cards. When the array consists
// of 4 cards, automatically execute the submit button function which 

// keep track of each clicked card and their attributes
let clickedCards = [];
let completedCount = 0;
let numWins = 0;
let lastCardId = 0;
let lastCardGroupName = '';
let mistakesRemaining = 4;

// turn data-cards into an array for each card

function cardClicked(event) {
    // if clicked card is already in the array, remove the active class and remove it from clickedCards
    const clickedCardText = event.currentTarget.textContent;
    const cardIndex = clickedCards.findIndex(card => card.text === clickedCardText);
    if (cardIndex !== -1) {
        // if card is found, remove it (deselect)
        console.log("deselected");
        clickedCards.splice(cardIndex, 1);
        event.currentTarget.classList.remove("active");
        const submitBtn = document.getElementById('submit-btn');
        submitBtn.classList.remove('active');
        return;
    } else {
        // if card is not found, add it (select)
        console.log("add card");
        if (clickedCards.length >= 4) {
            return;
        }
        event.currentTarget.classList.add("active");
    }

    const cardGroupId = event.target.dataset.groupId;
    const cardGroupName = event.target.dataset.groupName;
    const cardInfo = {
        text: clickedCardText,
        groupId: cardGroupId,
        groupName: cardGroupName
    }
    lastCardId = cardGroupId;
    lastCardGroupName = cardGroupName;
    clickedCards.push(cardInfo);
    console.log("clicked cards length", clickedCards.length);
    if (clickedCards.length >= 4) {
        console.log("NO MORE SPACE");
        const submitBtn = document.getElementById('submit-btn');
        submitBtn.classList.toggle("active");
        return;
    }
}

// check if each element in the connection matches the correct answer. if yes, add
function submitConnection() {
    if (clickedCards.length != 4) {
        return;
    }
    const submitBtn = document.getElementById('submit-btn');
    submitBtn.classList.toggle("active");
    console.log("last card id", lastCardId);
    console.log("clickedCards", clickedCards);
    deselect();

    for (let i = 0; i < clickedCards.length; i++) {
        const card = clickedCards[i];
        
        if (card.groupId !== lastCardId) {
            console.log("failed");
            mistake();
            clickedCards = [];
            return;
        }
    }
    successfulConnection();
    // increase number of wins
    numWins += 1;
    console.log("numWins", numWins);
    // remove all cards and restart for the next group
    clickedCards = [];
    completedCount++;

    // game over
    if (numWins == 4) {
        gameOver();
    }
}

function gameOver() {
    document.getElementById('success1').style.display = "block";
    document.getElementById('success2').style.display = "block";
    document.getElementById('success3').style.display = "block";
    document.getElementById('success4').style.display = "block";

    //set delay times in case they changed
    document.getElementById('success1').style.animationDelay = "0.5s";
    document.getElementById('success2').style.animationDelay = "1s";
    document.getElementById('success3').style.animationDelay = "1.5s";
    document.getElementById('success4').style.animationDelay = "2s";

    document.getElementById('mistakes').style.display = "none";
    document.getElementById('results-button-container').style.display = "block";
    document.querySelectorAll('.box').forEach(box => {
        box.style.display = 'none';
    });
    if (numWins == 4) {
        document.getElementById('title').textContent = "Great Job!";
    }
    if (mistakesRemaining == 0) {
        document.getElementById('title').textContent = "Try again next Time!";
    }

    document.getElementById('completed').textContent = numWins;
    if (numWins == 0) {
        document.getElementById('completed').textContent = 0;
    }
    document.getElementById('winPercent').textContent = (numWins/4)*100;

    //start

    // script.js
    fetch('gameover.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            numwin: numWins
            
        })
    })
    .then(response => response.text())
    .then(data => console.log(data))
    .catch(error => console.error('Error:', error));


    //finish
}

function viewResults() {
    document.getElementById('success1').style.display = "none";
    document.getElementById('success2').style.display = "none";
    document.getElementById('success3').style.display = "none";
    document.getElementById('success4').style.display = "none";
    document.getElementById('cardContainer').style.display = "none";
    document.getElementById('mistakes').style.display = "none";
    document.getElementById("results-button-container").style.display = "none";
    document.getElementById('resultsContainer').style.display = "block";

}


function deselect() {
    clickedCards.forEach(card => {
        // Find the corresponding card element using its text content
        const cardElements = document.querySelectorAll('.box');
        cardElements.forEach(cardElement => {
            if (cardElement.textContent.trim() === card.text.trim()) {
                cardElement.classList.remove('active');
            }
        });
    });
}


function deselectBtn() {
    const submitBtn = document.getElementById('submit-btn');
    submitBtn.classList.remove('active');
    clickedCards.forEach(card => {
        // Find the corresponding card element using its text content
        const cardElements = document.querySelectorAll('.box');
        cardElements.forEach(cardElement => {
            if (cardElement.textContent.trim() === card.text.trim()) {
                cardElement.classList.remove('active');
            }
        });
    });
    clickedCards = [];
}

// toggle active class on each card off
function deselectBtn() {
    const submitBtn = document.getElementById('submit-btn');
    submitBtn.classList.remove('active');
    clickedCards.forEach(card => {
        // Find the corresponding card element using its text content
        const cardElements = document.querySelectorAll('.box');
        cardElements.forEach(cardElement => {
            if (cardElement.textContent.trim() === card.text.trim()) {
                cardElement.classList.remove('active');
            }
        });
    });
    clickedCards = [];
}

function shuffle() {
    const container = document.getElementById('cardContainer');
    const boxes = Array.from(container.getElementsByClassName('box'));

    for (let i = boxes.length - 1; i > 0; i--) {//add an >=??
        const j = Math.floor(Math.random() * (i + 1));
        [boxes[i], boxes[j]] = [boxes[j], boxes[i]]; // Swap elements
    }
    boxes.forEach(box => container.appendChild(box));
}

function successfulConnection() {
    console.log("successful connection");
    const allCards = document.querySelectorAll('.box');
    allCards.forEach(card => {
        if (card.dataset.groupName === lastCardGroupName) {
            card.remove();
        }
    })
    const success = document.querySelector(`[data-name="${lastCardGroupName}"]`);
    document.getElementById(success.id).style.display = "block";
    document.getElementById(success.id).style.animationDelay = "0.5s";
}

function mistake() {
    mistakesRemaining -= 1;
    if (mistakesRemaining > 0) {
        const mistakeTally = document.getElementById('circle');
        mistakeTally.remove();
        console.log("mistakesRemaining", mistakesRemaining);
    }
    else if (mistakesRemaining == 0) {
        gameOver();
    }
}

function initialize() {
    console.log('initializing madeVersion.js')
    // hide successful connections
    document.getElementById('success1').style.display = "none";
    document.getElementById('success2').style.display = "none";
    document.getElementById('success3').style.display = "none";
    document.getElementById('success4').style.display = "none";
    document.getElementById('resultsContainer').style.display = "none";
    document.getElementById('results-button-container').style.display = "none";
    const cards = document.querySelectorAll('.box');
    cards.forEach(card => {
        card.addEventListener("click", cardClicked);
    });
    const submit = document.getElementById('submit-btn');
    submit.addEventListener("click", submitConnection);

    const resultsPressed = document.getElementById('results-btn');
    resultsPressed.addEventListener("click", viewResults);

    const shufflePressed = document.getElementById('shuffle-btn');
    shufflePressed.addEventListener("click", shuffle);

    const deselectPressed = document.getElementById('deselect-btn');
    deselectPressed.addEventListener("click", deselectBtn);
}

document.addEventListener('DOMContentLoaded', initialize);