<?php
require('../fonctions.php');
?>

<!--    HEAD   -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $GLOBALS['name'] . ' - Articles' ?></title>
    <script src="https://kit.fontawesome.com/68c14f6685.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
    <!--    Header   -->
    <?php
    require('../header.php');
    ?>

    <main class="home">
        <div class="container-top">
            <div class="box">
                <h2><?php echo $GLOBALS['name'] ?></h2>
            </div>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#fff" fill-opacity="1" d="M0,32L34.3,48C68.6,64,137,96,206,112C274.3,128,343,128,411,112C480,96,549,64,617,90.7C685.7,117,754,203,823,208C891.4,213,960,139,1029,128C1097.1,117,1166,171,1234,160C1302.9,149,1371,75,1406,37.3L1440,0L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
        </svg>
    </main>

    <section class="container" id="articles">
        <div class="container-1">
            <h2 id="article-title">Les articles publiés</h2>
            <h4 id="article-sous-title">Cliquer sur l'article pour le voir</h4>
        </div>
        <!--    Generation Card   -->
        <div class="articles">
            <div class="article-card">
                <a href="../index.php">
                    <div class="box" id="right">
                    <span class="fa-stack fa-2x">
                        <i class="fas fa-chevron-left fa-stack-2x"></i>
                        <i class="fas fa-ban fa-stack-2x" style="color:Tomato"></i>
                    </span>
                    </div>
                    <div class="box" id="left">
                        <h2>Title</h2>
                        <span>
                            Ceci est un article
                        </span>
                        <div class="box" id="bottom">
                            <h4>Posté par Lucien le 2021/06/03 - 12:19:43</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="article-card">
                <a href="../index.php">

                    <div class="box" id="right">
                        <i class="fab fa-apple fa-4x"></i>
                    </div>
                    <div class="box" id="left">
                        <h2>Title</h2>
                        <span>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                            et dolore magna aliqua. Id nibh tortor id aliquet lectus proin nibh nisl condimentum. A diam
                            sollicitudin tempor id eu nisl. Gravida in fermentum et sollicitudin ac orci phasellus egestas tellus...
                        </span>
                        <div class="box" id="bottom">
                            <h4>Posté par Lucien le 2021/06/03 - 12:19:43</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="article-card">
                <a href="../index.php">
                    <div class="box" id="right">
                        <i class="fas fa-adjust fa-4x"></i>
                    </div>
                    <div class="box" id="left">
                        <h2>Title</h2>
                        <span>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                            et dolore magna aliqua. Id nibh tortor id aliquet lectus proin nibh nisl condimentum. A diam
                            sollicitudin tempor id eu nisl. Gravida in fermentum et sollicitudin ac orci phasellus egestas tellus...
                        </span>
                        <div class="box" id="bottom">
                            <h4>Posté par Lucien le 2021/06/03 - 12:19:43</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="article-card">
                <a href="../index.php">

                    <div class="box" id="right">
                        <i class="fab fa-dev fa-4x"></i>
                    </div>
                    <div class="box" id="left">
                        <h2>Title</h2>
                        <span>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                            et dolore magna aliqua. Id nibh tortor id aliquet lectus proin nibh nisl condimentum. A diam
                            sollicitudin tempor id eu nisl. Gravida in fermentum et sollicitudin ac orci phasellus egestas tellus...
                        </span>
                        <div class="box" id="bottom">
                            <h4>Posté par Lucien le 2021/06/03 - 12:19:43</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="article-card">
                <a href="../index.php">
                    <div class="box" id="right">
                        <i class="fab fa-dev fa-4x"></i>
                    </div>
                    <div class="box" id="left">
                        <h2>Title</h2>
                        <span>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                            et dolore magna aliqua. Id nibh tortor id aliquet lectus proin nibh nisl condimentum. A diam
                            sollicitudin tempor id eu nisl. Gravida in fermentum et sollicitudin ac orci phasellus egestas tellus...
                        </span>
                        <div class="box" id="bottom">
                            <h4>Posté par Lucien le 2021/06/03 - 12:19:43</h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="pagination">
            <div class="" id="left">
                <a href="">
                    <i class="fas fa-chevron-left fa-4x"></i>
                </a>
            </div>
            <div class="" id="right">
                <a href="">
                    <i class="fas fa-chevron-right fa-4x"></i>
                </a>
            </div>
        </div>
        <!--   Fin Generation Card   -->
    </section>

    <?php
    require('../footer.php');
    ?>
</body>

</html>