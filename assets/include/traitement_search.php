<?php
include('../db/connectdb.php');	

$query = "
	SELECT * FROM formation f, niveau n,appartenir_cat acat, categories c, competence com,avoir_ref aref,reference ref,posseder p,effectuer_type_formation etf,type_formation tf 
	WHERE f.id_niveau = n.id_niveau AND acat.id_categories = c.id_categories AND acat.id_formation = f.id_formation AND aref.id_competence = com.id_competence AND aref.id_reference = ref.id_reference AND  p.id_competence = com.id_competence AND p.id_formation = f.id_formation AND etf.id_type_formation = tf.id_type_formation AND etf.id_formation = f.id_formation 
	";

if(isset($_GET["str"])){
    $query .= "
    AND f.titre_formation ='".$_GET["str"]."' OR f.description_formation ='".$_GET["str"]."'
   ";
  
}
$statement =$db->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$total_pag = $statement->rowCount();
// var_dump($query);
echo $total_pag;
$output = '';
foreach($result as $row)
		{
			$output .= '
			<div class="col-sm-4 text-center" style="border:1px solid red;">
				<div class="card " style="width: 18rem;">
					<div class="card-body">
						<h5 class="card-title">'. $row['titre_formation'] . '</h5>
						<h4 class="card-text" >' . $row['code_formation'] . '€</h4>
						<p class="card-text">
                            condition_formation : '. $row['condition_formation'] .' <br />
							lieu_formation : '. $row['lieu_formation'] .' <br />
                            duree_formation : '. $row['duree_formation'] .'
						</p>
						<a href="poster.php?id_formation= '.$row['id_formation'].'" class="btn btn-secondary">voir plus</a>
					</div>
					</div>
			</div>
			';
		}