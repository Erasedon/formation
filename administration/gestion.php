<?php

include '../assets/include/config.php';

    if (isset($_GET['action']))
    {
        if ($_GET['action'] == 'formation')
        {
            ?>

            <button class="admin_ajouter_formation">Ajouter une formation</button>


            <table id="myTable2" class="display">
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
            <script src="../assets/js/datatable.js"></script>
            <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>

            <?php
        }
   
       
    
        if ($_GET['action'] == 'ajouter')
        {
            
            $message = "";
            $erreur = "";
            $valide = "";

            if (isset($_POST["titre"], $_POST["description"], $_POST["code_formation"], $_POST["duree"], $_POST["niveau_formation"], $_POST["condition_formation"], $_POST["metier_vise"], $_POST["frais_scolarite"], $_POST["lieu_formation"], $_POST["categories"])                
            && !empty($_POST["titre"]) && !empty($_POST["description"]) && !empty($_POST["code_formation"]) && !empty($_POST["duree"]) && !empty($_POST["niveau_formation"]) && !empty($_POST["condition_formation"]) && !empty($_POST["metier_vise"]) && !empty($_POST["frais_scolarite"]) && !empty($_POST["lieu_formation"]) && !empty($_POST["categories"]))
            {



                    // ici on insere la demande avec la lettre de motivation et plus bas on met le CV
                    $sqlajoutfor= "INSERT INTO `formation` (`titre_formation`,`description_formation`, `code_formation`,`condition_formation`,`metier_viser_formation`,`frais_scolarite_formation`,`lieu_formation`, `duree_formation`, `id_niveau`) 
                    VALUES (:titre_formation, :description_formation, :code_formation, :condition_formation, :metier_viser_formation, :frais_scolarite_formation, :lieu_formation, :duree_formation, :id_niveau)";
                    $requeteajoutfor = $db->prepare($sqlajoutfor);
                    $requeteajoutfor->execute(
                        array(
                            ":titre_formation" => $_POST['titre'],
                            ":description_formation" => $_POST['description'],
                            ":code_formation" => $_POST['code_formation'],
                            ":condition_formation" => $_POST['condition_formation'],
                            ":metier_viser_formation" => $_POST['metier_vise'],
                            ":frais_scolarite_formation" => $_POST['frais_scolarite'],
                            ":lieu_formation" => $_POST['lieu_formation'],
                            ":duree_formation" => $_POST['duree'],
                            ":id_niveau" =>$_POST['niveau_formation']
                        )
                    );
                    $dernier_id = $db->lastInsertId() ;

                    foreach ($_POST['categories'] as $cat)
                    {
                
                    $sqlajoutcat= "INSERT INTO `appartenir_cat` (`id_categories`,`id_formation`) 
                    VALUES (:id_categories, :id_formation)";
                    $requeteajoutcat = $db->prepare($sqlajoutcat);
                    $requeteajoutcat->execute(
                        array(
                            ":id_categories" => $cat,
                            ":id_formation" => $dernier_id
                        )
                    );

                    }
            }
            else {
                $erreur .= '<div class="message_erreur_formulaire_admin"> Veuillez remplir tous les champs</div>';
            }

            echo json_encode(array( 
                "message" => $message,
                "erreur" => $erreur
            ));

            $message .= ' <div class="message_erreur_formulaire_admin">       
            formation ajouté
            </div>';

        }


        if ($_GET['action'] == 'ajout_formation')
        {
           ?>

           <div class="titre_formulaire_admin">Ajouter une formation</div>
           
           <div class="message_erreur_formulaire_admin"> 
                </div>

           <div class="cadre_formulaire_admin">

                <form class="valider_formulaire" id="myForm">
                <div class="ligne_cadre_admin">
                    <div class="colonne_gauche_admin">Titre de la formation</div>
                    <div class="colonne_droite_admin"> <input type="text" name="titre" id="titre" placeholder="Titre formation"> </div>
                </div>

                <div class="ligne_cadre_admin">
                    <div class="colonne_gauche_admin">Description de la formation</div>
                    <div class="colonne_droite_admin"> <textarea name="description" id="description" cols="70" rows="5"></textarea></div>
                </div>

                <div class="ligne_cadre_admin">
                    <div class="colonne_gauche_admin">Code de la formation</div>
                    <div class="colonne_droite_admin"> <input type="text" name="code_formation" id="code_formation" pattern="\w{1,15}" placeholder="Code de la formation"> </div>
                </div>

                <div class="ligne_cadre_admin">
                    <div class="colonne_gauche_admin">Durée de la formation</div>
                    <div class="colonne_droite_admin"> <input type="text" placeholder="Durée de la formation" name="duree" id="duree">  </div>
                </div>

                <div class="ligne_cadre_admin">
                    <div class="colonne_gauche_admin">Niveau de la formation</div>
                    <div class="colonne_droite_admin"> 
                        <select name="niveau_formation" id="niveau_formation">
                            <option value=""></option>
                            <?php    
                                $sql_niveau = "SELECT * FROM niveau";
                                $requete_niveau = $db->prepare($sql_niveau);
                                $requete_niveau->execute();                        
                                while ($affiche_niveau = $requete_niveau->fetch())
                                {
                                    echo '<option value="'.$affiche_niveau['id_niveau'].' ">'.$affiche_niveau['titre_niveau'].'</option>';
                                }
                            ?>
                        
                        </select>
                  </div>
                </div>

                <div class="ligne_cadre_admin">
                    <div class="colonne_gauche_admin">Catégorie de la formation</div>
                    <div class="colonne_droite_admin"> 
                
                            <?php    
                                $sql_categories = "SELECT * FROM categories";
                                $requete_categories = $db->prepare($sql_categories);
                                $requete_categories->execute();                        
                                while ($affiche_categories = $requete_categories->fetch())
                                {
                                    echo '<input type="checkbox" name="categories[]" value="'.$affiche_categories['id_categories'].' ">'.$affiche_categories['titre_categories'].' ';
                                }
                            ?>
                  </div>
                </div>
                <div class="ligne_cadre_admin">
                    <div class="colonne_gauche_admin">Condition de la formation</div>
                    <div class="colonne_droite_admin"> <textarea name="condition_formation" id="condition_formation" cols="70" rows="5"></textarea> </div>
                </div>

                <div class="ligne_cadre_admin">
                    <div class="colonne_gauche_admin">Métier visé</div>
                    <div class="colonne_droite_admin"> <textarea name="metier_vise" id="metier_vise" cols="70" rows="5"></textarea> </div>
                </div>

                <div class="ligne_cadre_admin">
                    <div class="colonne_gauche_admin">Frais de scolarité</div>
                    <div class="colonne_droite_admin"> <textarea name="frais_scolarite" id="frais_scolarite" cols="70" rows="5"></textarea> </div>
                </div>

                
                <div class="ligne_cadre_admin">
                    <div class="colonne_gauche_admin">Lieu de la formation</div>
                    <div class="colonne_droite_admin"> <textarea name="lieu_formation" id="lieu_formation"  cols="70" rows="5"></textarea> </div>
                </div>

                

                <div class="ligne_cadre_admin">
                    <div class="colonne_gauche_admin"> <input type="submit" value="Ajouter la formation"> </div>
                </div>
                </form>

           </div>

           <?php 
        }


        if ($_GET['action'] == 'competences')
        {
            ?>

            <button class="admin_ajouter_competences">Ajouter une compétence</button>


            <br><br>


            ici le resultat du tableau competence

            <?php
        }

        if ($_GET['action'] == 'ajout_competence')
        {
            echo "on affiche le formulaire pour ajouter une competence";
        }


        if ($_GET['action'] == 'categories')
        {
            ?>

            <button class="admin_ajouter_categorie">Ajouter une categorie</button>


            <br><br>


            ici le resultat du tableau categorie

            <?php
        }

        if ($_GET['action'] == 'ajout_categorie')
        {
            echo "on affiche le formulaire pour ajouter une categorie";
        }



    }

?>
