<?php 

require ('inclureClasses.php');

$bddPDO = new PDO('mysql:host=localhost; dbname=espace_membre', 'root','root');
$bddPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$manager = new UtilisateursManager($bddPDO);

if(isset($_POST['nom'])){
    $utilisateur = new Utilisateurs(
        [
            'nom' =>$_POST['nom'],
            'prenom' => $_POST['prenom'],
            'tel' => $_POST['tel'],
            'mel' => $_POST['mel']
        ]

    );

    if ($utilisateur->isUserValide()){
        $manager->inserer($utilisateur);
        echo 'Utilisateur enregistré';
    } else {
        $erreurs = $utilisateur->getErreurs();
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Membre</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
</head>
<body>

        <h1 style="text-align: center;"> Inscription d'un membre </h1>

        <form action="inscription.php" method="POST" class="form-group">
        
            <label for="">Nom</label>
                <input type="text" name="nom" id="nom" class="form-control">
                <?php if(isset($erreurs) && in_array(Utilisateurs::NOM_INVALIDE,$erreurs)) echo 'Le nom est invalide <br>'; ?>
            <label for="">Prénom</label>
                <input type="text" name="prenom" id="prenom" class="form-control">
                <?php if(isset($erreurs) && in_array(Utilisateurs::PRENOM_INVALIDE,$erreurs)) echo 'Le prénom est invalide <br>'; ?>
            <label for="">Téléphone</label>
                <input type="text" name="tel" id="tel" class="form-control">

            <label for=""> Email </label>
                <input type="text" name="mel" id="mel" class="form-control">
                <?php if(isset($erreurs) && in_array(Utilisateurs::MEL_INVALIDE,$erreurs)) echo 'L\'adresse email est invalide <br>'; ?>
                <br>

            <input type="submit" value="Valider" class="btn btn-block btn-success">
        
        
        </form>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>