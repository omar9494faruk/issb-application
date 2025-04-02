       
// this whole section is used for the timer of the iq application       

document.addEventListener("DOMContentLoaded", function () {
    setTimeout(function () {
        document.getElementById("gogo").click();
    }, 30000*60000); // 30 minutes [1 minute = 60000 milli seconds]
});


document.addEventListener("DOMContentLoaded", function () {
    let timeLeft = 30 * 60; // 30 minutes in seconds
    const timerDisplay = document.createElement("div");
    timerDisplay.id = "timer";
    document.body.prepend(timerDisplay);

    function updateTimer() {
        let minutes = Math.floor(timeLeft / 60);
        let seconds = timeLeft % 60;
        timerDisplay.textContent = `${minutes}:${seconds < 10 ? "0" : ""}${seconds}`;
        if (timeLeft > 0) {
            timeLeft--;
            setTimeout(updateTimer, 1000);
        } else {
            document.getElementById("gogo").click();
        }
    }
    updateTimer();
});







