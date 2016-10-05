<?php

global $wpdb;
require_once (PLUGIN_PATH . '/includes/public/partials/function.php');
//Get all rows from table Anomaly
$Anomaly = getAnomaly($wpdb);

//IF $_POST is not empty, A form was submitted.
if(!empty($_POST)){
	
	//Parse type
	$type = $_POST['type'];
	
	if($type === "edit"){
		//Parse $_POST data
		$id_anomaly 		= $_POST['id_anomaly'];
		$description_short 	= $_POST['description_short'];
		$description 		= $_POST['description'];
		$version 			= $_POST['version'];
		$status 			= $_POST['status'];
		$priority 			= $_POST['priority'];
		$comment 			= $_POST['comment'];
		$anomaly_name 		= $_POST['anomaly_name'];
		
		$validate = valideEdit($id_anomaly, $description_short, $description, $version, $status, $priority, $comment, $anomaly_name);
		if( $validate == "ok"){
			$row_affected = $wpdb->query(
				$wpdb->prepare( "UPDATE `Anomaly` SET description_short = %s, description = %s, version = %s, status = %s, priority = %d, Comment = %s, anomaly_name = %s WHERE id_anomaly = %d",
				$description_short, $description, $version, $status, $priority, $comment, $anomaly_name, $id_anomaly
				) // $wpdb->prepare
			); // $wpdb->query
			
			//If update failed show error message
			if($row_affected == 0){
				echo failedAction('Update');
			}
			//If update success, update $Anomaly
			else{
				echo succedAction("Update table");
				$Anomaly = getAnomaly($wpdb);
			}
		}else{
			echo failedAction($validate);
		}
	}
	elseif($type === "delete"){
		//Parse data
		$id_anomaly = $_POST['id_anomaly'];
		
		//Validate data
		if(is_numeric($id_anomaly) and sizeof($id_anomaly) < 12){
			$row_affected = $wpdb->query(
				$wpdb->prepare("DELETE FROM `Anomaly` WHERE `Anomaly`.`id_anomaly` = %d",
				$id_anomaly)
			);
			
			if($row_affected == 0){
				echo failedAction('Supprimer');
			}
			else{
				echo succedAction("Delete entry success !");
				$Anomaly = getAnomaly($wpdb);
			}
		}
		else{
			echo 'nope';
		}
	}
	elseif($type === "add"){
		//Parse $_POST data
		
		$data['description_short'] 	= $_POST['description_short'];
		$data['description'] 		= $_POST['description'];
		$data['version'] 			= $_POST['version'];
		$data['status'] 			= $_POST['status'];
		$data['priority'] 			= $_POST['priority'];
		$data['comment'] 			= $_POST['comment'];
		$data['anomaly_name'] 		= $_POST['anomaly_name'];
		
		$validate = valideAdd($data['description_short'], $data['description'], $data['version'], $data['status'], $data['priority'], $data['comment'], $data['anomaly_name']);
		if( $validate == "ok"){
			$row_added = $wpdb->insert('Anomaly', $data);
			
			//If update failed show error message
			if($row_added == false){
				echo failedAction('Add failed');
			}
			//If update success, update $Anomaly
			else{
				echo succedAction("Add succes");
				$Anomaly = getAnomaly($wpdb);
			}
		}else{
			echo failedAction($validate);
		}
	}
	elseif($type != "edit" and $type != "delete" and $type != "add"){
		echo failedAction('Something strange is happening !');
	}
}
?>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<link rel="stylesheet" href="styles.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>
.dialog {
	background-color:white;
	border-style: groove;
}
.ui-dialog .ui-dialog-titlebar .ui-dialog-titlebar-close {
   background-color:white;
}
</style>
<div id="body" class="home">
	<div class="blog">
		<div id = "divhome">
			<h3>Bienvenue sur Anomaly Manager !</h3>
			<p>
				Anomaly Manager est un plugin WordPress developpe dans le cadre du cours IGL601.
				Ce plugin permet la mise en place d'un gestionnaire d'anomalies dans lequel vous pourrez ajouter, modifier et lister des anomalies.
				Nous esperons que votre passage sur notre site sera agreable et nous vous remercions de votre attention !
				</br> 
				<p></p>
				<b><i>L'equipe Anomaly_Manager</i></b>
			</p>
		</div>
		<div>
			<!-- <h3><b>Ajouter</b> ou <b>Modifier</b> une anomalie ? Pas de probleme :</h3>-->
			<a class='add_button' id='add_button'><span class='glyphicon glyphicon-plus'>Ajouter</span></a>
			<p></p>
			<table class="table table-striped">
				<tr>
					<th>Anomalie</th>
					<th>Status</th> 
					<th>Version</th>
					<th>Priorité</th>
					<th>Description</th>
					<th>Détails</th>
					<th>Modifier</th>
					<th>Supprimer</th>
					<!--<th><a class='add_button' id='add_button'><span class='glyphicon glyphicon-plus'></span></a></th>-->
				</tr>
				<?php echo parseResultsToTable($Anomaly) ?>
			</table>
		</div>
	</div>
</div>

<div class='dialog' id='add_dialog' style='display: none' >
	<form class="formulaire" action="" id="add-form" method="post">
		<input type="hidden" id="type" name="type" value="add"/>
		<label>Anomalie: <span>*</span></label><br/>
		<input type="text" id="anomaly_name" name="anomaly_name" placeholder="Anomalie" value=""/><br/>
		<label>Status: <span>*</span></label><br/>
		<input type="text" id="status" name="status" placeholder="Status" value=""/><br/>
		<label>Version: <span>*</span></label><br/>		
		<input type="text" id="version" name="version" placeholder="Version" value=""/><br/>
		<label>Priorité: <span>*</span></label><br/>	
		<input type="text" id="priority" name="priority" placeholder="Priorité" value=""/><br/>
		<label>Description courte: <span>*</span></label><br/>		
		<input type="text" id="description_short" name="description_short" placeholder="Description" value=""/><br/>
		<label>Description: <span>*</span></label><br/>
		<input type="text" id="description" name="description" placeholder="Description" value=""/><br/>
		<label>Commentaire: <span>*</span></label><br/>
		<input type="text" id="comment" name="comment" placeholder="Commentaire" value=""/><br/>
		<input type="submit" id="savebtn" value="Sauvegarder"/>
	</form>
</div>
<script>
$("#add_button").click(function(){ 
	$( "#add_dialog" ).dialog(); 
});

</script>