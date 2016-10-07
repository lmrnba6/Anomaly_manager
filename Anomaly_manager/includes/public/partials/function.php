<?php


/**
* This function get all the data for anomaly in the database.
* All the data are parsed to return table row for the html.
* This function create too all the hidden form to delete,
* add and edit anomaly. For each row, button with javascript
* are created to completed the action above.
*
*@$Anomaly 	: Contains all row from database
*@$wpdb 	: This is a reference to the class wpdb from wordpress
*/
function parseResultsToTable($Anomaly, $wpdb){
	
	///IF $Anomaly contain rows
	if( !empty( $Anomaly )){
		
		///Foreach row in $Anomaly create html and css
		foreach($Anomaly as $key => $row){
			
			///Table row with database data
			$html .= "<tr>";
			$html .= "<td>" . $row->anomaly_name . "</td>";
			$html .= "<td>" . $row->status . "</td>";
			$html .= "<td>" . $row->version . "</td>";
			$html .= priorityColor($row->priority);
			$html .= "<td>" . $row->description_short . "</td>";
			$html .= "<td><a class='add_comment_button col-md-6' id='add_comment_button_" . $row->id_anomaly . "'><span class='glyphicon glyphicon-plus'></span></a><a class='comment_button col-md-6' id='comment_button_" . $row->id_anomaly . "'><span class='glyphicon glyphicon-search'></span></a></td>";
			$html .= "<td><a class='show_button' id='show_button_" . $row->id_anomaly . "'><span class='glyphicon glyphicon-search'></span></a></td>";
			$html .= "<td><a class='delete_button' id='edit_button_" . $row->id_anomaly . "'><span class='glyphicon glyphicon-pencil'></span></a></td>";
			$html .= "<td><a class='delete_button' id='delete_button_" . $row->id_anomaly . "'><span class='glyphicon glyphicon-remove'></span></a></td>";
			$html .= "</tr>";
			
			///Hidden form for show 
			$html .= "<div class='form-dialog' id='show_dialog_" . $row->id_anomaly ."' style='display: none' >";
			$html .= '<form class="form" action="" id="show-form" >';
			$html .= '<input type="hidden" id="id_anomaly" name="id_anomaly" value="' . $row->id_anomaly . '" readonly/>';
			$html .= '<label>Anomalie: <span>*</span></label><br/>';
			$html .= '<input type="text" id="anomaly_name" name="anomaly_name" placeholder="Anomalie" value="' . $row->anomaly_name .'"readonly /><br/>';
			$html .= '<label>Status: <span>*</span></label><br/>';		
			$html .= '<input type="text" id="status" name="status" placeholder="Status" value="' . $row->status . '"readonly /><br/>';
			$html .= '<label>Version: <span>*</span></label><br/>';			
			$html .= '<input type="text" id="version" name="version" placeholder="Version" value="' . $row->version . '"readonly /><br/>';
			$html .= '<label>Priorité: <span>*</span></label><br/>';			
			$html .= '<input type="text" id="priority" name="priority" placeholder="Priorité" value="' . $row->priority . '"readonly /><br/>';
			$html .= '<label>Description courte: <span>*</span></label><br/>';			
			$html .= '<input type="text" id="description_short" name="description_short" placeholder="Description" value="' . $row->description_short . '"readonly /><br/>';
			$html .= '<label>Description: <span>*</span></label><br/>';
			$html .= '<input type="text" id="description" name="description" placeholder="description" value="' . $row->description . '"readonly /><br/>';			
			$html .= '</form>';
			$html .= '</div>';
			
			///Hidden form for edit 
			$html .= "<div class='form-dialog' id='edit_dialog_" . $row->id_anomaly ."' title='' style='display: none'>";
			$html .= '<form class="form" action="" id="edit-form" method="post">';
			$html .= '<input type="hidden" id="type" name="type" value="edit"/>';
			$html .= '<input type="hidden" id="id_anomaly" name="id_anomaly" value="' . $row->id_anomaly . '"/>';
			$html .= '<label>Anomalie: <span>*</span></label><br/>';
			$html .= '<input type="text" id="anomaly_name" name="anomaly_name" placeholder="Anomalie" value="' . $row->anomaly_name .'"/><br/>';
			$html .= '<label>Status: <span>*</span></label><br/>';		
			$html .= selectStatus($row->status);
			$html .= '<label>Version: <span>*</span></label><br/>';			
			$html .= '<input type="text" id="version" name="version" placeholder="Version" value="' . $row->version . '"/><br/>';
			$html .= '<label>Priorité: <span>*</span></label><br/>';			
			$html .= selectPriority($row->priority);
			$html .= '<label>Description courte: <span>*</span></label><br/>';			
			$html .= '<input type="text" id="description_short" name="description_short" placeholder="Description" value="' . $row->description_short . '"/><br/>';
			$html .= '<label>Description: <span>*</span></label><br/>';			
			$html .= '<input type="text" id="description" name="description" placeholder="Description" value="' . $row->description . '"/><br/>';
			$html .= '<input type="submit" id="savebtn" value="Sauvegarder"/>';
			$html .= '</form>';
			$html .= '</div>';
			
			///Hidden form for delete 
			$html .= "<div class='form-dialog' id='delete_dialog_" . $row->id_anomaly ."' style='display: none'>";
			$html .= '<form class="form" action="" id="edit-form" method="post">';
			$html .= '<input type="hidden" id="type" name="type" value="delete"/>';
			$html .= '<input type="hidden" id="id_anomaly" name="id_anomaly" value="' . $row->id_anomaly . '"/>';
			$html .= '<p>Voulez-vous vraiment supprimer cette ligne ?</p>';
			$html .= '<input type="submit" id="deletebtn" value="Supprimer"/>';
			$html .= '</form>';
			$html .= '</div>';
			
			///Hidden form for commentaire 
			$html .= "<div class='form-dialog' id='comment_dialog_" . $row->id_anomaly ."' style='display: none' >";
			$Commentaire = $wpdb->get_results($wpdb->prepare("SELECT * FROM Commentaire WHERE id_anomaly = %d", $row->id_anomaly));
			if(!empty($Commentaire)){
				foreach($Commentaire as $key => $row){
					$html .= '<div>';
					$html .= '<label>Auteur : <span>*</span></label><br/>';
					$html .= '<input type="text" id="auteur" name="auteur" placeholder="Auteur" value="' . $row->auteurComment . '" readonly /><br/>';
					$html .= '<label>Commentaire : <span>*</span></label><br/>';
					$html .= '<input type="text" id="auteur" name="auteur" placeholder="Auteur" value="' . $row->libelleCommentaire . '"readonly /><br/>';
					$html .= '</div>';
					
				}		
			}else{
				$html .= '<p>Auncun commentaire pour cette anomalie !</p>';
			}		
			$html .= '</div>';
			
			
			///Hidden form for ajout commentaire 
			$html .= "<div class='form-dialog' id='add_comment_dialog_" . $row->id_anomaly ."' style='display: none'>";
			$html .= '<form class="form" action="" id="add-comment-form" method="post">';
			$html .= '<input type="hidden" id="type" name="type" value="add_comment"/>';
			$html .= '<input type="hidden" id="id_anomaly" name="id_anomaly" value="' . $row->id_anomaly . '"/>';
			$html .= '<label>Auteur : <span>*</span></label><br/>';
			$html .= '<input type="text" id="auteurComment" name="auteurComment" placeholder="Auteur" value="" /><br/>';
			$html .= '<label>Commentaire : <span>*</span></label><br/>';
			$html .= '<input type="text" id="libelleCommentaire" name="libelleCommentaire" placeholder="Commentaire" value="" /><br/>';
			$html .= '<input type="submit" id="add_comment_btn" value="Sauvegarder"/>';
			$html .= '</form>';
			$html .= '</div>';
			
			///JavaScript to show modal 
			$html .= '<script>';
			$html .= '$("#add_comment_button_' . $row->id_anomaly .'").click(function(){ $( "#add_comment_dialog_' . $row->id_anomaly . '" ).dialog(); });';
			$html .= '$("#comment_button_' . $row->id_anomaly .'").click(function(){ $( "#comment_dialog_' . $row->id_anomaly . '" ).dialog(); });';
			$html .= '$("#show_button_' . $row->id_anomaly .'").click(function(){ $( "#show_dialog_' . $row->id_anomaly . '" ).dialog(); });';
			$html .= '$("#edit_button_' . $row->id_anomaly .'").click(function(){ $( "#edit_dialog_' . $row->id_anomaly . '" ).dialog(); });';
			$html .= '$("#delete_button_' . $row->id_anomaly .'").click(function(){ $( "#delete_dialog_' . $row->id_anomaly . '" ).dialog(); });';
			$html .= '</script>';
		}
		return $html;
	}
}

