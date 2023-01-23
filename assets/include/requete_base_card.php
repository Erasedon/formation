<?php
    $query = "
	SELECT * FROM formation f, categories c, niveau n, appartenir_cat acat
	WHERE f.id_formation=acat.id_formation
	AND n.id_niveau=f.id_niveau
	GROUP BY acat.id_formation
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