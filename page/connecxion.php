<?php
session_start();

$serveur = 'localhost';
$nomUtilisateur = 'root';
$motDePasse = 'Clement2203$';
$nomBaseDeDonnees = 'moduleconnecxion';

$bdd = new PDO("mysql:host=$serveur;dbname=$nomBaseDeDonnees;charset=utf8", $nomUtilisateur, $motDePasse);

if (isset($_POST["submitconnect"])){
    $logconnect = htmlspecialchars($_POST["loginconnect"]);
    $mdpconnect = sha1($_POST["passwordconnect"]);
    if (!empty($logconnect) AND !empty($logconnect)){
        $requser = $bdd -> prepare("SELECT * FROM utilisateurs WHERE login = ? AND password = ?");
        $requser -> execute(array($logconnect, $mdpconnect));
        $userexist = $requser->rowCount();
        if ($userexist == 1){
            $userinfos = $requser ->fetch();
            $_SESSION['id'] = $userinfos['id'];
            $_SESSION['login'] = $userinfos['login'];
            $_SESSION['prenom'] = $userinfos['prenom'];
            $_SESSION['nom'] = $userinfos['nom'];
            $_SESSION['password'] = $userinfos['password'];
            header("location: profil.php?id=".$_SESSION['id']);
        }
        else{
            $erreur = "mauvais Login ou password.";
        }
    }
    else{
        $erreur = "tout les chanps doivent etre remplie.";
    }
}

    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_connecxion.css" media="screen">

    <title>Connection</title>
</head>
<body>
    <div class="connec">
        <form method="post" action="">
            <table>
                <tr>
                    <td>
                        <label for="login">Login : </label>
                    </td>
                    <td>
                        <input type="text" id="loginconnect" name="loginconnect" placeholder="login">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="password">Password : </label>
                    </td>
                    <td>
                        <input type="text" id="passwordconnect" name="passwordconnect" placeholder="password">
                    </td>
                </tr>


            </table>
            <input type="submit" id="submitconnect" name="submitconnect" value="Connection">
        </form>
            <a href="inscription.php">pas de compte inscrit toi !!</a>
    <?php
        if(isset($erreur)){
            echo $erreur ;
        }
    ?>
</body>