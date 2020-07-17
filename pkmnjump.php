<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Bulbasaur's Big Adventure</title>
    <!-- influenced by https://www.w3schools.com/graphics/game_intro.asp -->
    <style>
        body {
            background: #414A73;
        }

        canvas {
            border: 10px solid #303032;
            background-color: #303032;
            padding-left: 10px;
            padding-right: 10px;
            padding-top: 20px;
            padding-bottom: 20px;
            position: absolute;;
            left: 390px;
            top: 173px;
        }

        #smolscreen {
            display: none;
        }

        #namer {
            color: #ffffff;
            position: absolute;
            top: 480px;
            left: 480px;
        }

        #named {
            color: #ffffff;
            position: absolute;
            top: 150px;
            left: 530px;
        }

        .keyboardinstr {
            display: initial;
            position: absolute;
        }

        .onscreenbuttons {
            display: none;
        }

        #audio {
            width: 300px;
            position: absolute;
            top: 455px;
            left: 175px;
        }

        #audio > p {
            display: none;
        }

        #audio:hover > p {
            display: initial;
        }

        @media (max-width: 415px) {
            #bigscreen {
                display: none;
            }

            #audio{
                top:460px;
                left:-14px;
            }

            .keyboardinstr {
                display: none;
            }

            #smolscreen {
                display: initial;
                left: 0px;
                top: 0px
            }

            body {
                background-color: #C5C9CD;
            }

            canvas {
                left: 50px;
                top: 55px;
                width: 216px;
                height: 130px;
                padding-left: 1px;
                padding-right: 1px;
                padding-top: 1px;
                padding-bottom: 1px;
                background-color: #000000;
                border-width: 1px;
                border-color: #000000;
            }

            #audio {
                width: 300px;
            }

            .onscreenbuttons {
                display: initial;
                position: absolute;
            }

            .onscreenbuttons > button {
                border-radius: 10%;
                position: relative;

            }
        }
    </style>
</head>
<body onload="startGame()">
<img id="bigscreen" src="gbabg.jpg" style="width:1280px; height:720px"/>
<!-- BUTTONS FOR MOBILE ------------------------------->
<div class="onscreenbuttons">
    <button onpointerdown="moveup();" onpointerup="clearmove();" style="top:315px; left:64px;">U
    </button>

    <button onpointerdown="moveleft();" onpointerup="clearmove();" style="top:340px; left:2px;">L
    </button>
    <button onpointerdown="moveright();" onpointerup="clearmove();" style="top:340px; left: 30px;">R
    </button>

    <button onpointerdown="movedown();" onpointerup="clearmove();" style="top:365px; left:-35px;">D
    </button>

</div>

<div class="keyboardinstr" style="top: 245px; left:190px; color:#ffffff; text-align:center;">
    <p>to<br>move:<br> WASD or arrows</p>
</div>

<!-- BACKGROUND FOR MOBILE -------------------------->
<img id="smolscreen" src="gbaspport.jpg" style="width:300px; height:500px;"/>

