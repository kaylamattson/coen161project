let enteredWords = [[], [], [], []];
let wordCount = 0;
let categoryCount = 0;
let enteredCategories = [];
let enteredTitle = "";

function createTitleButton(text){
    document.getElementById("titleContainer").setAttribute("style", "display: block;");
    let button = document.createElement("button");
    button.classList.add("box"); 
    button.textContent = text; 
    document.getElementById("titleContainer").appendChild(button);
    
    

    // Add event listener to remove the word when clicked
    button.addEventListener("click", () => {
        button.remove();
        document.getElementById("titleContainer").setAttribute("style", "display: none;");
        enteredTitle = "";
        console.log("Updated Title: ", "");
    });
    
    return;
}
document.getElementById("titleInput")?.addEventListener("keypress", (event) => {
    if (event.key === "Enter") {
        let title = event.target.value.trim();
        event.target.value = "";

        if(title === ""){
            alert("Title cannot be empty");
            return;
        }
        if(enteredTitle.length > 0){
            alert("Title already entered");
            return;
        }
        else{
            enteredTitle = title;
            createTitleButton(enteredTitle);
            console.log("Title: ", enteredTitle);
        }
    }


});

function createCategoryButton(categoryId, categoryName){
    document.getElementById(`cat${categoryId}`).setAttribute("style", "display: flex;");
    let categoryButton = document.createElement("button");
    categoryButton.classList.add("box");
    categoryButton.textContent = categoryName;

    let categoryContainer = document.getElementById(`categoryButton${categoryId}`);
    categoryContainer.appendChild(categoryButton);

    /*categoryButton.addEventListener("click", () => {
        categoryButton.textContent = "";
        enteredCategories.splice(enteredCategories.indexOf(categoryName), 1);
        document.getElementById(`cat${categoryId}`).setAttribute("style", "display: none;");
        console.log("Category removed: ", categoryName);
        categoryCount--;
    });*/
    categoryButton.addEventListener("click", () => {
        replaceCategory(categoryId, categoryButton);
    });
    
    return;
}
document.getElementById("categoryInput")?.addEventListener("keypress", (event) => {
    if (event.key === "Enter") {
        let categoryTerm = event.target.value.trim();

        if (categoryTerm !== "" && enteredCategories.length < 4 && !enteredCategories.includes(categoryTerm)) {
            enteredCategories.push(categoryTerm);
            categoryCount++;
            createCategoryButton(categoryCount, categoryTerm);
            event.target.value = ""; // Clear input after entry
        } 
        else if(categoryTerm == enteredCategories[0] || categoryTerm == enteredCategories[1] || categoryTerm == enteredCategories[2] || categoryTerm == enteredCategories[3]){
            alert("You have entered a duplicate category.");
            event.target.value = "";
            return;
        }
        else{
            alert("You have entered all your categories.");
            event.target.value = "";
            return;
        }
    }
});


function createWordButton(text, categoryId, wordIndex){
    let button = document.createElement("button");
    button.classList.add("box"); 
    button.textContent = text; 

    let wordsContainer = document.getElementById(`wordsContainer${categoryId}`);
    wordsContainer.appendChild(button);

    // Add event listener to remove the word when clicked
    button.addEventListener("click", () => {
        replaceWord(categoryId, wordIndex, button);
    });
    

}
function replaceWord(categoryId, button){
    let newWord = prompt("Enter a replacement word:");
    
    if (!newWord || newWord.trim() === "") {
        alert("Word cannot be empty!");
        return;
    }
    
    newWord = newWord.trim();
    enteredWords[categoryId - 1][wordIndex] = newWord;
    // Update the button text instead of removing the button
    button.textContent = newWord;
    
}
function replaceCategory(categoryId, button){
    let newCat = prompt("Enter a replacement category:");
    
    if (!newCat || newCat.trim() === "") {
        alert("Word cannot be empty!");
        return;
    }
    
    newCat = newCat.trim();
    enteredCategories[categoryId - 1] = newCat;
    // Update the button text instead of removing the button
    button.textContent = newCat;
    
}

document.getElementById("wordInput")?.addEventListener("keypress", (event) => {
    if (event.key === "Enter") {
        let searchTerm = event.target.value.trim();
        if (searchTerm === "") {
            alert("Invalid input! Please make sure you enter a word.");
            return;
        }
        if (categoryCount < 1) {
            alert("You must add a category before entering words!");
            return;
        }
        else if (categoryCount == 1 && wordCount == 4) {
            alert("Add a new category before entering new words");
            return;
        }
        else if(categoryCount == 2 && wordCount == 8){
            alert("Add a new category before entering new words");
            return;
        }
        else if(categoryCount == 3 && wordCount == 12){
            alert("Add a new category before entering new words");
            return;
        }
        if (wordCount >= 16) {
            alert("You have entered all your words and categories! Get ready to play your game!");
            return;
        }



        let currentCategory = Math.floor(wordCount / 4);
        let wordIndex = enteredWords[currentCategory].indexOf(null);


        if (wordIndex !== -1 ) {
            // Replace empty spot
            enteredWords[currentCategory][wordIndex] = searchTerm;
        } else{
            wordIndex = enteredWords[currentCategory].length;
            enteredWords[currentCategory].push(searchTerm);
            wordCount++;
        }

        createWordButton(searchTerm, currentCategory + 1, wordIndex);
        event.target.value = "";

    }
});





