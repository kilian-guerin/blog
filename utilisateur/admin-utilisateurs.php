<?php
require ('../fonctions.php');

if(($_SESSION['perms'] == 1) && ($_SESSION['perms'] != 42) && ($_SESSION['perms'] != 1337)) { 
    header('Location: /blog/index.php');
} else {
    if(isset($_POST['submit'])) {
        header('Location: /blog/utilisateur/admin.php');
    }
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
    <main class="admin">
        <div class="container" id="forms">
            <form action="#" method="post" class="forms">
                <div class="box" id="top">
                    <h1>GÉRER LES UTILISATEURS</h1>
                </div>
                <div class="box" id="middle-fix">
                    <?php
                    $req = "SELECT * FROM `utilisateurs` ORDER BY `id_droits` DESC";
                    $stmt = $GLOBALS['PDO']->query($req);
                    $list_utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach($list_utilisateurs as $key => $value) {
                        if($value['id_droits'] == 1337) {
                            $role = "Admin";
                        } elseif ($value['id_droits'] == 42) {
                            $role = "Moderateur";
                        } elseif ($value['id_droits'] == 1) {
                            $role = "Utilisateur";
                        };

                        echo '<input type="submit" name="utilisateurs" id="btn-fix" autofocus value="' . $value['login'] . ' | ' . $role . '">';
                    }
                    ?>
                </div>
                <div class="box" id="bottom">
                    <input type="submit" name="submit" id="create" autofocus value="Revenir à la page admin">
                </div>
            </form>
        </div>
    </main>
</body>
</html>
<?php
}
?>