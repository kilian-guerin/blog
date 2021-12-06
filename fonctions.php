<?php
require('config.php');

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
        $req = "SELECT * FROM `articles` WHERE `id`=" . $id . "";
        $stmt = $GLOBALS['PDO']->query($req);
        $list_articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insArticle(string $article, string $titre, int $id_utilisateur, int $id_categorie)
    {
        $req = "INSERT INTO `articles`(`article`, `titre`, `id_utilisateur`, `id_categorie`) VALUES (:article,:titre,:id_utilisateur,:id_categorie)";
        $stmt = $GLOBALS['PDO']->prepare($req);
        $stmt->execute([
            ':article' => $article,
            ':titre' => $titre,
            ':id_utilisateur' => $id_utilisateur,
            ':id_categorie' => $id_categorie,
        ]);
        $this->_Malert = 'Article crée';
        $this->_Talert = 1;
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
                        <a href="#main"><span class="tag tag-blue"><?php echo $list_articles[$i]['categorie'] ?></span></a>
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
                    <a href="../index.php">
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