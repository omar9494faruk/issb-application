document.addEventListener("DOMContentLoaded", function () {
    const wordsContainer = document.getElementById("words");
    const startButton = document.getElementById("startButton");
    const wordCount = document.getElementById("wordCount");
    const startNumberInput = document.getElementById("startNumber");
    const words = wordsContainer.innerText.trim().split(" ");
    const clickSound = new Audio("click.mp3"); // Add a click sound file in your project

    let index = 0;
    let wordCounter = 0; // Counter to track how many words have been shown
    const maxWords = 80; // Maximum number of words to show

    // Display word count
    wordCount.innerText = `Total Words: ${words.length}`;

    function changeWord() {
        clickSound.play().catch(err => console.warn("Audio playback prevented by browser policy."));
        wordsContainer.innerText = words[index];
        index = (index + 1) % words.length; // Loop through words
        wordCounter++; // Increment word counter

        // Stop the word switching after showing 80 words
        if (wordCounter >= maxWords) {
            clearInterval(wordInterval); // Stop the interval
            alert("The program has stopped after showing 80 words.");
        }
    }

    // Hide words initially
    wordsContainer.style.display = "none";

    // Start the word switching on button click
    startButton.addEventListener("click", function () {
        // Get the start number from the input
        let startNum = parseInt(startNumberInput.value);

        // Validate the input (should be a number between 1 and the total number of words)
        if (isNaN(startNum) || startNum < 1 || startNum > words.length) {
            alert(`Please enter a valid number between 1 and ${words.length}.`);
            return;
        }

        // Adjust the index to start from the specified word number
        index = startNum - 1;

        // Hide the input box after the button is clicked
        startNumberInput.style.display = "none";

        // Show the words and hide the start button
        wordsContainer.style.display = "block"; 
        startButton.style.display = "none"; 
        wordCount.style.display = "none";
        inputText.style.display = "none";

        // Show the first word from the inputted start number
        changeWord(); 

        // Change word every 10 seconds
        wordInterval = setInterval(changeWord, 10000);
    });
});
