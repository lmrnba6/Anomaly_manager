<?php

global $wpdb;
require_once (PLUGIN_PATH . '/includes/public/partials/function.php');


///Get all rows from table Anomaly
$Anomaly = getAnomaly($wpdb);

///IF $_POST is not empty, A form was submitted.
if(!empty($_POST)){
	
	///Parse type
	$type = $_POST['type'];
	
	///IF Type == Edit
	if($type === "edit"){
		
		/**
		*$id_anomaly			: ID wich represent an anomaly in database
		*$description_short 	: Short description of an anomaly
		*$description 			: Full descriotion ( 255 char)
		*$version 				: Version of the anomaly
		*$status 				: Current status between { nouveau, assigné, rejeté, fermé }
		*$priority 				: Priority between 1 to 3
		*$anomaly_name 			: Anomaly name 
		*/
		$id_anomaly 		= $_POST['id_anomaly'];
		$description_short 	= $_POST['description_short'];
		$description 		= $_POST['description'];
		$version 			= $_POST['version'];
		$status 			= $_POST['status'];
		$priority 			= $_POST['priority'];
		$anomaly_name 		= $_POST['anomaly_name'];
		
		

		///Return error if one the parameter is wrong
		$validate = valideEdit($id_anomaly, $description_short, $description, $version, $status, $priority, $anomaly_name);
		
		if( $validate == "ok"){
			$row_affected = $wpdb->query(
				$wpdb->prepare( "UPDATE `Anomaly` SET description_short = %s, description = %s, version = %s, status = %s, priority = %d, anomaly_name = %s WHERE id_anomaly = %d",
				$description_short, $description, $version, $status, $priority, $anomaly_name, $id_anomaly
				) /// $wpdb->prepare
			); /// $wpdb->query
			
			///If update failed show error message
			if($row_affected == 0){
				echo failedAction('Éechec modification anomalie : ' .$anomaly_name );
			}
			///If update success, update $Anomaly
			else{
				echo succedAction("Modification anomalie : " .$anomaly_name );
				$Anomaly = getAnomaly($wpdb);
			}
		}else{
			echo failedAction($validate);
		}
	}
	///IF Type == Delete
	elseif($type === "delete"){
		///Parse data
		$id_anomaly = $_POST['id_anomaly'];
		
		///Validate data
		if(is_numeric($id_anomaly) and sizeof($id_anomaly) < 12){
			$row_affected = $wpdb->query(
				$wpdb->prepare("DELETE FROM `Anomaly` WHERE `Anomaly`.`id_anomaly` = %d",
				$id_anomaly) /// Delete from database
			);
			
			if($row_affected == 0){
				echo failedAction('Supprimer anomalie');
			}
			else{
				echo succedAction("Supression de l'anomalie");
				$Anomaly = getAnomaly($wpdb);
			}
		}
		else{
			echo 'nope';
		}
	}
	///IF Type == add
	elseif($type === "add"){
		
		/**
		*$data['description_short'] 	: Short description of an anomaly
		*$data['description'] 			: Full descriotion ( 255 char)
		*$data['version'] 				: Version of the anomaly
		*$data['status'] 				: Current status between { nouveau, assigné, rejeté, fermé }
		*$data['priority'] 				: Priority between 1 to 3
		*$data['anomaly_name'] 			: Anomaly name 
		*/
		$data['description_short'] 	= $_POST['description_short'];
		$data['description'] 		= $_POST['description'];
		$data['version'] 			= $_POST['version'];
		$data['status'] 			= $_POST['status'];
		$data['priority'] 			= $_POST['priority'];
		$data['anomaly_name'] 		= $_POST['anomaly_name'];
		
		///Validate all information
		$validate = valideAdd($data['description_short'], $data['description'], $data['version'], $data['status'], $data['priority'], $data['anomaly_name']);
		
		
		if( $validate == "ok"){
			
			///Insert in database
			$row_added = $wpdb->insert('Anomaly', $data);
			
			///If update failed show error message
			if($row_added == false){
				echo failedAction('Ajout de l\'anomalie : ' .$data['anomaly_name'] );
			}
			///If update success, update $Anomaly
			else{
				echo succedAction('Ajout de l\'anomalie : ' .$data['anomaly_name']);
				$Anomaly = getAnomaly($wpdb);
			}
		}else{
			echo failedAction($validate);
		}
	}
	///IF Type == add_comment
	elseif($type === "add_comment"){
		
		/**
		*$data['id_anomaly'] 			: ID wich represent an anomaly in database
		*$data['libelleCommentaire'] 	: Comment on the anomaly ( 255 char )
		*$data['auteurComment'] 		: Author for the comment
		*/
		$data['id_anomaly'] = $_POST['id_anomaly'];
		$data['libelleCommentaire'] = $_POST['libelleCommentaire'];
		$data['auteurComment'] = $_POST['auteurComment'];
		
		///Validate information for comment
		$validate = valideAddComment($data['id_anomaly'], $data['libelleCommentaire'], $data['auteurComment']);
		
		if( $validate == "ok"){
			
			///Insert in database
			$row_added = $wpdb->insert('Commentaire', $data);
			
			///If update failed show error message
			if($row_added == false){
				echo failedAction('Ajout commentaire : ' .$data['libelleCommentaire']);
			}
			///If update success, update $Anomaly
			else{
				echo succedAction('Ajout commentaire : ' .$data['libelleCommentaire']);
			}
		}else{
			echo failedAction($validate);
		}
	}
	///IF Type doesn't exist	: show error message 
	elseif($type != "edit" and $type != "delete" and $type != "add"){
		echo failedAction('Something strange is happening !');
	}
}
				//INSERTION EN GRANDE QUANTITE DE DONNEES
				/*for ($i =0; $i<1000;$i++)
				{
					$wpdb->query(
					"INSERT INTO `Anomaly`( `description_short`, `description`, `version`, `status`, `priority`, `Comment`, `anomaly_name`) 
					VALUES ('test','ceci est un test','1.x','nouveau',1,'Cette entrée est un test', 'test_anomaly');"
					);
				}*/

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
					<th class="col-md-1">Anomalie</th>
					<th class="col-md-1">Status</th> 
					<th class="col-md-1">Version</th>
					<th class="col-md-1">Priorité</th>
					<th class="col-md-custom-10">Description</th>
					<th class="col-md-custom">Commentaire</th>
					<th class="col-md-1">Détails</th>
					<th class="col-md-1">Modifier</th>
					<th class="col-md-1">Supprimer</th>
					<!--<th><a class='add_button' id='add_button'><span class='glyphicon glyphicon-plus'></span></a></th>-->
				</tr>
				<?php echo parseResultsToTable($Anomaly, $wpdb) ?>
			</table>
		</div>
	</div>
