window.addEventListener("load", function(event){

    let canvas = document.getElementById("splashCanvas");
    let ctx = canvas.getContext("2d");
    let card1Y = 0; 
    let card2Y = 0;
    let direction = 1;
    let switchCount = 0;
    let timerId; 

    //splash screen animation
    function updateAnimation(){
        ctx.clearRect(0,0,canvas.width,canvas.height);

        ctx.fillStyle = "rgb(255, 243, 251)"
        ctx.fillRect(0,0,canvas.width,canvas.height);
        //first card
        ctx.fillStyle = "rgb(255, 200, 228)";
        ctx.beginPath();
        ctx.roundRect(card1Y + 175, 375, 60, 100, [8]);
        ctx.fill();
        //second card
        ctx.fillStyle = "rgb(243, 187, 216)";
        ctx.beginPath();
        ctx.roundRect(card2Y + 245, 375, 60, 100, [8]);
        ctx.fill();

        card1Y += 2.5 * direction;
        card2Y -= 2.5 * direction;
        //flipping animation
        if (card1Y + 150 > 230){
            direction = -1
            switchCount += 1;
        }
        if (card1Y + 150 < 150){
            direction = 1
            switchCount += 1;
        }
        if (switchCount == 2){
            clearInterval(timerId);
        }
    }

    //animation helper function
    function startAnimation() {
        timerId = setInterval(updateAnimation, 16);
    }
    //display start screen
    function showStartScreen(){
        document.getElementById("splashScreen").style.display = "none";
        document.getElementById("startScreen").style.display = "flex";
    }

    document.getElementById("startGameButton").addEventListener("click", function(){
        document.getElementById("startScreen").style.display = "none";
        startGame();
    });

    startAnimation();
    setTimeout(showStartScreen, 3500); //wait 3.5 seconds then show game

    class Card {
        constructor(frontImg, element) {
            this.frontImg = frontImg;
            this.element = element;
            this.matched = false;
        }
        flip() { //flip to fruit
            this.element.classList.add("flip");
            setTimeout(() => {
                this.element.src = this.frontImg;
                this.element.classList.remove("flip");
            }, 100);
        }
        flipBack() { //flip to back
            this.element.classList.add("flip");
            setTimeout(() => {
                this.element.src = "images/backCard.png";
                this.element.classList.remove("flip");
            }, 100);
        }
        markMatched() { 
            this.element.classList.add("matched");
            this.matched = true;
        }
    }

    class Game {
        constructor(cardElements) {
            this.cards = [];
            this.moves = 0;
            this.matches = 0;
            this.firstCard = null;
            this.secondCard = null;
            this.locked = false;

            //create Card objects
            let frontImages = [
                "images/appleCard.png","images/bananaCard.png",
                "images/kiwiCard.png","images/lemonCard.png",
                "images/limeCard.png","images/peachCard.png",
                "images/pomegranateCard.png","images/orangeCard.png",
                "images/appleCard.png","images/bananaCard.png",
                "images/kiwiCard.png","images/lemonCard.png",
                "images/limeCard.png","images/peachCard.png",
                "images/pomegranateCard.png","images/orangeCard.png"
            ];

            //shuffle images
            for(let i = 0; i < frontImages.length; i++){
                let rand = Math.floor(Math.random() * frontImages.length);
                [frontImages[i], frontImages[rand]] = [frontImages[rand], frontImages[i]];
            }

            cardElements.forEach((el, index) => {
                let card = new Card(frontImages[index], el);
                this.cards.push(card);
                
                el.addEventListener("click", () => {
                    this.handleClick(card)
                });
            });
        }
        /* checks if cards are matching, flips cards back if unmatched
        * @param {Object} card
        */
        handleClick(card){
            if (this.locked || card.matched || card === this.firstCard) return;

            card.flip();

            if (!this.firstCard){
                this.firstCard = card;
            } 
            else {
                this.secondCard = card;
                this.moves += 1;
                document.getElementById("moves").innerHTML = this.moves;
                this.locked = true;

                if (this.firstCard.frontImg === this.secondCard.frontImg){ //matched
                    setTimeout(() => {
                        this.firstCard.markMatched();
                        this.secondCard.markMatched();
                        this.firstCard = null;
                        this.secondCard = null;
                        this.locked = false;
                        this.matches += 1;

                        if(this.matches === 8){
                            endScreen(this.moves);
                        }
                    }, 500);
                } 
                else { //unmatched
                    setTimeout(() => {
                        this.firstCard.flipBack();
                        this.secondCard.flipBack();
                        this.firstCard = null;
                        this.secondCard = null;
                        this.locked = false;
                    }, 1000);
                }
            }
        }

    };

    //starts the game
    function startGame(){
        document.getElementById("splashScreen").style.display = "none";
        document.getElementById("gameScreen").style.display = "block";
        //help popup
        let helpButton = document.getElementById("helpButton");
        let helpPopup = document.getElementById("helpPopup");
        let closeHelp = document.getElementById("closeHelp");

        helpButton.addEventListener("click", function(){
            helpPopup.style.display = "flex";
        });

        closeHelp.addEventListener("click", function(){
            helpPopup.style.display = "none";
        });

        //initiate the game
        let cardElements = document.querySelectorAll(".card img");
        new Game(cardElements);
    }

    const resultForm = document.getElementById("resultForm");
    const movesInput = document.getElementById("movesInput");
    //const playAgainBtn = document.getElementById("playAgain");
    const quitBtn = document.getElementById("quitButton");
    const quitBtnEnd = document.getElementById("quitButtonEnd");

    //playAgainBtn.addEventListener("click", function() {
    //    startGame();
    //});
    /*
    quitBtn.addEventListener("click", function() {
        // Take current moves from #moves span
        if(!gameFinished){
            movesInput.value = null;
            resultForm.submit();
        }
        
    });*/

    quitBtnEnd.addEventListener("click", function() {
        movesInput.value = document.getElementById("finalMoves").innerHTML;
        resultForm.submit();
    });

    /* end of game screen
    * @param {Number} moves
    */
   let gameFinished = false;
    function endScreen(moves){
        gameFinished = true;
        document.getElementById("gameScreen").style.display = "none";
        document.getElementById("endScreen").style.display = "flex";

        document.getElementById("finalMoves").innerHTML = moves;
        movesInput.value = moves;
    }
});

