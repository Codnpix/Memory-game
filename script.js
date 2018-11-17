let container = document.querySelector("main");
let showAllButton = document.querySelector("#showAllButton");
let showPairsBar = document.querySelector("aside");
let bestScore = document.getElementById("bestScore");
let counter = document.getElementById("counter");
let score = 0;

let cards = [];

let oddCards = [];
let evenCards = [];

let imagesForOdd = [];
let imagesForEven = [];

let visibleCards= [];

let pairs = [];

let img1 = "url(img/1.jpeg)";
imagesForEven.push(img1);
imagesForOdd.push(img1);
let img2 = "url(img/2.jpeg)";
imagesForEven.push(img2);
imagesForOdd.push(img2);
let img3 = "url(img/3.jpeg)";
imagesForEven.push(img3);
imagesForOdd.push(img3);
let img4 = "url(img/4.jpeg)";
imagesForEven.push(img4);
imagesForOdd.push(img4);
let img5 = "url(img/5.jpeg)";
imagesForEven.push(img5);
imagesForOdd.push(img5);
let img6 = "url(img/6.jpeg)";
imagesForEven.push(img6);
imagesForOdd.push(img6);
let img7 = "url(img/7.jpeg)";
imagesForEven.push(img7);
imagesForOdd.push(img7);
let img8 = "url(img/8.jpeg)";
imagesForEven.push(img8);
imagesForOdd.push(img8);

//créer les 16 divs
for(let i = 0; i < 16 ; i++) {
    let card = document.createElement('div');
    container.appendChild(card);
    cards.push(card);//les ajouter au tableau cards
}

let oddi = 8; //itérateur du tableau images
function oddGetRdmImg() {
    let rdmNb = Math.floor(Math.random() * oddi);
    let gotImg = imagesForOdd[rdmNb];
    imagesForOdd.splice(rdmNb, 1);//retirer l'image choisie du tableau
    oddi--;//décrémenter l'itérateur du tableau images
    return gotImg;
}

let eveni = 8;
function evenGetRdmImg() {
    let rdmNb = Math.floor(Math.random() * eveni);
    let gotImg = imagesForEven[rdmNb];
    imagesForEven.splice(rdmNb, 1);
    eveni--;
    return gotImg;
}

function showOne(e) {
   e.target.style.backgroundImage = this.image;
    visibleCards.push(this);
    
    if (visibleCards.length === 2){desactivClic();}
    if (visibleCards.length === 2 && visibleCards[0].image === visibleCards[1].image) {
        
        setTimeout(function() {
            visibleCards[0].style.visibility = "hidden";
            visibleCards[1].style.visibility = "hidden";
            pairs.push(visibleCards[0].image);
            visibleCards.splice(0,2);
            //affichier la dernière image du tableau pairs
            showPairs(pairs[pairs.length -1]);
            activClic();
        }, 800);
        score ++;
        counter.textContent = score + " coups.";
    }
    else if (visibleCards.length === 2 && visibleCards[0] !== visibleCards[1]) {
        setTimeout(function() {
            hideAll();
            visibleCards.splice(0,2);
            activClic();
        }, 800)
        score ++;
        counter.textContent = score + " coups.";
    }
}

function hideOne() {
    this.style.backgroundImage = "url(img/herbe.jpeg)";
}

function showAll() {
    for (let card of cards) {
        card.style.backgroundImage = card.image;
        setTimeout(hideAll, 8000);
    }
    showAllButton.disabled = true;
}

function hideAll() {
    for (let card of cards) {
        card.style.backgroundImage = "url(img/herbe.jpeg)";
    }
}

function showPairs(imgUrl) {
    let newPair = document.createElement("div");
    newPair.style.backgroundImage = imgUrl;
    showPairsBar.appendChild(newPair);
    if (pairs.length === 8) {
        showWin();
    }
}

function showWin() {
    let winDiv = document.createElement("div");
    winDiv.setAttribute("id", "winDiv");
    document.body.appendChild(winDiv);
    /*message et score*/
    winDiv.innerHTML = "Bravo ! <br><br>" + "<small>Score : " + score + " coups.</small>";
    
    /*retry*/
    let retryButton = document.createElement("button");
    retryButton.setAttribute("id", "retry");
    winDiv.appendChild(retryButton);
    retryButton.textContent = "Rejouer";
    retryButton.addEventListener("click", function() {
        window.location.assign("score.php?score="+score);
    });
}

for (let i = 0; i < cards.length; i++) {
    if (i%2 === 0) {
        evenCards.push(cards[i]);
    }
    else if(i%2===1) {
        oddCards.push(cards[i]);
    }
}

function activClic() {
    for (let card of oddCards) {
        card.addEventListener("click", showOne);
    }
    for (let card of evenCards) {
        card.addEventListener("click", showOne);
    }
}

function desactivClic() {
    for (let card of oddCards) {
        card.removeEventListener("click", showOne);
    }
    for (let card of evenCards) {
        card.removeEventListener("click", showOne);
    }
}

for (let card of oddCards) {
    card.image = oddGetRdmImg();
    card.addEventListener("click", showOne);
}

for (let card of evenCards) {
    card.image = evenGetRdmImg();
    card.addEventListener("click", showOne);
}

showAllButton.addEventListener("click", showAll);