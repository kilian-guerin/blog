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
    <title><?php echo $GLOBALS['name'] . ' - Admin' ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
    <main class="login" style="overflow: hidden;">
        <div class="container" id="forms">
            <form action="#" method="post" class="forms">
                <div class="box" id="top">
                    <?php
                    //if($_SESSION) {
                        //echo '<h1>MODIFIER VOTRE PROFIL</h1>';
                    //} else {
                        //echo '<h1>MODIFICATION DU PROFILE DE name</h1>';
                    //}
                    ?>
                </div>
                <?php if (isset($_POST['submit'])) {
                    $connexion->alerts();
                } ?>
                <div class="box" id="middle">
                    <input type="text" name="email" placeholder="Adresse courriel"><br>
                    <input type="text" name="login" placeholder="Nom d'utilisateur"><br>
                    <input type="password" name="password" placeholder="Mot de passe"><br>
                    <input type="password" name="password_confirmation" placeholder="Confirmer le Mot de passe">
                </div>
                <div class="box" id="bottom">
                    <input type="submit" name="submit" class="btn green" value="Modifier les informations">
                </div>
                <div class="box" id="register">
                    <hr>
                    </hr>
                    <span id="text">Ou</span>
                    <hr>
                    </hr>
                </div>
                <div class="box" id="bottom">
                    <input type="submit" name="login-button" class="btn blue" value="Revenir à la page principale">
                </div>
            </form>
        </div>
    </main>
    <script src="https://kit.fontawesome.com/225d5fd287.js" crossorigin="anonymous"></script>
</body>

</html>