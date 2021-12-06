<?php
require('config.php');
$PATH = '';


class Module_Connexion
{
    private $_email;
    private $_mdp;
    private $_Malert;
    private $_Talert;


    function __construct(string $email, string $mdp)
    {
        $this->_email = $email;
        $this->_mdp = $mdp;
    }


    private function verif_exist_util()
    {
        $req = "SELECT `email` FROM `utilisateurs` WHERE email='$this->_email'";
        $stmt = $GLOBALS['PDO']->query($req);
        $list_util = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (isset($list_util[0]['email']) && $list_util[0]['email'] != "") {
            $verifexist = TRUE;
            return $verifexist;
        } else {
            $verifexist = FALSE;
            return $verifexist;
        }
    }

    private function verif_mdp()
    {
        $req = "SELECT `email`, `password` FROM `utilisateurs` WHERE email='$this->_email'";
        $stmt = $GLOBALS['PDO']->query($req);
        $list_util_mdp = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (password_verify($this->_mdp, $list_util_mdp[0]['password'])) {
            $verif = TRUE;
            return $verif;
        } else {
            $verif = FALSE;
            return $verif;
        }
    }


    public function alerts()
    {
        if ($this->_Talert == 1) {
            echo "<div class='succes'>" . $this->_Malert . "</div>";
        } else {
            echo "<div class='error'>" . $this->_Malert . "</div>";
        }
    }

    public function connexion()
    {
        if ($this->_email != "") {
            if ($this->verif_exist_util()) {
                if ($this->verif_mdp()) {
                    $this->_Malert = 'Connexion réussie';
                    $this->_Talert = 1;

                    $req = "SELECT * FROM `utilisateurs` WHERE email='$this->_email'";
                    $res = $GLOBALS['PDO']->query($req);
                    $info_util = $res->fetchAll(PDO::FETCH_ASSOC);

                    $_SESSION['email'] = $info_util[0]['email'];
                    $_SESSION['id'] = $info_util[0]['id'];
                    $_SESSION['login'] = $info_util[0]['login'];
                    $_SESSION['perms'] = $info_util[0]['id_droits'];

                    header('refresh:2;url=/blog/index.php');
                } else {
                    $this->_Malert = 'Mot de passe erroné';
                    $this->_Talert = 0;
                }
            } else {
                $this->_Malert = "L'utilisateur " . $this->_email . " n'existe pas";
                $this->_Talert = 0;
            }
        } else {
            $this->_Malert = 'Veuillez remplir les champs';
            $this->_Talert = 0;
        }
    }
}

class Module_Inscription
{

    private $_login;
    private $_password;
    private $_password_verif;
    private $_email;

    function __construct(string $login, string $password, string $password_verif, string $email, int $droit = 1)
    {

        $this->_login = $login;
        $this->_password = $password;
        $this->_password_verif = $password_verif;
        $this->_email = $email;
        $this->_droit = $droit;
    }

    private function verif_mdp_verif()
    {
        if ($this->_password === $this->_password_verif && $this->_password != "") {
            return TRUE;
        }
    }

    private function verif_util()
    {

        $req = "SELECT `login` FROM `utilisateurs` WHERE login='$this->_login'";
        $stmt = $GLOBALS['PDO']->query($req);
        $list_util = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($list_util[0]['login'] == $this->_login) {
            $verifexist = TRUE;
            return $verifexist;
        } else {
            $verifexist = FALSE;
            return $verifexist;
        }
    }

    private function verif_mail()
    {

        $req = "SELECT `email` FROM `utilisateurs` WHERE email='$this->_email'";
        $stmt = $GLOBALS['PDO']->query($req);
        $list_mail = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($list_mail[0]['email'] == $this->_email) {
            $verifexist = TRUE;
            return $verifexist;
        } else {
            $verifexist = FALSE;
            return $verifexist;
        }
    }
    public function alerts()
    {
        if ($this->_Talert == 1) {
            echo "<div class='succes'>" . $this->_Malert . "</div>";
        } else {
            echo "<div class='error'>" . $this->_Malert . "</div>";
        }
    }

