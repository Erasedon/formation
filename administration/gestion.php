<?php
// session du page login dashboard
session_start();
if(!isset($_SESSION["id"])){
    header("location:page-login-dashboard-frontend.php");
    exit;
  }




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
                        <th>Action</th>
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
                                <td> <a href="#" class="sous_menu_admin_formation_modifier" data-value="'.$affiche_formation['id_formation'].'"><i class="fa-solid fa-pen jaune"></i></a> / 
                                <a href="#" class="sous_menu_admin_formation_supprimer" data-value="'.$affiche_formation['id_formation'].'"><i class="fa-solid fa-trash rouge"></i></a>
                                 </td>
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

                    foreach ($_POST['type_formation'] as $type_form)
                    {
                
                    $sqlajouttype= "INSERT INTO `effectuer_type_formation` (`id_type_formation`,`id_formation`) 
                    VALUES (:id_type_formation, :id_formation)";
                    $requeteajouttype = $db->prepare($sqlajouttype);
                    $requeteajouttype->execute(
                        array(
                            ":id_type_formation" => $type_form,
                            ":id_formation" => $dernier_id
                        )
                    );

                    }
            }
            else {
                $erreur .= '<div class="message_erreur_formulaire_admin"> Veuillez remplir tous les champs</div>';
            }

            $message .= ' <div class="message_erreur_formulaire_admin">       
            formation ajoutée
            </div>';

            echo json_encode(array( 
                "message" => $message,
                "erreur" => $erreur
            ));

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
                    <div class="colonne_droite_admin"> <textarea name="description" id="description" cols="70" rows="5" placeholder="Description de la formation"></textarea></div>
                </div>

                <div class="ligne_cadre_admin">
                    <div class="colonne_gauche_admin">Code de la formation</div>
                    <div class="colonne_droite_admin"> <input type="text" name="code_formation" id="code_formation" placeholder="Code de la formation"> </div>
                </div>

                <div class="ligne_cadre_admin">
                    <div class="colonne_gauche_admin">Durée de la formation</div>
                    <div class="colonne_droite_admin"> <input type="text" placeholder="Durée de la formation" name="duree" id="duree">  </div>
                </div>

                <div class="ligne_cadre_admin">
                    <div class="colonne_gauche_admin">Type de la formation</div>
                    <div class="colonne_droite_admin"> 
                            <?php                  
                                $sql_type_formation = "SELECT * FROM type_formation";
                                $requete_type_formation = $db->prepare($sql_type_formation);
                                $requete_type_formation->execute();                        
                                while ($affiche_type_formation = $requete_type_formation->fetch())
                                {
                                    echo '<input type="checkbox" name="type_formation[]" value="'.$affiche_type_formation['id_type_formation'].' ">'.$affiche_type_formation['titre_type_formation'].' ';
                                }
                            ?>      
                  </div>
                </div>

                <div class="ligne_cadre_admin">
                    <div class="colonne_gauche_admin">Niveau de la formation</div>
                    <div class="colonne_droite_admin"> 
                        <select name="niveau_formation" id="niveau_formation">
                            <option value="">Sélectionner le niveau de la formation</option>
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
                    <div class="colonne_droite_admin"> <textarea name="condition_formation" id="condition_formation" cols="70" rows="5" placeholder="Conditions de la formation"></textarea> </div>
                </div>

                <div class="ligne_cadre_admin">
                    <div class="colonne_gauche_admin">Métier visé</div>
                    <div class="colonne_droite_admin"> <textarea name="metier_vise" id="metier_vise" cols="70" rows="5" placeholder="Métier visé"></textarea> </div>
                </div>

                <div class="ligne_cadre_admin">
                    <div class="colonne_gauche_admin">Frais de scolarité</div>
                    <div class="colonne_droite_admin"> <textarea name="frais_scolarite" id="frais_scolarite" cols="70" rows="5" placeholder="Frais de scolarité de la formation"></textarea> </div>
                </div>

                
                <div class="ligne_cadre_admin">
                    <div class="colonne_gauche_admin">Lieu de la formation</div>
                    <div class="colonne_droite_admin"> <textarea name="lieu_formation" id="lieu_formation"  cols="70" rows="5" placeholder="Lieu de la formation"></textarea> </div>
                </div>

                

                <div class="ligne_cadre_admin">
                    <div class="colonne_gauche_admin"> <input type="submit" value="Ajouter la formation"> </div>
                </div>
                </form>

           </div>

           <?php 
        }

        if ($_GET['action'] == 'modifier_formation')
        {

            $sql_info_formation = "SELECT * FROM formation WHERE id_formation = :id_form";
            $requete_info_formation = $db->prepare($sql_info_formation);
            $requete_info_formation->execute(array(
                ":id_form" => $_POST['id_form']
            ));                        
            $affiche_info_formation = $requete_info_formation->fetch();
            

           ?>

           <div class="titre_formulaire_admin">Modifier la formation <br> <?php echo $affiche_info_formation['titre_formation'];
           
           $sql_information_for = "SELECT * FROM formation WHERE id_formation = :id_form";
           $stmt_information_for= $db->prepare($sql_information_for);
           $stmt_information_for->execute(array(
               
               ":id_form" => $_POST["id_form"]
           ));           
           $affiche_information_for = $stmt_information_for->fetch();
           
           ?></div>
           
           <div class="message_erreur_formulaire_admin"> 
                </div>

           <div class="cadre_formulaire_admin">

                <form class="valider_formulaire_modif" id="myForm_modif">

                <input type="hidden" name="id_form" id="id_form" value="<?= $affiche_information_for['id_formation']?>"> 
                
                <div class="ligne_cadre_admin">
                    <div class="colonne_gauche_admin">Titre de la formation</div>
                    <div class="colonne_droite_admin"> <input type="text" size="50" name="titre" id="titre" value="<?= $affiche_information_for['titre_formation']?>"> </div>
                </div>

                <div class="ligne_cadre_admin">
                    <div class="colonne_gauche_admin">Description de la formation</div>
                    <div class="colonne_droite_admin"> <textarea name="description" id="description" cols="70" rows="5"><?= $affiche_information_for['description_formation']?></textarea></div>
                </div>

                <div class="ligne_cadre_admin">
                    <div class="colonne_gauche_admin">Code de la formation</div>
                    <div class="colonne_droite_admin"> <input type="text" name="code_formation" id="code_formation" placeholder="Code de la formation" value="<?= $affiche_information_for['code_formation']?>"> </div>
                </div>

                <div class="ligne_cadre_admin">
                    <div class="colonne_gauche_admin">Durée de la formation</div>
                    <div class="colonne_droite_admin"> <input type="text" placeholder="Durée de la formation" name="duree" id="duree" value="<?= $affiche_information_for['duree_formation']?>">  </div>
                </div>

                <div class="ligne_cadre_admin">
                    <div class="colonne_gauche_admin">Type de la formation</div>
                    <div class="colonne_droite_admin"> 
                            <?php    
                                $sql_type_formation = "SELECT * FROM type_formation";
                                $requete_type_formation = $db->prepare($sql_type_formation);
                                $requete_type_formation->execute();                        
                                while ($affiche_type_formation = $requete_type_formation->fetch())
                                {

                                     echo '<input type="checkbox" name="type_formation[]" value="'.$affiche_type_formation['id_type_formation'].'"';


                                    $sql_categories_form = "SELECT * FROM effectuer_type_formation WHERE id_formation = :id_form AND id_type_formation = :id_type_form";
                                    $requete_categories_form = $db->prepare($sql_categories_form);
                                    $requete_categories_form->execute(array(
                                        ":id_form" => $_POST['id_form'],
                                        ":id_type_form" => $affiche_type_formation['id_type_formation']
                                    ));                        
                                    $affiche_categories_form = $requete_categories_form->rowCount();
                                                                   

                                        if ($affiche_categories_form == 1){echo 'checked="yes">';} else {echo '>';}

                                    echo $affiche_type_formation['titre_type_formation'];
                                                              
                                }
                            ?>
                    </div>
                </div>
                

                <div class="ligne_cadre_admin">
                    <div class="colonne_gauche_admin">Niveau de la formation</div>
                    <div class="colonne_droite_admin"> 
                        <select name="niveau_formation" id="niveau_formation">
                            <?php    
                                $sql_niveau = "SELECT * FROM niveau";
                                $requete_niveau = $db->prepare($sql_niveau);
                                $requete_niveau->execute();                        
                                while ($affiche_niveau = $requete_niveau->fetch())
                                {

                                    if ($affiche_niveau['id_niveau'] == $affiche_information_for['id_niveau']) {$selected = 'selected';} else {$selected = '';}

                                    echo '<option value="'.$affiche_niveau['id_niveau'].'" '.$selected.'>'.$affiche_niveau['titre_niveau'].'</option>';
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

                                     echo '<input type="checkbox" name="categories[]" value="'.$affiche_categories['id_categories'].'"';


                                    $sql_categories_form = "SELECT * FROM appartenir_cat WHERE id_formation = :id_form AND id_categories = :id_cat";
                                    $requete_categories_form = $db->prepare($sql_categories_form);
                                    $requete_categories_form->execute(array(
                                        ":id_form" => $_POST['id_form'],
                                        ":id_cat" => $affiche_categories['id_categories']
                                    ));                        
                                    $affiche_categories_form = $requete_categories_form->rowCount();
                                                                   

                                        if ($affiche_categories_form == 1){echo 'checked="yes">';} else {echo '>';}

                                    echo $affiche_categories['titre_categories'];
                                                              
                                }
                            ?>
                    </div>
                </div>
                <div class="ligne_cadre_admin">
                    <div class="colonne_gauche_admin">Condition de la formation</div>
                    <div class="colonne_droite_admin"> <textarea name="condition_formation" id="condition_formation" cols="70" rows="5" ><?= $affiche_information_for['condition_formation']?></textarea> </div>
                </div>

                <div class="ligne_cadre_admin">
                    <div class="colonne_gauche_admin">Métier visé</div>
                    <div class="colonne_droite_admin"> <textarea name="metier_vise" id="metier_vise" cols="70" rows="5" 
                    ><?= $affiche_information_for['metier_viser_formation']?></textarea> </div>
                </div>

                <div class="ligne_cadre_admin">
                    <div class="colonne_gauche_admin">Frais de scolarité</div>
                    <div class="colonne_droite_admin"> <textarea name="frais_scolarite" id="frais_scolarite" cols="70" rows="5"><?= $affiche_information_for['frais_scolarite_formation']?></textarea> </div>
                </div>

                
                <div class="ligne_cadre_admin">
                    <div class="colonne_gauche_admin">Lieu de la formation</div>
                    <div class="colonne_droite_admin"> <textarea name="lieu_formation" id="lieu_formation"  cols="70" rows="5" ><?= $affiche_information_for['lieu_formation']?></textarea> </div>
                </div>

                

                <div class="ligne_cadre_admin">
                    <div class="colonne_gauche_admin"> <input type="submit" value="Modifier la formation" class="modif_formation_admin"> </div>
                </div>
                </form>

           </div>

           <?php 
        }

        if ($_GET['action'] == 'formation_modif')
        {
            // ici on s'occupe de mettre à jour 

            $message = '';

            if (isset($_POST["titre"], $_POST["description"], $_POST["code_formation"], $_POST["duree"], $_POST["niveau_formation"], $_POST["condition_formation"], $_POST["metier_vise"], $_POST["frais_scolarite"], $_POST["lieu_formation"], $_POST["categories"], $_POST['type_formation'] )                
            && !empty($_POST["titre"]) && !empty($_POST["description"]) && !empty($_POST["code_formation"]) && !empty($_POST["duree"]) && !empty($_POST["niveau_formation"]) && !empty($_POST["condition_formation"]) && !empty($_POST["metier_vise"]) && !empty($_POST["frais_scolarite"]) && !empty($_POST["lieu_formation"]) && !empty($_POST["categories"]) && !empty($_POST['type_formation'] ))
            {

                $message .= ' <div class="message_erreur_formulaire_admin">       
                on met a jour les infos
                </div>';

                $sqlcomptemajcp = "UPDATE formation SET titre_formation=:titre_formation, description_formation=:description_formation, code_formation=:code_formation, duree_formation=:duree_formation, condition_formation=:condition_formation, metier_viser_formation=:metier_viser_formation, frais_scolarite_formation=:frais_scolarite, lieu_formation=:lieu_formation, id_niveau=:id_niveau
                WHERE id_formation=:id_form";
                $requetecomptemajcp = $db->prepare($sqlcomptemajcp);
                $requetecomptemajcp->execute(array(
                                ":titre_formation" =>$_POST["titre"],
                                ":description_formation" =>$_POST["description"],
                                ":code_formation" =>$_POST["code_formation"],
                                ":duree_formation" =>$_POST["duree"],
                                ":condition_formation" =>$_POST["condition_formation"],
                                ":metier_viser_formation" =>$_POST["metier_vise"],
                                ":frais_scolarite" =>$_POST["frais_scolarite"],
                                ":lieu_formation" =>$_POST["lieu_formation"],
                                ":id_niveau" =>$_POST["niveau_formation"],
                                ":id_form" => $_POST['id_form']
                            ));

            // ici on supprime tous dans appartenir_cat => et on remet 

            $sql_cat = "DELETE FROM appartenir_cat WHERE id_formation=:id_form";
            $requete_cat = $db->prepare($sql_cat);
            $requete_cat->execute(array(
                ":id_form" => $_POST['id_form']
            )); 

            foreach ($_POST['categories'] as $cat)
            {
        
            $sqlajoutcat= "INSERT INTO `appartenir_cat` (`id_categories`,`id_formation`) 
            VALUES (:id_categories, :id_formation)";
            $requeteajoutcat = $db->prepare($sqlajoutcat);
            $requeteajoutcat->execute(
                array(
                    ":id_categories" => $cat,
                    ":id_formation" =>  $_POST['id_form']
                )
            );

            }

            $sql_type = "DELETE FROM effectuer_type_formation WHERE id_formation=:id_form";
            $requete_type = $db->prepare($sql_type);
            $requete_type->execute(array(
                ":id_form" => $_POST['id_form']
            )); 

            foreach ($_POST['type_formation'] as $form)
            {
                $sqlajoutcat= "INSERT INTO `effectuer_type_formation` (`id_type_formation`,`id_formation`) 
                VALUES (:id_type_formation, :id_formation)";
                $requeteajoutcat = $db->prepare($sqlajoutcat);
                $requeteajoutcat->execute(
                    array(
                        ":id_type_formation" => $form,
                        ":id_formation" =>  $_POST['id_form']
                    )
                );
            }

            }
            else {
                $message = 'Merci remplir tous les champs';
            }

            echo json_encode(array( 
                "message" => $message
            ));
        }

        if ($_GET['action'] == 'supprimer_confirmer_formation')
        {
            $sql_information_for = "SELECT * FROM formation WHERE id_formation = :id_form";
            $stmt_information_for= $db->prepare($sql_information_for);
            $stmt_information_for->execute(array(
                
                ":id_form" => $_POST["id_form"]
            ));           
            $affiche_information_for = $stmt_information_for->fetch();

            echo ' <div class="titre_formulaire_admin">Supprimer la formation <br> '.$affiche_information_for['titre_formation'].'</div> ';

            echo "<div class='ligne_info_admin'> Etes vous sur de vouloir supprimer cette formation ? </div> ";

            echo '
            <a href="#" class="sous_menu_admin_formation_suppr_confirme bouton_confirmer" data-value="'.$_POST['id_form'].'">Je confirme</a>
            
            <a href="#" class="sous_menu_admin_formation bouton_annuler" data-value="'.$_POST['id_form'].'">J\'annule</a>
            
            ';
        }

        if ($_GET['action'] == 'supprimer_formation')
        {
            

            $sql_cat = "DELETE FROM appartenir_cat WHERE id_formation=:id_form";
            $requete_cat = $db->prepare($sql_cat);
            $requete_cat->execute(array(
                ":id_form" => $_POST['id_form']
            )); 

            
            $sql_type = "DELETE FROM effectuer_type_formation WHERE id_formation=:id_form";
            $requete_type = $db->prepare($sql_type);
            $requete_type->execute(array(
                ":id_form" => $_POST['id_form']
            )); 

            $sql_possede = "DELETE FROM posseder WHERE id_formation=:id_form";
            $requete_possede = $db->prepare($sql_possede);
            $requete_possede->execute(array(
                ":id_form" => $_POST['id_form']
            )); 

            $sql_information_for = "SELECT * FROM formation WHERE id_formation = :id_form";
            $stmt_information_for= $db->prepare($sql_information_for);
            $stmt_information_for->execute(array(
                
                ":id_form" => $_POST["id_form"]
            ));           
            $affiche_information_for = $stmt_information_for->fetch();

            echo "On supprime la formation : ".$affiche_information_for['titre_formation']." ";
            
            $sql_form = "DELETE FROM formation WHERE id_formation=:id_form";
            $requete_form = $db->prepare($sql_form);
            $requete_form->execute(array(
                ":id_form" => $_POST['id_form']
            )); 


        }

        if ($_GET['action'] == 'competences')
        {
            ?>

            <button class="admin_ajouter_competences">Ajouter une compétence</button>



            <table id="myTable3" class="display">
                <thead>
                    <tr>
                        <th>Description de la compétence</th>
                        <th>Titre de la formation</th>
                        <th>Référence</th>
                        <th>Nb formation concernée</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql_competence = "SELECT * FROM competence";
                        $requete_competence = $db->prepare($sql_competence);
                        $requete_competence->execute();                        
                        while ($affiche_competence = $requete_competence->fetch())
                        {
                           echo '

                            <tr>
                                <td>'.nl2br($affiche_competence['desc_competence']).'</td>
                                <td>';

                                if ($affiche_competence['titre_competence'] == '')
                                {
                                    echo 'Pas de titre';
                                }
                                else {
                                    echo  $affiche_competence['titre_competence'].'</td>';
                                }

                                echo '<td>';

                                $sql_ref = "SELECT * FROM avoir_ref af, reference r
                                WHERE af.id_reference=r.id_reference
                                AND  af.id_competence = :id_comp";
                                $requete_ref = $db->prepare($sql_ref);
                                $requete_ref->execute(array(
                                    ":id_comp" => $affiche_competence['id_competence']
                                ));                        
                                $affiche_ref = $requete_ref->fetch();

                               echo $affiche_ref['titre_reference'];

                               echo '</td>';


                                echo '<td>';

                                // ici on calcul le nombre de formation concerné
                                $sql_comp_form = "SELECT * FROM posseder WHERE id_competence = :id_comp";
                                $requete_comp_form = $db->prepare($sql_comp_form);
                                $requete_comp_form->execute(array(
                                    ":id_comp" => $affiche_competence['id_competence']
                                ));                        
                                $affiche_cop_form = $requete_comp_form->rowCount();

                                echo $affiche_cop_form;


                                
                                echo '</td>';                             
                                
                               
                                
                               echo '
                               <td> <a href="#" class="sous_menu_admin_competence_modifier" data-value="'.$affiche_competence['id_competence'].'"><i class="fa-solid fa-pen jaune"></i></a> / 
                                <a href="#" class="sous_menu_admin_competence_supprimer" data-value="'.$affiche_competence['id_competence'].'"><i class="fa-solid fa-trash rouge"></i></a>
                                 </td>
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

        if ($_GET['action'] == 'ajout_competence')
        {
            ?>
                <div class="titre_formulaire_admin">Ajouter une compétence</div>

                <div class="message_erreur_formulaire_admin"></div>
            
                <div class="cadre_formulaire_admin">
            
                    <form class="valider_competence" id="myForm">
                        <div class="ligne_cadre_admin">
                            <div class="colonne_gauche_admin">Titre de la compétence</div>
                            <div class="colonne_droite_admin"> <input type="text" size="50" name="titre" id="titre" placeholder="Titre de la compétence (Facultatif)"> </div>
                        </div>
            
                        <div class="ligne_cadre_admin">
                            <div class="colonne_gauche_admin">Description de la compétence</div>
                            <div class="colonne_droite_admin"> <textarea name="description" id="description" cols="70" rows="5" placeholder="Description de la compétence"></textarea></div>
                        </div>     

                        <hr>

                        <div class="ligne_cadre_admin">
                            <div class="colonne_gauche_admin">Sélectionner une référence</div>
                            <div class="colonne_droite_admin">
                                <select name="reference" id="reference">
                                    <option value="">Ne rien sélectionner si aucune référence ne correspond</option>
                                    <?php    
                                        $sql_reference = "SELECT * FROM reference";
                                        $requete_reference = $db->prepare($sql_reference);
                                        $requete_reference->execute();                        
                                        while ($affiche_reference = $requete_reference->fetch())
                                        {

                                            echo '<option value="'.$affiche_reference['id_reference'].'" >'.$affiche_reference['numeros_reference'].' '.$affiche_reference['titre_reference'].'</option>';
                                        }
                                    ?>  
                                </select>
                            </div>
                        </div>

                        <div class="ligne_cadre_admin">
                            <div class="colonne_gauche_admin">Ajouter une référence</div>
                            <div class="colonne_droite_admin"> 
                                <input type="text" size="50" name="reference_existe" id="reference_existe" placeholder="Code de la référence (si aucune référence ne correspond)"> 
                                <input type="text" size="50" name="reference_titre_existe" id="reference_titre_existe" placeholder="Titre de la référence (si aucune référence ne correspond)"> 
                            </div>
                        </div>

                        <hr>

                        <div class="ligne_cadre_admin">
                            <div class="colonne_gauche_admin">Relier la compétence à une formation </div>
                            <div class="colonne_droite_admin"> 
                                <?php    
                                    $sql_formation = "SELECT * FROM formation";
                                    $requete_formation = $db->prepare($sql_formation);
                                    $requete_formation->execute();                        
                                    while ($affiche_formation = $requete_formation->fetch())
                                    {
                                        echo '<input type="checkbox" name="formations[]" value="'.$affiche_formation['id_formation'].' ">'.$affiche_formation['titre_formation'].'<br> ';
                                    }
                                ?>
                            </div>
                        </div>  
            
                        <div class="ligne_cadre_admin">
                        <div class="colonne_gauche_admin"> <input type="submit" value="Ajouter la compétence"class="bouton_ajout_competence"> </div>
                        </div>
                    </form>
            
                </div>
            <?php
        }

        if ($_GET['action'] == 'ajouter_competence')
        {

            $message = "";
            $erreur = "";


            // $erreur .=' reference '.$_POST['reference'].' et ref existe '.$_POST['reference_existe'].'';

            if (($_POST['reference'] == '') &&  ($_POST['reference_existe'] == '') AND  ($_POST['reference_titre_existe'] == ''))
            {
                $erreur .= 'Merci de choisir une référence ou d\'en creer une';
            }
            else {

                if (($_POST['reference'] != '') &&  ($_POST['reference_existe'] != '') &&  ($_POST['reference_titre_existe'] != ''))
                {
                    $erreur .= 'Merci de choisir une référence qui existe, ou d\'en créer une si nécessaire';
                }
                if (($_POST['reference'] != '') OR ($_POST['reference_existe'] != '') AND ($_POST['reference_titre_existe'] != ''))
                {
                    if (isset($_POST['description']) &&  !empty($_POST['description']))
                    {
        
                        $sqlajoutcomp= "INSERT INTO `competence` (`titre_competence`,`desc_competence`) 
                        VALUES (:titre_formation, :description_formation)";
                        $requeteajoutcomp = $db->prepare($sqlajoutcomp);
                        $requeteajoutcomp->execute(
                            array(
                                ":titre_formation" => $_POST['titre'],
                                ":description_formation" => $_POST['description']
                            )
                        );
                        $dernier_id = $db->lastInsertId();
    
                        if ($_POST['reference'] != '')
                        {   
                            // ici on recupere la référence 
    
                            // on relis la compétence creer à la référence récuperer dans la table avoir_ref
                            $sqlajoutref2= "INSERT INTO `avoir_ref` (`id_competence`,`id_reference`) 
                            VALUES (:id_competence, :id_reference)";
                            $requeteajoutref2 = $db->prepare($sqlajoutref2);
                            $requeteajoutref2->execute(
                                array(
                                    ":id_competence" => $dernier_id,
                                    ":id_reference" => $_POST['reference']
                                )
                            );

                             // ici on relie la competence à la formation

                            if (isset($_POST['formations'] ))
                            {
                                foreach ($_POST['formations'] as $form)
                                {
                            
                                $sqlajoutcat= "INSERT INTO `posseder` (`id_competence`,`id_formation`) 
                                VALUES (:id_competence, :id_formation)";
                                $requeteajoutcat = $db->prepare($sqlajoutcat);
                                $requeteajoutcat->execute(
                                    array(
                                        ":id_competence" => $dernier_id,
                                        ":id_formation" => $form
                                    )
                                );

                                }

                            }
    
                        }
    
                        if (($_POST['reference_existe'] != '') AND ($_POST['reference_titre_existe'] != ''))
                        {

                            // on insert la référence dans bdd

                            $sqlajoutref= "INSERT INTO `reference` (`numeros_reference`,`titre_reference`) 
                            VALUES (:numeros_reference, :titre_reference)";
                            $requeteajoutref = $db->prepare($sqlajoutref);
                            $requeteajoutref->execute(
                                array(
                                    ":numeros_reference" => $_POST['reference_existe'],
                                    ":titre_reference" => $_POST['reference_titre_existe']
                                )
                            );
                            $dernier_id_ref = $db->lastInsertId();
    
                            // ensuite on relis la compétence à la référence dans la table avoir_ref
                            $sqlajoutref2= "INSERT INTO `avoir_ref` (`id_competence`,`id_reference`) 
                            VALUES (:id_competence, :id_reference)";
                            $requeteajoutref2 = $db->prepare($sqlajoutref2);
                            $requeteajoutref2->execute(
                                array(
                                    ":id_competence" => $dernier_id,
                                    ":id_reference" => $dernier_id_ref
                                )
                            );

                            
                            if (isset($_POST['formations'] ))
                            {
                                foreach ($_POST['formations'] as $form)
                                {
                            
                                $sqlajoutcat= "INSERT INTO `posseder` (`id_competence`,`id_formation`) 
                                VALUES (:id_competence, :id_formation)";
                                $requeteajoutcat = $db->prepare($sqlajoutcat);
                                $requeteajoutcat->execute(
                                    array(
                                        ":id_competence" => $dernier_id,
                                        ":id_formation" => $form
                                    )
                                );

                                }

                            }
    
                            // $message .= 'Référence creer et relié à la compétence';
   
                        }



                        
                    }
                    else {
                        
                        $erreur .= 'Merci de remplir la description';
                    }
                    

                    

                    $message .= 'La catégorie est bien ajouté';
                }
                else {
                    if (($_POST['reference_existe'] == '') OR ($_POST['reference_titre_existe'] == ''))
                    {
                        $erreur .= 'Si vous creer une référence merci de remplir le code et le titre';
                    }
                }
    
            }

            echo json_encode(array( 
                "message" => $message,
                "erreur" => $erreur
            ));

        }

        if ($_GET['action'] == 'formulaire_modif_competence')
        {

            $sql_competence_info = "SELECT * FROM competence WHERE id_competence = :id_comp";
            $stmt_competence_info= $db->prepare($sql_competence_info);
            $stmt_competence_info->execute(array(
                
                ":id_comp" => $_POST["id_comp"]
            ));           
            $affiche_competence_info = $stmt_competence_info->fetch();

            ?>
            <div class="titre_formulaire_admin">Modifier une compétence <br>
            <?php
            
            if ($affiche_competence_info['titre_competence'] == '') {}
            else {echo $affiche_competence_info['titre_competence'];}

            ?>
            </div>

            <div class="message_erreur_formulaire_admin"></div>
        
            <div class="cadre_formulaire_admin">
        
                <form class="valider_modif_competence" id="myForm_modif_comp">
                    <input type="hidden" name="id_comp" id="id_comp" value="<?= $_POST['id_comp'];?>">
                    <div class="ligne_cadre_admin">
                        <div class="colonne_gauche_admin">Titre de la compétence</div>
                        <div class="colonne_droite_admin"> <input type="text" size="50" name="titre" id="titre" 
                        <?php 
                        if ($affiche_competence_info['titre_competence'] == '') {echo 'placeholder="test"';}
                        else {echo 'value="'.$affiche_competence_info['titre_competence'].'"';}
                        ?>
                        > </div>
                    </div>

                    <div class="ligne_cadre_admin">
                            <div class="colonne_gauche_admin">Description de la compétence</div>
                            <div class="colonne_droite_admin"> 
                                <textarea name="description" id="description" cols="70" rows="5"><?= $affiche_competence_info['desc_competence'] ?></textarea>
                            </div>
                    </div>     

                        <hr>

                    <div class="ligne_cadre_admin">
                        <div class="colonne_gauche_admin">Sélectionner une référence</div>
                        <div class="colonne_droite_admin">
                            <select name="reference" id="reference">
                                <?php    
                                    $sql_reference = "SELECT * FROM reference";
                                    $requete_reference = $db->prepare($sql_reference);
                                    $requete_reference->execute();                        
                                    while ($affiche_reference = $requete_reference->fetch())
                                    {
                                        $sql_avoir_ref = "SELECT * FROM avoir_ref WHERE id_reference = :id_ref AND id_competence = :id_comp";
                                        $requete_avoir_ref = $db->prepare($sql_avoir_ref);
                                        $requete_avoir_ref->execute(array(
                                            ":id_ref" => $affiche_reference['id_reference'],
                                            ":id_comp" => $affiche_competence_info['id_competence']
                                        ));                        
                                        $affiche_avoir_ref = $requete_avoir_ref->rowCount();

                                        if ($affiche_avoir_ref >= 1) {
                                            
                                            echo '<option value="'.$affiche_reference['id_reference'].'" checked >('.$affiche_reference['numeros_reference'].') '.$affiche_reference['titre_reference'].' </option>';
                                        
                                        } else {

                                            echo '<option value="'.$affiche_reference['id_reference'].'" >('.$affiche_reference['numeros_reference'].') '.$affiche_reference['titre_reference'].'</option>';
                                        }
                                    }
                                ?>  
                            </select>
                        </div>
                    </div>

                    <hr>

                    <div class="ligne_cadre_admin">
                            <div class="colonne_gauche_admin">Relier la compétence à une formation </div>
                            <div class="colonne_droite_admin"> 
                                <?php    
                                    $sql_formation = "SELECT * FROM formation";
                                    $requete_formation = $db->prepare($sql_formation);
                                    $requete_formation->execute();                        
                                    while ($affiche_formation = $requete_formation->fetch())
                                    {
                                        $sql_posseder = "SELECT * FROM posseder WHERE id_competence = :id_comp AND id_formation = :id_form";
                                        $requete_posseder = $db->prepare($sql_posseder);
                                        $requete_posseder->execute(array(
                                            ":id_comp" => $affiche_competence_info['id_competence'],
                                            ":id_form" => $affiche_formation['id_formation']
                                        ));                        
                                        $affiche_posseder = $requete_posseder->rowCount();

                                        if ($affiche_posseder >= 1) {$check = 'checked="yes"';} else {$check = '';}

                                        echo '<input type="checkbox" name="formations[]" value="'.$affiche_formation['id_formation'].'" '.$check.'>'.$affiche_formation['titre_formation'].'<br> ';
                                    }
                                ?>
                            </div>
                    </div>

                    <div class="ligne_cadre_admin">
                        <div class="colonne_gauche_admin"> <input type="submit" value="Modifier la compétence"class="bouton_ajout_competence"> </div>
                    </div>

                </form>

            </div>

            <?php
        }

        if ($_GET['action'] == 'formation_modif_valide')
        {

            // ici on modifiie le titre et la description

            if (isset($_POST['description']) && !empty($_POST['description']))
            {

                $sqlcomptemajcp = "UPDATE competence SET titre_competence=:titre_competence, desc_competence=:description_competence
                WHERE id_competence=:id_comp";
                $requetecomptemajcp = $db->prepare($sqlcomptemajcp);
                $requetecomptemajcp->execute(array(
                                ":titre_competence" =>$_POST["titre"],
                                ":description_competence" =>$_POST["description"],
                                ":id_comp" => $_POST['id_comp']
                            ));
                if ($_POST["reference"] == '')
                {
                    echo 'Merci de sélectionner une référence';
                }
                else {
                    $sql_maj_ref = "UPDATE avoir_ref SET id_reference=:id_reference
                    WHERE id_competence=:id_comp";
                    $requetecomptemajcp = $db->prepare($sql_maj_ref);
                    $requetecomptemajcp->execute(array(
                    ":id_reference" =>$_POST["reference"],
                    ":id_comp" => $_POST['id_comp']
                    ));
                }

                $sql_type = "DELETE FROM posseder WHERE id_competence=:id_comp";
                $requete_type = $db->prepare($sql_type);
                $requete_type->execute(array(
                    ":id_comp" => $_POST['id_comp']
                )); 


                if (!empty($_POST['formations']))
                {
                    foreach ($_POST['formations'] as $form)
                    {
                    $sqlajoutcat= "INSERT INTO `posseder` (`id_competence`,`id_formation`) 
                    VALUES (:id_competence, :id_formation)";
                    $requeteajoutcat = $db->prepare($sqlajoutcat);
                    $requeteajoutcat->execute(
                        array(
                            ":id_competence" => $_POST['id_comp'],
                            ":id_formation" => $form
                        )
                    );

                    }
                }

            }
            else {
                echo '<div class="message_erreur_formulaire_admin">Merci de rentrer une description</div>';                
            }

            // id competence => '.$_POST['id_comp'].' <br>
            // titre competence => '.$_POST['titre'].' <br>
            // desc competence => '.$_POST['description'].' <br> 
            // reference => '.$_POST['reference'].' <br> 

            echo '<div class="message_erreur_formulaire_admin">Modification faite</div>';
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