</div>
<style>
th.col-md-custom {
    width: 11%;
}

th.col-md-custom-10 {
    width: 10%;
}

.form-dialog {
	padding: 5%;
	background-color:white;
	border-style: groove;
}
.form-dialog input{
	margin-bottom: 5%;
}

<select multiple="multiple" name="colors">
<option> RED </option>
<option> GREEN </option>
<option> YELLOW </option>
<option> BLUE </option>
<option> ORANGE </option>
</select>

</style>

<!-- Hidden form for add anomaly -->
<div class='form-dialog' id='add_dialog' title='' style='display: none' style='color: white' >
	<form class="form" action="" id="add-form" method="post">
		<input type="hidden" id="type" name="type" value="add"/>
		<label>Anomalie: <span>*</span></label><br/>
		<input type="text" id="anomaly_name" name="anomaly_name" placeholder="Anomalie" value=""/><br/>
		<label>Status: <span>*</span></label><br/>
		<select type="text" id="status" name="status"><option> nouveau </option><option> assigné </option><option> rejeté </option><option> fermé </option></select><br/>
		<label>Version: <span>*</span></label><br/>		
		<input type="text" id="version" name="version" placeholder="Version" value=""/><br/>
		<label>Priorité: <span>*</span></label><br/>	
		<select type="text" id="priority" name="priority"><option value="1"> 1 </option><option value="2"> 2 </option><option value="3"> 3 </option></select><br/>
		<label>Description courte: <span>*</span></label><br/>		
		<input type="text" id="description_short" name="description_short" placeholder="Description" value=""/><br/>
		<label>Description: <span>*</span></label><br/>
		<input type="text" id="description" name="description" placeholder="Description" value=""/><br/>
		<input type="submit" id="savebtn" value="Sauvegarder"/>
	</form>
</div>

<script>
$("#add_button").click(function(){ 
	$( "#add_dialog" ).dialog(); 
});
</script>

<?php 

?>