/**
*$id_anomaly			: ID wich represent an anomaly in database
*$description_short 	: Short description of an anomaly
*$description 			: Full descriotion ( 255 char)
*$version 				: Version of the anomaly
*$status 				: Current status between { nouveau, assigné, rejeté, fermé }
*$priority 				: Priority between 1 to 3
*$anomaly_name 			: Anomaly name 
*/
function valideEdit($id_anomaly, $description_short, $description, $version, $status, $priority, $anomaly_name){
	if(!is_numeric ($id_anomaly) or sizeof($id_anomaly) > 11 or empty($id_anomaly)){
		return "Error - id";
	}
	
	if(sizeof($description_short) > 30 or empty($description_short)){
		return "Error - description_short";
	}
	
	if(sizeof($description) > 255 or empty($description)){
		return "Error - description";
	}
	
	if(sizeof($version) > 50 or empty($version)){
		return "Error - version";
	}
	
	if(sizeof($status) > 255 or empty($status)){
		return "Error - status";
	}
	
	if(sizeof($priority) > 11 or !is_numeric ($priority) or empty($priority)){
		return "Error - priority";
	}
	
	if(sizeof($anomaly_name) > 125 or empty($anomaly_name)){
		return "Error - anomaly_name";
	}
	
	return "ok";
}

