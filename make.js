let enteredWords = [];
let wordCount = 0;
let categoryCount = 0;
let enteredCategories = [];

function createWordButton(text, list){
    let button = document.createElement("button");
    button.classList.add("box"); 
    button.textContent = text; 

    // Add event listener to remove the word when clicked
    button.addEventListener("click", () => {
        button.remove();
        let index = list.indexOf(text);
        if (index > -1) {
            list.splice(index, 1);
        }
        console.log("Updated List: ", list);
    });
    console.log("List: ", list);
    //container.appendChild(button);
}
document.getElementById("wordInput")?.addEventListener("keypress", (event) => {
    if (event.key === "Enter") {
        let searchTerm = event.target.value.trim();
        console.log("Word Count: ", wordCount);
        console.log("Category Count: ", categoryCount);
        if (searchTerm !== "" && enteredWords.length <= 16) {
            if(wordCount == 4 && categoryCount < 1 || wordCount == 8 && categoryCount < 2 || wordCount == 12 && categoryCount < 3){
                alert("You must add a category before entering four more words!");
                return;
            } else if(wordCount == 16 && categoryCount < 4){
                alert("You have entered all your words! Please enter your last category.");
                console.log("we have 16 words so whats up")
                return true;
            } else if(searchTerm !== "" && wordCount < 16){
                enteredWords.push(searchTerm);
                createWordButton(searchTerm, enteredWords);
                wordCount++;
                console.log("added to the word count because of word")
                console.log("Word Count: ", wordCount);
                event.target.value = ""; // Clear input after entry
            } else {
                alert("You have entered all of your words and categories! Get ready to play your game:)");
                console.log("else");
            }
        }
    }
});

document.getElementById("categoryInput")?.addEventListener("keypress", (event) => {
    if (event.key === "Enter") {
        let categoryTerm = event.target.value.trim();
        console.log("Category Count from categoryInput")
        if (categoryTerm !== "" && enteredCategories.length < 4 && !enteredCategories.includes(categoryTerm)) {
            enteredCategories.push(categoryTerm);
            createWordButton(categoryTerm, enteredCategories);
            categoryCount++;
            event.target.value = ""; // Clear input after entry
        } else {

        }
    }
});