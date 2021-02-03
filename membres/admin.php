<?php 

require ('inclureClasses.php');

$bddPDO = new PDO('mysql:host=localhost; dbname=espace_membre', 'root','root');
$bddPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$manager = new UtilisateursManager($bddPDO);

if (isset($_GET['modifier'])){
    $utilisateur = $manager->getUtilisateur((int) $_GET['modifier']);
}

if (isset($_POST['nom'])){
    $utilisateur = new Utilisateurs(
        [
            'nom' => $_POST['nom'],
            'prenom' => $_POST['prenom'],
            'tel' => $_POST['tel'],
            'mel' => $_POST['mel']
        ]
        );
    
    if (isset($_POST['id'])){
        $utilisateur->setId($_POST['id']);
    }

    if ($utilisateur->isUserValide()){
        $manager->mettreAjour($utilisateur);
        $message = 'Utilisateur bien modifié';
    } else {
        $erreurs = $utilisateur->getErreurs();
    }


}
if (isset($_GET['supprimer'])){
    $manager->supprimer((int) $_GET['supprimer']);
    $message = 'Utilisateur bien supprimé';
} 


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <style type="text/css">
    table,td {
        border: 1px solid black;
    }

    table {
        margin:auto;
        text-align: center;
        border-collapse: collapse;
    }

    td {
        padding: 3px;
    }
    </style>

</head>
<body>
    <p><a href="../index.php">Accéder à l'accueil du site</a></p>


    <h1 style="text-align: center;"> Modification d'un membre </h1>

        <form action="admin.php" method="POST" class="form-group">
        
            <label for="">Nom</label>
                <input type="text" name="nom" id="nom" class="form-control" value="<?php if(isset($utilisateur)) echo $utilisateur->getNom();?>">
                <?php if(isset($erreurs) && in_array(Utilisateurs::NOM_INVALIDE,$erreurs)) echo 'Le nom est invalide <br>'; ?>
            <label for="">Prénom</label>
                <input type="text" name="prenom" id="prenom" class="form-control" value="<?php if(isset($utilisateur)) echo $utilisateur->getPrenom();?>">
                <?php if(isset($erreurs) && in_array(Utilisateurs::PRENOM_INVALIDE,$erreurs)) echo 'Le prénom est invalide <br>'; ?>
            <label for="">Téléphone</label>
                <input type="text" name="tel" id="tel" class="form-control" value="<?php if(isset($utilisateur)) echo $utilisateur->getTel();?>">

            <label for=""> Email </label>
                <input type="text" name="mel" id="mel" class="form-control" value="<?php if(isset($utilisateur)) echo $utilisateur->getMel();?>">
                <?php if(isset($erreurs) && in_array(Utilisateurs::MEL_INVALIDE,$erreurs)) echo 'L\'adresse email est invalide <br>'; ?>
                <br>

                <?php  if(isset($utilisateur)){
                   ?>
                    <input type="hidden" name="id" value="<?=$utilisateur->getId() ?>">
                <?php
                }
                ?>

            <input type="submit" value="Modifier" class="btn btn-block btn-success">

            <?php 
            
            if(isset($message)){
                echo $message;
            }
            
            
            ?>
        
        
        </form>

    <table>
        <tr>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Téléphone</th>
            <th>Adresse Email</th>
            <th>Modifier le membre</th>
            <th>Supprimer le membre</th>
        </tr>

        <?php 
        foreach ($manager->getListeUtilisateurs() as $utilisateur){
            echo '<tr>
                        <td>'.$utilisateur->getNom().'</td>
                        <td>'.$utilisateur->getPrenom().'</td>              
                        <td>'.$utilisateur->getTel().'</td>
                        <td>'.$utilisateur->getMel().'</td>
                        <td> <a href="?modifier='.$utilisateur->getId().'"> Modifier </a></td>
                        <td> <a href="?supprimer='.$utilisateur->getId().'"> Supprimer </a></td>
                </tr>';
        }
        ?>
    
    
    </table>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>