/**
*$description_short 	: Short description of an anomaly
*$description 			: Full descriotion ( 255 char)
*$version 				: Version of the anomaly
*$status 				: Current status between { nouveau, assigné, rejeté, fermé }
*$priority 				: Priority between 1 to 3
*$anomaly_name 			: Anomaly name 
*/
function valideAdd($description_short, $description, $version, $status, $priority, $anomaly_name){
	
	if(sizeof($description_short) > 30 or empty($description_short)){
		return "Error - description_short";
	}
	
	if(sizeof($description) > 255 or empty($description)){
		return "Error - description";
	}
	
	if(sizeof($version) > 50 or empty($version)){
		return "Error - version";
	}
	
	if(sizeof($status) > 255 or empty($status)){
		return "Error - status";
	}
	
	if(sizeof($priority) > 11 or !is_numeric ($priority) or empty($priority)){
		return "Error - priority";
	}
	
	if(sizeof($anomaly_name) > 125 or empty($anomaly_name)){
		return "Error - anomaly_name";
	}
	
	return "ok";
}

/**
* This function validate parameter for comment before adding it to database
*
* $id_anomaly				: ID wich represent an anomaly in database
* $libelleCommentaire 		: Commentary for the anomaly
* $auteurComment 			: Author for the commentary
*/
function valideAddComment($id_anomaly, $libelleCommentaire, $auteurComment){
	
	if(!is_numeric($id_anomaly)){
		return "Error - id anomaly";
	}
	
	if(sizeof($libelleCommentaire) > 255 or empty($libelleCommentaire)){
		return "Error - libelleCommentaire";
	}
	
	if(sizeof($auteurComment) > 30 or empty($auteurComment)){
		return "Error - auteurComment";
	}
	
	return "ok";
}

/**
* This function return all rows from Anomaly table 
*/
function getAnomaly($wpdb){
	$Anomaly = $wpdb->get_results("SELECT * FROM Anomaly");
	return $Anomaly;
}

$selectOption = $_POST['taskOption'];

/**
* this function return the color for the priority
*/
function priorityColor($value){
		
		
		if ($value==1) {

			return '<td style="background-color:#f6ff02" >' . $value. "</td>";
		}
		else if ($value==2) {
			return '<td style="background-color:#ff4500" >' . $value. "</td>";
		}
		else  {
			return '<td style="background-color:#9acd32" >' . $value. "</td>";
		}

}

/**
* this function return the selected priority
*/
function selectPriority($value){
	
	if ($value=='1') {

			return '<select type="text" id="priority" name="priority"><option value="1" selected="selected"> 1 </option><option value="2"> 2 </option><option value="3"> 3 </option></select><br/>';
		}
		else if ($value=='2') {
			return '<select type="text" id="priority" name="priority"><option value="1"> 1 </option><option value="2" selected="selected"> 2 </option><option value="3"> 3 </option></select><br/>';
		}
		else  {
			return '<select type="text" id="priority" name="priority"><option value="1"> 1 </option><option value="2"> 2 </option><option value="3" selected="selected"> 3 </option></select><br/>';
		}
}

/**
* this function return the selected status
*/
function selectStatus($value){
	
	if ($value=='nouveau') {

			return '<select type="text" id="status" name="status"><option value="nouveau" selected="selected"> nouveau </option><option value="assigné"> assigné </option><option value="rejeté"> rejeté </option><option value="fermé"> fermé </option></select><br/>';
		}
		else if ($value=='rejeté') {
			return '<select type="text" id="status" name="status"><option value="nouveau"> nouveau </option><option value="assigné"> assigné </option><option value="rejeté" selected="selected"> rejeté </option><option value="fermé"> fermé </option></select><br/>';
		}
		else if ($value=='assigné') {
			return '<select type="text" id="status" name="status"><option value="nouveau"> nouveau </option><option value="assigné" selected="selected"> assigné </option><option value="rejeté"> rejeté </option><option value="fermé"> fermé </option></select><br/>';
		}
		else  {
			return '<select type="text" id="status" name="status"><option value="nouveau"> nouveau </option><option value="assigné"> assigné </option><option value="rejeté"> rejeté </option><option value="fermé"> fermé </option></select><br/>';
		}
}

/**
* this function return a failed message
*
* @stirng	: string that contain the source
*/
function failedAction($string){
	$html .= '<div class="alert alert-danger">';
	$html .= '<strong>Échec !</strong> ' . $string;
	$html .= '</div>';
	return $html;
}

/**
* this function return a success message
*
* @stirng	: string that contain the source
*/
function succedAction($string){
	$html .= '<div class="alert alert-success">';
	$html .= '<strong>Réussi !</strong> ' . $string;
	$html .= '</div>';
	return $html;
}
?>