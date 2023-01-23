<?php
include('../db/connectdb.php');	
$query = "
					SELECT * FROM formation f, niveau n,appartenir_cat acat, categories c, competence com,avoir_ref aref,reference ref,effectuer_type_formation etf,type_formation tf,posseder p WHERE f.id_niveau = n.id_niveau ";
if(isset($_GET["action"])){
	if(isset($_GET["str"])){
		$filter = $_GET["filter"];
		switch (isset($filter)){

			case isset($_GET["competence"]) =='competence':
					$query .= " AND p.id_competence = com.id_competence AND p.id_formation = f.id_formation AND (com.titre_competence='".$_GET["str"]."' OR com.desc_competence ='".$_GET["str"]."') GROUP BY p.id_formation";
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
								break;
							
				
			
			case isset($_GET["categories"]) =='categories': 
					$query .= " AND acat.id_categories = c.id_categories AND acat.id_formation = f.id_formation AND c.titre_categories='".$_GET["str"]."' GROUP BY acat.id_formation";
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
					break;
			case isset($_GET["reference"]) == 'ref':
				$query .= " AND aref.id_competence = com.id_competence AND aref.id_reference = ref.id_reference AND (ref.numeros_reference='".$_GET["str"]."' OR ref.titre_reference ='".$_GET["str"]."') GROUP BY aref.id_reference";
				print $query;
				$statement =$db->prepare($query);
				$statement->execute();
				$result = $statement->fetchAll();
				$titre_count = $statement->rowCount();
				print $titre_count;
				
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
					break;
				case isset($_GET["type"]) =='type':
					$query .= " AND etf.id_type_formation = tf.id_type_formation AND etf.id_formation = f.id_formation AND tf.titre_type_formation='".$_GET["str"]."' GROUP BY etf.id_formation";
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
					break;
			case $filter =='sansf':
				$query .= " AND (f.titre_formation='".$_GET["str"]."' OR f.description_formation ='".$_GET["str"]."')";
				$statement =$db->prepare($query);
				$statement->execute();
				$result = $statement->fetchAll();
				$titre_count = $statement->rowCount();
				print $titre_count;
				if($titre_count > 0){
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
										</div> ';
						
					}
					
					print $output;
				}else{
					
					include("requete_base_card.php");
				}
		}
		}else{
			include("requete_base_card.php");
			
		}
	}else{
		include("requete_base_card.php");
	}