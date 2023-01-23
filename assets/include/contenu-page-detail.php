<?php 
include('assets/db/connectdb.php');	
 $query = "
 SELECT * FROM formation f, niveau n,appartenir_cat acat, categories c, competence com,avoir_ref aref,reference ref,posseder p,effectuer_type_formation etf,type_formation tf 
 WHERE f.id_niveau = n.id_niveau AND acat.id_categories = c.id_categories AND acat.id_formation = f.id_formation AND aref.id_competence = com.id_competence AND aref.id_reference = ref.id_reference AND  p.id_competence = com.id_competence AND p.id_formation = f.id_formation AND etf.id_type_formation = tf.id_type_formation AND etf.id_formation = f.id_formation AND f.id_formation ='".$_GET["id_formation"]."'
 ";
 $statement =$db->prepare($query);
 $statement->execute();
 $result = $statement->fetch();

?>
<div class="container my-5">
    <div class="row p-4 pb-0 pe-lg-0 pt-lg-5 align-items-center rounded-3 border shadow-lg">
        <div class="col-lg-7 p-3 p-lg-5 pt-lg-3">
            <h1 class="display-4 fw-bold lh-1"><?php echo $result['titre_formation'];  ?></h1>
            <p class="lead"><strong> <?php echo $result['titre_niveau'];  ?></strong> <br> Formation initiale dans le cadre du
                Plan Régional de Formation Statut de stagiaire de la formation professionnelle</p>

        </div>

        <div class="container">
            <div class="row">

                <div class="col-md-2">


                    <div class="p-2 mb-3 titre-RNCP  ">
                        <p> <?php 
                        
                        echo $result['numeros_reference'];  
                        echo $result['titre_reference'];  ?>
                        </p>

                    </div>

                    <div class="p-2 mb-3 titre-RNCP">
                        <p><?php 
                        
                        echo $result['numeros_reference'];  
                        echo $result['titre_reference'];  ?>
                        </p>

                    </div>
                </div>

                <div class="col-md-8">
                    <div class="p-4 mb-3  rounded-3">

                        <h4 class="titre-comptetence"><?php echo $result['titre_competence'];  ?></h4>
                        <p class=""><?php echo $result['desc_competence'];  ?>

                        </p>
                    </div>
                </div>

                <div class="col-md-2 ">

                    <div class=''>
                        <div class="card card-page-detail" style="width: 12rem;">
                            <div class="card-body card-page-detail">

                                <p class="card-title">CODE RNCP <?php echo $result['code_formation'];  ?></p>

                            </div>
                        </div>
                    </div>
                    <hr>



                    <div class=''>
                        <div class="card card-page-detail" style="width: 12rem;">
                            <div class="card-body card-page-detail">

                                <p class="card-title"> <strong> </strong>Durée de la formation:</p>
                                <p class="card-text"><?php echo $result['duree_formation'];  ?></p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>


        <div class='container'>

            <div class='row'>

                <div class='col-md-6'>

                    <div class="p-4 mb-3  rounded-3">

                        <h4 class="titre-comptetence">Conditions d’admission et pré-requis</h4>
                        <p class=""> <?php echo $result['condition_formation'];  ?></p>
                    </div>

                </div>


                <div class='col-md-6'>
                    <div class="p-4 mb-3  rounded-3">
                        <h4 class="titre-comptetence">Métiers visés</h4>
                        <p class=""><?php echo $result['metier_viser_formation'];  ?></p>
                    </div>
                </div>

                <div class='col-md-6'>


                    <div class="p-4 mb-3  rounded-3">
                        <h4 class="titre-comptetence">Frais de scolarité</h4>
                        <p class=""><?php echo $result['frais_scolarite_formation'];  ?></p>
                    </div>
                </div>

                <div class='col-md-6'>
                    <div class="p-4 mb-3  rounded-3">
                        <h4 class="titre-comptetence">Lieu</h4>
                        <p class=""><?php echo $result['lieu_formation'];  ?></p>
                    </div>
                </div>

            </div>

        </div>


    </div>
</div>
<?php  ?>