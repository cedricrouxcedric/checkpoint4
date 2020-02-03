const canvas = document.getElementById("myCanvas"); // association a la balise canavas

const ctx = canvas.getContext("2d"); // context 2d
const scoreBoard = document.getElementById('score');
const ballRadius = 10; // rayon de la balle
var x = canvas.width/2; // position x du centre de la balle
let y = (canvas.height-10)-10; // position y du centre de la balle
let dx = 2; // vitesse horizontale
let dy = 2; // vitesse verticale
let paddleHeight = 10; // hauteur du paddle
let paddleWidth = 70; // largeur du paddle
let paddleX = (canvas.width-paddleWidth)/2; // position x du coin haut gauche du paddle
let rightPressed = false;  // booleen droite
let leftPressed = false;  // booleen gauche
let brickRowCount = 5; // nbr de lignes de briques
let brickColumnCount = 6; // nbr de colonnes de briques
let brickWidth = 60;    // largeur des briques
let brickHeight = 20; // hauteur des briques
let brickPadding = 10; // padding entre briques
let brickOffsetTop = 30;
let brickOffsetLeft = 30;
let bricks = []; // creation d'un tableau 2d contenant les colonnes et les lignes de briques[(c),(r)]
for(var c=0; c<brickColumnCount; c++) {
    bricks[c] = [];
    for(var r=0; r<brickRowCount; r++) { // chaque brique a ses coordonées x y
        bricks[c][r] = { x: 0, y: 0,status: 1 }; // coordonées de la brique et satus 1 ou 0 pour savoir si la fonction drawBricks() doit la dessiner
    }
}
let brickX = (c*(brickWidth+brickPadding))+brickOffsetLeft;
let brickY = (r*(brickHeight+brickPadding))+brickOffsetTop;
document.addEventListener("keydown", keyDownHandler, false); // event listener keypress
document.addEventListener("keyup", keyUpHandler, false); // event listener keyup
document.addEventListener("mousemove", mouseMoveHandler, false);
let score = 0;
let lives = 3;
function mouseMoveHandler(e) { // e.clientX = X de la souris dans la fenetre
    let relativeX = e.clientX - canvas.offsetLeft;  // e.clientX - dist entre bord gauche du canvas (canvas.offsetLeft)
    if(relativeX > 0 && relativeX < canvas.width){ // Si relativeX est supérieure à zéro et inférieure à la largeur du canevas
        paddleX = relativeX - paddleWidth/2; // paddleX (bord gauche du paddle) est définie sur la valeur relativeX moins la moitié de la largeur du paddle, le mouvement sera en fait par rapport au milieu du paddle.
    }
}
function keyDownHandler(e) { // declaration de la fonction keypress droite
    if(e.keyCode == 39) { // 39 === fleche droite
        rightPressed = true; // changement de l'etat du booleen droite
    }
    else if(e.keyCode == 37) { // 37 == fleche gauhe
        leftPressed = true;   // changement de l'etat du booleen gauche
    }
}
function keyUpHandler(e) { // declaration de la fonction keyup
    if(e.keyCode == 39) {
        rightPressed = false;
    }
    else if(e.keyCode == 37) {
        leftPressed = false;
    }
}
function collisionDetection() { // fonction detection de collision avec une brique
    for(var c=0; c<brickColumnCount; c++) { // pour chaque colonne
        for(var r=0; r<brickRowCount; r++) { // pour chaque ligne
            let b = bricks[c][r]; // stockage de la position x et y de la brique dans une variable b
            if(b.status == 1){
                if(x > b.x && x < b.x+brickWidth && y > b.y && y < b.y+brickHeight) { // si le centre de la balle est dans une brique
                    dy = -dy; // inversion de la vitesse verticale
                    b.status = 0; // changement du status de la brique touchée part la balle
                    score++; // incrementation de la var score
                    if (score == brickColumnCount*brickRowCount) {
                        score ="VICTORY";
                        dy = 0 ;
                        dx = 0 ;
                        location.replace("/win")
                        clearInterval(interval); // necessaire pour chrome pour finir le jeu
                    }
                }
            }
        }
    }
}
function drawScore() { // fonction affichage du score
    ctx.font = "16px Arial"; // .font definit la taille et la police de text du score
    ctx.fillStyle = "#BADA55"; // couleur du texte
    ctx.fillText("score :"+score ,8, 20); // mise en place le texte 1er param est le texte  les 2 suivants sont les coordonées où le texte sera placé dans le canvas
    scoreBoard.textContent = score;
}
function drawLives() {
    ctx.font = "16 px Arial";
    ctx.fillStyle = "#B000B5";
    ctx.fillText("lives: "+lives, canvas.width-65, 20);
}
function drawBall() { // declaration de la fonction dessine la balle
    ctx.beginPath(); // commence le dessin
    ctx.arc(x, y, ballRadius, 0, Math.PI*2);
    ctx.fillStyle = "#0095DD"; // couleur
    ctx.fill(); // apllique la couleur
    ctx.closePath(); // fin du dessin
}