    public function ins_util()
    {
        if ($this->_email == "") {
            $this->_Malert = 'Veuillez remplir votre email';
        } else {
            if ($this->_password == "" && $this->_password_verif == "") {
                $this->_Malert = 'Veuillez remplir le mot de passe';
            } else {
                if ($this->verif_mdp_verif()) {
                    if ($this->verif_util() == FALSE) {
                        if (filter_var($this->_email, FILTER_VALIDATE_EMAIL)) {
                            if ($this->verif_mail() == FALSE) {

                                $req = 'INSERT INTO `utilisateurs`(`login`, `password`, `email`, `id_droits`) VALUES (:login, :password, :email, :id)';
                                $stmt = $GLOBALS['PDO']->prepare($req);
                                $stmt->execute([
                                    ':login' => $this->_login,
                                    ':password' => password_hash($this->_password, PASSWORD_DEFAULT),
                                    ':email' => $this->_email,
                                    ':id' => $this->_id = 1,
                                ]);
                                $this->_Malert = 'Utilisateur crée';
                                $this->_Talert = 1;
                                header('Refresh:2 ; URL=/blog/index.php');
                            } else {
                                $this->_Malert = $this->_email . " existe déjà";
                            }
                        } else {
                            $this->_Malert = $this->_email . " n'est pas une adresse valide";
                        }
                    } else {
                        $this->_Malert = "L'utilisateur " . $this->_login . " existe déjà";
                    }
                } else {
                    $this->_Malert = 'Les mots de passes ne sonts pas identiques';
                }
            }
        }
    }
}

class Article
{

    public $_count;
    public $_countnext;
    private $_Malert;
    private $_Talert;
    // private $_idcat;
    // private $_id;

    // function __construct(){

    //     // $this->_contenu = $contenu;
    //     // $this->_titre = $titre;
    //     // $this->_idutil = $idutil;
    //     // $this->_idcat = $idcat;
    //     // $this->_id = $id;

    // }

    public function alerts()
    {
        if ($this->_Talert == 1) {
            echo "<div class='succes'>" . $this->_Malert . "</div>";
        } else {
            echo "<div class='error'>" . $this->_Malert . "</div>";
        }
    }


    public function getArticleParId(int $id)
    {
        $req = "SELECT `articles`.`id`, `articles`.`article`,`articles`.`titre`,`articles`.`date`, `categories`.`nom` AS 'categorie', `utilisateurs`.`login`  FROM `articles` INNER JOIN `categories` ON `articles`.`id_categorie` = `categories`.`id` INNER JOIN `utilisateurs` ON `articles`.`id_utilisateur` = `utilisateurs`.`id` WHERE `articles`.`id` = $id";
        $stmt = $GLOBALS['PDO']->query($req);
        $article = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
        <main class="view-article">
            <div class="container-top">
                <div class="box">
                    <h2><?php echo $article[0]['titre']; ?></h2>
                </div>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#fff" fill-opacity="1" d="M0,32L34.3,48C68.6,64,137,96,206,112C274.3,128,343,128,411,112C480,96,549,64,617,90.7C685.7,117,754,203,823,208C891.4,213,960,139,1029,128C1097.1,117,1166,171,1234,160C1302.9,149,1371,75,1406,37.3L1440,0L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
            </svg>
        </main>

        <section class="view-article">
            <div class="container">
                <h2 id="title"><?php echo $article[0]['titre'] ?></h2>
                <h4 id="sous-title">Crée par <?php echo $article[0]['login']; ?> le <?php echo $article[0]['date']; ?></h4>
            </div>
            <div class="container-2">
                <span>
                <?php echo $article[0]['article']; ?>
                </span>
            </div>
        </section>
        <?php
    }

    public function insArticle(string $article, string $titre, int $id_utilisateur, int $id_categorie)
    {
        if ($article == "") {
            $this->_Malert = 'Veuillez remplir le champ "Texte"';
        } elseif ($titre == "") {
            $this->_Malert = 'Veuillez remplir le champ "Titre"';
        } else {
            $req = "INSERT INTO `articles`(`article`, `titre`, `id_utilisateur`, `id_categorie`) VALUES (:article,:titre,:id_utilisateur,:id_categorie)";
            $stmt = $GLOBALS['PDO']->prepare($req);
            $stmt->execute([
                ':article' => $article,
                ':titre' => $titre,
                ':id_utilisateur' => $id_utilisateur,
                ':id_categorie' => $id_categorie,
            ]);
            $this->_Malert = 'Articles crée';
            $this->_Talert = 1;
        }
    }

    public function countnext(int $limit, int $OFFSET = 0, string $type, string $categorie)
    {
        if ($categorie == 'tout') {
            $req = "SELECT `articles`.`id`, `articles`.`article`,`articles`.`titre`,`articles`.`date`, `categories`.`nom` AS 'categorie', `utilisateurs`.`login`  FROM `articles` INNER JOIN `categories` ON `articles`.`id_categorie` = `categories`.`id` INNER JOIN `utilisateurs` ON `articles`.`id_utilisateur` = `utilisateurs`.`id` LIMIT $limit OFFSET $OFFSET";
        } else {
            $req = "SELECT `articles`.`id`, `articles`.`article`,`articles`.`titre`,`articles`.`date`, `categories`.`nom` AS 'categorie', `utilisateurs`.`login`  FROM `articles` INNER JOIN `categories` ON `articles`.`id_categorie` = `categories`.`id` INNER JOIN `utilisateurs` ON `articles`.`id_utilisateur` = `utilisateurs`.`id` WHERE `categories`.`nom`='$categorie' LIMIT $limit OFFSET $OFFSET";
        }
        $stmt = $GLOBALS['PDO']->query($req);
        $list_articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->_countnext = count($list_articles);
    }

