<?php

session_start();
if(!isset($_SESSION["id"])){
    header("location:page-login-dashboard-frontend.php");
    exit;
  }

require '../assets/include/config.php';




?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/admin.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">
    
    <!--SCRIPT JQUERY -->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
  
    <!-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script> -->

    <title>Document</title>
</head>
<body>

<?php
include '../assets/include/config.php';
?>


    <div class="corps_admin">

        <div class="titre_admin"><a href="index.php">Administration</a></div>

        <div class="menu_admin">

            <a href="#" class="sous_menu_admin_formation">Gestion des formations</a> 
            <a href="#" class="sous_menu_admin_competences">Gestion des compétenences</a> 
            <a href="#" class="sous_menu_admin_categorie">Gestion des catégories</a> 
           
          <!-- Hassan a ajouté le butoon de Déconnexion ici -->
            <a href="page-logout-dashboard.php" class="">Déconnexion</a></li>

           


        </div>

        <div class="contenu_admin">

        <button class="admin_ajouter_formation">Ajouter une formation</button>

        <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th>Nom de la formation</th>
                        <th>Code de la formation</th>
                        <th>Durée de la formation</th>
                        <th>Catégorie de la formation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

  
                        $sql_formation = "SELECT * FROM formation";
                        $requete_formation = $db->prepare($sql_formation);
                        $requete_formation->execute();                        
                        while ($affiche_formation = $requete_formation->fetch())
                        {
                           echo '

                            <tr>
                                <td>'.$affiche_formation['titre_formation'].'</td>
                                <td>'.$affiche_formation['code_formation'].'</td>
                                <td>'.$affiche_formation['duree_formation'].' h</td>
                                <td>';
                                
                                $sql_categorie = "SELECT * FROM categories c, appartenir_cat ac
                                WHERE id_formation = :formation
                                AND c.id_categories=ac.id_categories";
                                $requete_categorie = $db->prepare($sql_categorie);
                                $requete_categorie->execute(array(
                                    ":formation" => $affiche_formation['id_formation']
                                ));                        
                                while ($affiche_categorie = $requete_categorie->fetch())
                                {
                                    echo ''.$affiche_categorie['titre_categories'].', ';     
                                    
                
                                }
                                
                                echo '</td>
                            </tr>
                           
                           ';
                        }


                    ?>
                </tbody>
            </table>
        </div>

        

    </div>

    <script src="../assets/js/admin.js"></script>
    <script src="../assets/js/datatable.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
    
</body>
</html>