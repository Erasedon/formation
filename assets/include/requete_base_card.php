<?php
    $query = "
							SELECT * FROM formation f, niveau n,appartenir_cat acat, categories c, competence com,avoir_ref aref,reference ref,posseder p,effectuer_type_formation etf,type_formation tf 
							WHERE f.id_niveau = n.id_niveau AND acat.id_categories = c.id_categories AND acat.id_formation = f.id_formation AND aref.id_competence = com.id_competence AND aref.id_reference = ref.id_reference AND  p.id_competence = com.id_competence AND p.id_formation = f.id_formation AND etf.id_type_formation = tf.id_type_formation AND etf.id_formation = f.id_formation 
							";
							$statement =$db->prepare($query);
							$statement->execute();
							$result = $statement->fetchAll();
							$titre_count = $statement->rowCount();
						$output = '';
						foreach($result as $row)
								{
									$output .= '
										<div class="col-md-4 p-2 mb-3">
										<a href="page-detail.php?id_formation='.$row['id_formation'].'" >
										<div class="cards-block">
										<h2>'. $row['titre_formation'] . '</h2>
										<p>'. $row['titre_categories'] . '</p>
										<div class="sous-cards-block">
										<p>'. $row['titre_niveau'] .'</p>
										<p>'. $row['duree_formation'] .'</p>
										</div>
										</div>
										</a>
										</div>
									';
								}
					echo $output;

?>