    public function getArticleLimite(int $limit, int $OFFSET = 0, string $type, string $categorie)
    {
        if ($categorie == 'tout') {
            $req = "SELECT `articles`.`id`, `articles`.`article`,`articles`.`titre`,`articles`.`date`, `categories`.`nom` AS 'categorie', `utilisateurs`.`login`  FROM `articles` INNER JOIN `categories` ON `articles`.`id_categorie` = `categories`.`id` INNER JOIN `utilisateurs` ON `articles`.`id_utilisateur` = `utilisateurs`.`id` LIMIT $limit OFFSET $OFFSET";
        } else {
            $req = "SELECT `articles`.`id`, `articles`.`article`,`articles`.`titre`,`articles`.`date`, `categories`.`nom` AS 'categorie', `utilisateurs`.`login`  FROM `articles` INNER JOIN `categories` ON `articles`.`id_categorie` = `categories`.`id` INNER JOIN `utilisateurs` ON `articles`.`id_utilisateur` = `utilisateurs`.`id` WHERE `categories`.`nom`='$categorie' LIMIT $limit OFFSET $OFFSET";
        }
        $stmt = $GLOBALS['PDO']->query($req);
        $list_articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->_count = count($list_articles);
        if ($type == 'card') {
            for ($i = 0; $i < count($list_articles); $i++) { ?>
                <div class="card">
                    <div class="card-header">
                        <img src="https://aitechnologiesng.com/wp-content/uploads/2021/01/Software-Development-Training-in-Abuja1-1024x768.jpg" alt="city" />
                    </div>
                    <div class="card-body">
                        <a href="/blog/article/articles.php?categorie=<?= $list_articles[$i]['categorie']?>"><span class="tag tag-blue"><?php echo $list_articles[$i]['categorie'] ?></span></a>
                        <h2>
                            <?php echo $list_articles[$i]['titre'] ?>
                        </h2>
                        <p>
                            <?php echo substr($list_articles[$i]['article'], 0, 100) . "..." ?>
                        </p>
                        <div class="user">
                            <img src="https://studyinbaltics.ee/wp-content/uploads/2020/03/3799Ffxy.jpg" alt="user" />
                            <div class="user-info">
                                <h5><?php echo $list_articles[$i]['login'] ?></h5>
                                <small><?php echo $list_articles[$i]['date'] ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
        } elseif ($type == 'ligne') {
            for ($i = 0; $i < count($list_articles); $i++) {  ?>
                <div class="article-card">
                    <a href="/blog/article/article.php?id=<?php echo $list_articles[$i]['id'] ?>">
                        <div class="box" id="right">
                            <span class="fa-stack fa-2x">
                                <i class="fas fa-chevron-left fa-stack-2x"></i>
                                <i class="fas fa-ban fa-stack-2x" style="color:Tomato"></i>
                            </span>
                        </div>
                        <div class="box" id="left">
                            <h2> <?php echo $list_articles[$i]['titre'] ?></h2>
                            <span>
                                <?php echo substr($list_articles[$i]['article'], 0, 100) . "..." ?>
                            </span>
                            <div class="box" id="bottom">
                                <h4>Posté par <?php echo $list_articles[$i]['login'] . ' le ' . $list_articles[$i]['date'] ?></h4>
                            </div>
                        </div>
                    </a>
                </div>
<?php
            }
        }
    }
}

?>

<style>
    .succes {
        background-color: green;
        font-weight: bold;
        font-family: "Comfortaa";
        width: 90%;
        text-align: center;
        padding: 10px;
        animation: 1s ease-in-out alertSuccess forwards;
    }

    .error {
        background-color: red;
        font-weight: bold;
        font-family: "Comfortaa";
        width: 90%;
        text-align: center;
        padding: 10px;
        animation: 1s ease-in-out alertError forwards;
    }

    @keyframes alertSuccess {
        from {
            background-color: transparent;
        }

        to {
            background-color: green;
            color: white
        }
    }

    @keyframes alertError {
        from {
            background-color: transparent;
        }

        to {
            background-color: red;
            color: white
        }
    }
</style>