<!-- GAME SCRIPT ---------------------------------------- -->
<script>

    var Bulbasaur;
    var Scenery;
    var myName;

    function startGame() {
        Bulbasaur = new component(20, 20, "BR.png", 10, 140, "image");
        Scenery = new component(832, 368, "pkmntrees.png", 0, 0, "image");
        //myName = new component(20,5, "#ffffff", 20,18,"text");
        myGameArea.start();
    }

    var myGameArea = {
        canvas: document.createElement("canvas"),
        start: function () {

            this.canvas.width = 480;
            this.canvas.height = 270;
            this.context = this.canvas.getContext("2d");
            document.body.insertBefore(this.canvas, document.body.childNodes[0]);
            this.frameNo = 0;
            this.interval = setInterval(updateGameArea, 20);
        },
        clear: function () {
            this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
        },
        stop: function () {
            clearInterval(this.interval);
        }
    }

    function component(width, height, color, x, y, type) {
        this.type = type;
        if (this.type == "text") {
            ctx.font = "10px Consolas";//this.width + " " + this.height;
            ctx.fillStyle = color;
            ctx.fillText("hello world", this.x, this.y);
        } else if (type == "image") {
            this.image = new Image();
            this.image.src = color;
        }
        this.width = width;
        this.height = height;
        this.speedX = 0;
        this.speedY = 0;
        this.x = x;
        this.y = y;
        this.update = function () {
            ctx = myGameArea.context;
            if (type == "image") {
                ctx.drawImage(this.image,
                    this.x,
                    this.y,
                    this.width, this.height);
            } else {
                ctx.fillStyle = color;
                ctx.fillRect(this.x, this.y, this.width, this.height);
            }
        }
        this.newPos = function () {
            this.x += this.speedX;
            this.y += this.speedY;
        }
    }

    function updateGameArea() {
        myGameArea.clear();

        Scenery.newPos();
        Scenery.update();
        Bulbasaur.newPos();
        Bulbasaur.update();
        // myName.update();
    }

    function moveup() { //DONE

        Bulbasaur.image.src = "BUP.png";
        if (Bulbasaur.y > 1) {
            Bulbasaur.speedY = -1;
        }
        if (Scenery.y < 0) {
            Scenery.speedY = 1;
        }

    }

    function movedown() { //DONE
        Bulbasaur.image.src = "BDOWN.png"
        console.log("entered down method! current x is ", Bulbasaur.x);
        if (Bulbasaur.y < 240) {
            Bulbasaur.speedY = 1;
            console.log("entered if check #1. current x is ", Bulbasaur.x);
        }
        if (Scenery.y > -98) {
            Scenery.speedY = -1;
        }
    }

    function moveleft() { //DONE
        Bulbasaur.image.src = "BL.png";
        if (Bulbasaur.x > 1) {
            Bulbasaur.speedX = -1;
        }
        if (Scenery.x < 0) {
            Scenery.speedX = 1;
        }
    }

    function moveright() {
        Bulbasaur.image.src = "BR.png";
        if (Bulbasaur.x < 430) {//done
            Bulbasaur.speedX = 1;
        }
        if (Scenery.x > -270) {//done
            Scenery.speedX = -1;
        }
    }

    function clearmove() {
        Bulbasaur.speedX = 0;
        Bulbasaur.speedY = 0;
        Scenery.speedX = 0;
        Scenery.speedY = 0;
    }

    document.addEventListener('keydown', function (key) {
        if (key.keyCode == 38 || key.keyCode == 87) {
            moveup();
        } else if (key.keyCode == 37 || key.keyCode == 65) {
            moveleft();
        } else if (key.keyCode == 40 || key.keyCode == 83) {
            movedown();
        } else if (key.keyCode == 39 || key.keyCode == 68) {
            moveright();
        }
    });

    document.addEventListener('keyup', function (key) {
        clearmove();
    })

</script>
<!-- SOUNDTRACK -------------------------------------------->
<div id="audio" style="background:none; opacity:0.5; text-align:center;">
    &#9834;<br>
    <p><!-- Bulbasaur's attempt to not journey to the void
        <br/> -->
        <audio controls src="azalea.mp3" type="audio/mp3"></audio>
    </p>
</div>

<div id="namer">
    <form action="pkmnjump.php" method="get">
        <input type="text" name="name"/>
        <input type="submit" value="Name a new Bulbasaur"/>
    </form>
</div>

<?php
if (isset($_REQUEST['name'])) {
    ?>
    <div id="named"> This Bulbasaur is called <?= $_REQUEST['name'] ?>
    </div>
    <?php
}
?>

<div id="breadcrumb"><a href="tidyindex.php" style="color:#ffffff;">back to
        Pokédex</a></div>
</body>
</html>

