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
    //button.setAttribute("id", wordIndex+1 . );

    let wordsContainer = document.getElementById(`wordsContainer${categoryId}`);
    wordsContainer.appendChild(button);

    if (!Array.isArray(enteredWords[categoryId - 1])) {
        enteredWords[categoryId - 1] = []; // Initialize the category array
    }
    
    enteredWords[categoryId-1][wordIndex] = text;
    console.log("category", categoryId-1);
    console.log("wordIndex", wordIndex);
    console.log(enteredWords[1][1]);

    // Add event listener to remove the word when clicked
    button.addEventListener("click", () => {
        replaceWord(categoryId, wordIndex, button);
    });
    

}
function replaceWord(categoryId, wordIndex, button){
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
/*
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
*/

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
        if (wordCount >= 16) {
            alert("You have entered all your words and categories! Get ready to play your game!");
            return;
        }

        let currentCategory = Math.floor(wordCount / 4);

        // 🛠 Fix: Ensure `enteredWords[currentCategory]` exists before pushing words
        if (!enteredWords[currentCategory]) {
            enteredWords[currentCategory] = []; // Initialize array
        }

        let wordIndex =  enteredWords[currentCategory].length; // Use length as index

        enteredWords[currentCategory].push(searchTerm);
        createWordButton(searchTerm, currentCategory + 1, wordIndex);

        wordCount++;
        event.target.value = "";
    }
});



/*
async function saveToJsonFile() {
    const fileName = "game_data.json";
    let existingData = [];

    // Try to fetch the existing JSON file
    try {
        const response = await fetch(fileName);
        if (response.ok) {
            existingData = await response.json();
        }
    } catch (error) {
        console.log("No existing file found, creating a new one.");
    }

    // Construct new game data
    const newGameData = {
        id: Date.now().toString().slice(-6), // Unique ID
        title: enteredTitle,
        group1: enteredCategories[0] || "Category 1",
        items1: (enteredWords[0] || []).join(", "), 
        group2: enteredCategories[1] || "Category 2",
        items2: (enteredWords[1] || []).join(", "),
        group3: enteredCategories[2] || "Category 3",
        items3: (enteredWords[2] || []).join(", "),
        group4: enteredCategories[3] || "Category 4",
        items4: (enteredWords[3] || []).join(", ")
    };

    // Append new game data to existing data
    existingData.push(newGameData);

    // Convert to JSON string
    const jsonData = JSON.stringify(existingData, null, 4);

    // Create a Blob with updated JSON data
    const blob = new Blob([jsonData], { type: "application/json" });

    // Create a download link for updated JSON (overwrites the same file)
    const a = document.createElement("a");
    a.href = URL.createObjectURL(blob);
    a.download = fileName;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);

    console.log("New game added:", newGameData);
}
*/
// Create a button to trigger JSON save
const saveButton = document.createElement("button");
saveButton.textContent = "Save Game";
saveButton.classList.add("box");
saveButton.addEventListener("click", (event) => {
    //saveToJsonFile();
    // foreach(enteredWords as wordslist){

    // }
    //const i;
    //const hiddenList = dom.getElementById("hidden");
    for(let i = 0; i < wordCount; i++){
        //for(let j = 0; j < enteredWords[i].length; j++){
        console.log(wordCount);
        //let itemsList = document.getElementById(`${i}`);
        let itemsList = document.getElementById(`wordsContainer${i + 1}`);
        console.log(itemsList);
        itemsList.textContent = enteredWords[i][0] + ", " + enteredWords[i][1] + ", " + enteredWords[i][2] + ", " + enteredWords[i][3] + ", ";
        //}
    }
});


// Append button to container
document.querySelector(".container").appendChild(saveButton);
