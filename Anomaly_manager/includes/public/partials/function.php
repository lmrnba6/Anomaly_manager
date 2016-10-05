<?php
global $wpdb;

function parseResultsToTable($Anomaly){
	if( !empty( $Anomaly )){
		
		foreach($Anomaly as $key => $row){
			$html .= "<tr>";
			$html .= "<td>" . $row->anomaly_name . "</td>";
			$html .= "<td>" . $row->status . "</td>";
			$html .= "<td>" . $row->version . "</td>";
			$html .= "<td>" . $row->priority . "</td>";
			$html .= "<td>" . $row->description_short . "</td>";
			$html .= "<td><a class='show_button' id='show_button_" . $row->id_anomaly . "'><span class='glyphicon glyphicon-search'></span></a></td>";
			$html .= "<td><a class='delete_button' id='edit_button_" . $row->id_anomaly . "'><span class='glyphicon glyphicon-pencil'></span></a></td>";
			$html .= "<td><a class='delete_button' id='delete_button_" . $row->id_anomaly . "'><span class='glyphicon glyphicon-remove'></span></a></td>";
			$html .= "</tr>";
			
			//Hidden form for show 
			$html .= "<div class='dialog' id='show_dialog_" . $row->id_anomaly ."' style='display: none' >";
			$html .= '<form class="form" action="" id="show-form" >';
			$html .= '<input type="hidden" id="id_anomaly" name="id_anomaly" value="' . $row->id_anomaly . '" readonly />';
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
			$html .= '<input type="text" id="description" name="description" placeholder="Description" value="' . $row->description . '"readonly /><br/>';
			$html .='<label>Commentaire: <span>*</span></label><br/>';			
			$html .= '<input type="text" id="comment" name="comment" placeholder="Commentaire" value="' . $row->Comment . '"readonly /><br/>';
			$html .= '</form>';
			$html .= '</div>';
			
			//Hidden form for edit 
			$html .= "<div class='dialog' id='edit_dialog_" . $row->id_anomaly ."' title='Edit dialog' style='display: none'>";
			$html .= '<form class="form" action="" id="edit-form" method="post">';
			$html .= '<input type="hidden" id="type" name="type" value="edit"/>';
			$html .= '<input type="hidden" id="id_anomaly" name="id_anomaly" value="' . $row->id_anomaly . '"/>';
			$html .= '<label>Anomalie: <span>*</span></label><br/>';
			$html .= '<input type="text" id="anomaly_name" name="anomaly_name" placeholder="Anomalie" value="' . $row->anomaly_name .'"/><br/>';
			$html .= '<label>Status: <span>*</span></label><br/>';		
			$html .= '<input type="text" id="status" name="status" placeholder="Status" value="' . $row->status . '"/><br/>';
			$html .= '<label>Version: <span>*</span></label><br/>';			
			$html .= '<input type="text" id="version" name="version" placeholder="Version" value="' . $row->version . '"/><br/>';
			$html .= '<label>Priorité: <span>*</span></label><br/>';			
			$html .= '<input type="text" id="priority" name="priority" placeholder="Priorité" value="' . $row->priority . '"/><br/>';
			$html .= '<label>Description courte: <span>*</span></label><br/>';			
			$html .= '<input type="text" id="description_short" name="description_short" placeholder="Description" value="' . $row->description_short . '"/><br/>';
			$html .= '<label>Description: <span>*</span></label><br/>';			
			$html .= '<input type="text" id="description" name="description" placeholder="Description" value="' . $row->description . '"/><br/>';
			$html .='<label>Commentaire: <span>*</span></label><br/>';			
			$html .= '<input type="text" id="comment" name="comment" placeholder="Commentaire" value="' . $row->Comment . '"/><br/>';
			$html .= '<input type="submit" id="savebtn" value="Sauvegarder"/>';
			$html .= '</form>';
			$html .= '</div>';
			
			//Hidden form for delete 
			$html .= "<div class='dialog' id='delete_dialog_" . $row->id_anomaly ."' style='display: none'>";
			$html .= '<form class="form" action="" id="edit-form" method="post">';
			$html .= '<input type="hidden" id="type" name="type" value="delete"/>';
			$html .= '<input type="hidden" id="id_anomaly" name="id_anomaly" value="' . $row->id_anomaly . '"/>';
			$html .= '<p>Voulez-vous vraiment supprimer cette ligne ?</p>';
			$html .= '<input type="submit" id="deletebtn" value="Supprimer"/>';
			$html .= '</form>';
			$html .= '</div>';
			
			//JavaScript to show modal 
			$html .= '<script>';
			$html .= '$("#show_button_' . $row->id_anomaly .'").click(function(){ $( "#show_dialog_' . $row->id_anomaly . '" ).dialog(); });';
			$html .= '$("#edit_button_' . $row->id_anomaly .'").click(function(){ $( "#edit_dialog_' . $row->id_anomaly . '" ).dialog(); });';
			$html .= '$("#delete_button_' . $row->id_anomaly .'").click(function(){ $( "#delete_dialog_' . $row->id_anomaly . '" ).dialog(); });';
			$html .= '</script>';
		}
		return $html;
	}
}

function valideEdit($id_anomaly, $description_short, $description, $version, $status, $priority, $comment, $anomaly_name){
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
	
	if(sizeof($comment) > 75 or empty($comment)){
		return "Error - comment";
	}
	
	if(sizeof($anomaly_name) > 125 or empty($anomaly_name)){
		return "Error - anomaly_name";
	}
	
	return "ok";
}

function valideAdd($description_short, $description, $version, $status, $priority, $comment, $anomaly_name){
	
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
	
	if(sizeof($comment) > 75 or empty($comment)){
		return "Error - comment";
	}
	
	if(sizeof($anomaly_name) > 125 or empty($anomaly_name)){
		return "Error - anomaly_name";
	}
	
	return "ok";
}

function getAnomaly($wpdb){
	$Anomaly = $wpdb->get_results("SELECT * FROM Anomaly");
	return $Anomaly;
}

function failedAction($string){
	$html = "<p>Il y a une erreur de l\'opération suivante : " . $string ."<\p>";
	return $html;
}

function succedAction($string){
	$html .= '<p>';
	$html .= 'L\'opération suivante à réussi ! : ' . $string ;
	$html .= '<\p>';
	return $html;
}
?>