function drawPaddle() { // dessin du paddle
    ctx.beginPath();
    ctx.rect(paddleX, canvas.height-paddleHeight, paddleWidth, paddleHeight);
    ctx.fillStyle = "#0095DD";
    ctx.fill();
    ctx.closePath();

}
function drawBricks() { // declaration de la fonction dessine les briques
    for(var c=0; c<brickColumnCount; c++) { // boucle le nombre de colonnes
        for(var r=0; r<brickRowCount; r++) { // boucle nbr de lignes
            if (bricks[c][r].status == 1){ // si le status de la brique == 1 ;)
                let brickX = (c*(brickWidth+brickPadding))+brickOffsetLeft; // calcul de la position x de la brique
                let brickY = (r*(brickHeight+brickPadding))+brickOffsetTop; // calcul de la position y de la brique
                bricks[c][r].x = brickX; // atribution de la valeur a la position x de la brique bricks[c][r]
                bricks[c][r].y = brickY; // atribution de la valeur a la position y de la brique bricks[c][r]
                ctx.beginPath(); // debut du dessin de la brique
                ctx.rect(brickX, brickY, brickWidth, brickHeight); // definition de la forme de la brique
                ctx.fillStyle = "#0095DD"; // couleur de la brique
                ctx.fill(); // application de la couleur à la brique
                ctx.closePath();// fin du dessin de la brique
            }
        }
    }
}
function draw() { // dessiner tout
    ctx.clearRect(0, 0, canvas.width, canvas.height);// efface l'image precedente
    drawBall();
    drawPaddle();
    drawScore();
    drawLives();
    drawBricks();
    collisionDetection();
    if(x + dx > canvas.width-ballRadius || x + dx < ballRadius) { // condition collision dauche droite
        dx = -dx; // inversion de la vitesse horizontale
    }
    if(y -ballRadius === 0) { // condition collision haut
        dy = -dy; // inversion vitesse verticale
    }
    if(y+ballRadius+paddleHeight  >= canvas.height)  { // Le bas de la balle est a la hauteur du paddle
        if(x >= paddleX && x <= paddleX+paddleWidth) {
            dy = -dy;
        } else {
            dy = dy;
        }
    }
    if(y-(ballRadius) >= canvas.height) { // si la balle touche le mur du bas
        lives--;
        if(!lives) {
            score = ("GAME OVER");
            document.location.reload();

        }
        else {
            x = canvas.width/2;
            y = canvas.height-30;
            dx = 2;
            dy = -2;
            paddleX = (canvas.width-paddleWidth)/2;
        }}

    if(rightPressed && paddleX < canvas.width-paddleWidth) { // condition de deplacement du paddle vers la droite
        paddleX += 5;
    }
    else if(leftPressed && paddleX > 0) { // condition de deplacement du paddle vers la gauche
        paddleX -= 5;
    }
    x += dx;
    y += dy;
}
setInterval(draw, 1000/70); // appelle la fonction 70 fois par seconde
