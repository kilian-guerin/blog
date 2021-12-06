<?php
require ('../fonctions.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
$article = new Article();
if (isset($_POST['submit'])){
    $article->insArticle($_POST['desc-article'],$_POST['title-article'],$_SESSION['id'],$_POST['choose-article']);
} elseif(isset($_POST['back'])) {
    header('Location: /blog/index.php');
}
?>

<!--    HEAD   -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $GLOBALS['name'] . ' - Créer un article' ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
    <main class="create-article">
        <div class="container" id="forms">
            <form action="#" method="post" class="forms">
            <?php if (isset($_POST['submit'])) {$article->alerts(); } ?>

                <div class="box" id="top">
                    <h1>CRÉER VOTRE ARTICLE</h1><br>
                </div>
                <div class="box" id="middle">
                    <input type="text" name="title-article" placeholder="Titre de l'article"><br>
                    <select name="choose-article">
                    <?php
                        $req = "SELECT * FROM `categories`";
                        $stmt = $GLOBALS['PDO']->query($req);
                        $list_articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        for ($i = 0; $i < count($list_articles); $i++) { ?>
                            <option value="<?php echo $list_articles[$i]['id'] ?>"><?php echo $list_articles[$i]['nom'] ?></option> <?php 
                        } ?>
                    </select>
                    <input type="text" name="icon-article" placeholder="Icon de l'article (Font Awesome uniquement)"><br>
                    <textarea name="desc-article" placeholder="Écrivez votre article"></textarea>
                </div>
                <div class="box" id="bottom">
                    <input type="submit" name="submit" class="btn green" autofocus value="Créer l'article">
                    <input type="submit" name="back" class="btn orange" autofocus value="Revenir à la page principale">
                </div>
            </form>
        </div>
    </main>
</body>
</html>