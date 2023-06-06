<?php

$serveur = 'localhost';
$nomUtilisateur = 'root';
$motDePasse = 'Clement2203$';
$nomBaseDeDonnees = 'moduleconnecxion';

$bdd = new PDO("mysql:host=$serveur;dbname=$nomBaseDeDonnees;charset=utf8", $nomUtilisateur, $motDePasse);

if (isset($_POST['submit'])){
    $login = htmlspecialchars($_POST['login']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $nom = htmlspecialchars($_POST['nom']);
    $mdp = sha1($_POST['password']);
    $mdp2 = sha1($_POST['password2']);

    if (!empty($_POST['login']) AND !empty($_POST['prenom']) AND !empty($_POST['nom']) AND !empty($_POST['password']) AND !empty($_POST['password2'])){


        $loginlen = strlen($login);
        $prenomlen = strlen($prenom);
        $nomlen = strlen($nom);
        if($loginlen AND $prenomlen AND $nomlen <= 255){
            $reqlog = $bdd->prepare("SELECT * FROM utilisateurs WHERE login = ?");
            $reqlog->execute(array($login));
            $logexist = $reqlog->rowcount();
            if($logexist == 0){
                if($mdp == $mdp2){
                    $insertmbr = $bdd->prepare ("INSERT INTO utilisateurs(login, prenom, nom, password) VALUES(?, ?, ?, ?)");
                    $insertmbr->execute(array($login, $prenom, $nom, $mdp));
                    $erreur = "(not error) : user rentré dans bdd";
                }
                else{
                    $erreur = "le mot de passe n'est pas identique au mot de passe rentré!";
                }
            }
            else{
                $erreur = "login deja utiliser";
            }
        }
        else{
            $erreur = "le login le prenom et le nom doivent etre inferieur a 255 caractere";
        }
    }   
    else{
        $erreur = "tout les chant doivent etre remplie";
    }
}
    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_inscription.css" media="screen">

    <title>inscription</title>
</head>
<body>
    <div class="inscrip">
        <form method="post" action="">
            <table>
                <tr>
                    <td>
                        <label for="login">Login : </label>
                    </td>
                    <td>
                        <input type="text" id="login" name="login" placeholder="login">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="prenom">Prenom : </label>
                    </td>
                    <td>
                        <input type="text" id="prenom" name="prenom" placeholder="prenom">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="nom">Nom : </label>
                    </td>
                    <td>
                        <input type="text" id="nom" name="nom" placeholder="nom">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="password">Password : </label>
                    </td>
                    <td>
                        <input type="text" id="password" name="password" placeholder="password">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="password">Confime Password : </label>
                    </td>
                    <td>
                        <input type="text" id="password2" name="password2" placeholder="confime password">
                    </td>
                </tr>

            </table>
            <input type="submit" id="submit" name="submit" value="Submit">
        </form>
        <a href="connecxion.php">deja inscrit ? connect toi !!</a>

    <?php
        if(isset($erreur)){
            echo $erreur ;
        }
    ?>
</body>