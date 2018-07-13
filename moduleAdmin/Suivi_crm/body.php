		<div class="col-lg-12">
			<br><br><br>
			<table class="table" id="table" style="background-color: #01528A; border: 2px solid;">
				<thead>
					<tr>
						<th>Date</th>
						<th>Type contact</th>
						<th>Action</th>
						<th>Projet</th>
						<th>Commentaire</th>
						<th>Action à réaliser</th>
						<th>Projet</th>
						<th>Commentaire</th>
						<th>Date</th>
						<th>Type contact</th>
						<th>statut</th>
					</tr>
				</thead>
			<tbody>
				<?php 
				$tab = get_crm($GLOBALS['GET']['client']);
				$len = count($tab);
				$i = 0;
				while ($i < $len) {
					if ($tab[$i]['finish']){
					echo "<tr class=\"success\">";
					 echo "<td>" . htmlspecialchars(($tab[$i]['date_r'])) . "</td>";
					 echo "<td><img style=\"width: 38px;\" src=\"" . ft_select_img($tab[$i]['MOC_R']) . "\"></td>";
					 echo "<td>" . stripcslashes(htmlspecialchars(ft_decrypt_crypt_information($tab[$i]['action_r']))) . "</td>";
					 echo "<td>" . "NULL" . "</td>";
					 echo "<td>" . stripcslashes(htmlspecialchars(ft_decrypt_crypt_information($tab[$i]['commentaire_r']))) . "</td>";
					 echo "<td>" . stripcslashes(htmlspecialchars(ft_decrypt_crypt_information($tab[$i]['action_f']))) . "</td>";
					 echo "<td>" . "NULL" . "</td>";
					 echo "<td>" . stripcslashes(htmlspecialchars(ft_decrypt_crypt_information($tab[$i]['commentaire_f']))) . "</td>";
					 echo "<td>" . htmlspecialchars(($tab[$i]['DATE_f'])) . "</td>";
					 echo "<td><img style=\"width: 38px;\" src=\"" . ft_select_img($tab[$i]['MOC_F']) . "\"></td>";
					 echo "<td><img style=\"width: 38px;\" src=\"img/success.ico\"></td>";
					echo "</tr>";
				} else {
				 echo "<tr class=\"warning\">";
					 echo "<td>" . htmlspecialchars(($tab[$i]['date_r'])) . "</td>";
					 echo "<td><img style=\"width: 38px;\" src=\"" . ft_select_img($tab[$i]['MOC_R']) . "\"></td>";
					 echo "<td>" . stripcslashes(htmlspecialchars(ft_decrypt_crypt_information($tab[$i]['action_r']))) . "</td>";
					 echo "<td>" . "NULL" . "</td>";
					 echo "<td>" . stripcslashes(htmlspecialchars(ft_decrypt_crypt_information($tab[$i]['commentaire_r']))) . "</td>";
					 echo "<td>" . stripcslashes(htmlspecialchars(ft_decrypt_crypt_information($tab[$i]['action_f']))) . "</td>";
					 echo "<td>" . "NULL" . "</td>";
					 echo "<td>" . stripcslashes(htmlspecialchars(ft_decrypt_crypt_information($tab[$i]['commentaire_f']))) . "</td>";
					 echo "<td>" . htmlspecialchars(($tab[$i]['DATE_f'])) . "</td>";
					 echo "<td><img style=\"width: 38px;\" src=\"" . ft_select_img($tab[$i]['MOC_F']) . "\"></td>";
					 echo "<td><a href=\"admin_lkje5sjwjpzkhdl42mscpi.php?p=Suivi&client=" . $GLOBALS['GET']['client'] . "&id=" . $tab[$i]['id'] . "\"><img style=\"width: 38px;\" src=\"img/wait.ico\"></a></td>";
					echo "</tr>";
					}
					$i++;
				}
					?>
				</tbody>
			</table>
			<br><br>
		</div>

				<a class="btn btn-default" data-toggle="modal" data-target="#myModal" style="position: absolute; right: 20px; bottom: 25px;"><img src="img/add.ico" style="width: 30px;"> Ajouter une tache ?</a>
<!--<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
		<div class="modal-body">
<form class="form-horizontal" <?php echo 'action="admin_lkje5sjwjpzkhdl42mscpi.php?p=Suivi&client=' . $GLOBALS['GET']['client'] .'"'; ?> method="post">
<fieldset>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/locales/bootstrap-datepicker.fr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/css/bootstrap-datepicker.css"/>

<div class="first-column">
<div class="col-lg-12" style="position: absolute; width: 47%; left : 4px;">
	
<div class="alert alert-warning" role="alert">
	<p style="font-style: bold;"><strong>DONE :</strong></p> 
</div>

<div class="form-group">
	<label class="col-ms-6 control-label">Action</label>
	<div class="col-md-12">
	<input id="choix_bieres" name="action" class="col-md-12" type="text" list="elements" required>
	<datalist id="elements">
	<select class="form-control">
		<option value="Demande d'information">1) Demande d'information</option>
		<option value="Envoi guide de l’investissement en SCPI">2) Envoi guide de l’investissement en SCPI</option>
		<option value="Envoi guide SCPI Fiscale">3) Envoi guide SCPI Fiscale</option>
		<option value="Envoi guide la déclaration">4) Envoi guide la déclaration</option>
		<option value="Envoi Guide du démembrement">5) Envoi Guide du démembrement</option>
		<option value="Envoi guide des acquisition">6) Envoi guide des acquisition</option>
		<option value="Envoi fiche explicative">7) Envoi fiche explicative</option>
		<option value="Envoi BT MeilleureSCPI.com">8) Envoi BT MeilleureSCPI.com</option>
		<option value="Echange sur le projet d'investissement">9) Echange sur le projet d'investissement</option>
		<option value="Document d'accompagnement (LM + QC + PI)">10) Document d'accompagnement (LM + QC + PI)</option>
		<option value="Envoi simulation">11) Envoi simulation</option>
		<option value="Envoi comparaison">12) Envoi comparaison</option>
		<option value="Envoi REC">13) Envoi REC</option>
		<option value="Envoi document de souscription">14) Envoi document de souscription</option>
		<option value="Eléments pour régularisation dossier de souscription">15) Eléments pour régularisation dossier de souscription</option>
		<option value="Envoi CNP">16) Envoi CNP</option>
		<option value="Suivi post-souscription">17) Suivi post-souscription</option>
		<option value="Suivi déclaration fiscale">18) Suivi déclaration fiscale</option>
		<option value="...">Autre ...</option>
	</select>
	</datalist>
	</div>
</div>

<div class="form-group">
	<label class="col-ms-6 control-label" for="date">Date</label>
	<div class="col-ms-6">
	<div class="input-group">
		<span class="input-group-addon">DATE</span>
		<input class="datepicker" name="date" class="form-control" type="text" <?php echo 'value="' . date("d/m/Y") . '"'; ?> required>
	</div>
	
	</div>
	 <script>
		
	 $('.datepicker').datepicker({
	 dateFormat: 'dd-mm-yy',
	 minDate: '+5d',
	 changeMonth: true,
	 changeYear: true,
	 altFormat: "yy-mm-dd",
	 language:"fr",
	 closeText: 'Fermer'
	});
</script>
</div>


<div class="form-group">
	<label class="col-ms-6 control-label" for="radios">Moyen de communication</label>
	<div class="col-ms-6"> 
	<label class="radio-inline" for="radios-0">
		<input type="radio" name="radios" id="radios-0" value="1" checked="checked">
		<img src="img/phone.ico" style="width: 50px;" alt="Téléphone">
	</label> 
	<label class="radio-inline" for="radios-1">
		<input type="radio" name="radios" id="radios-1" value="2">
		<img src="img/mail.ico" style="width: 50px;" alt="E-mail">
	</label> 
	<label class="radio-inline" for="radios-2">
		<input type="radio" name="radios" id="radios-2" value="3">
		<img src="img/letter.ico" style="width: 50px;" alt="Voie postale">
	</label> 
	<label class="radio-inline" for="radios-3">
		<input type="radio" name="radios" id="radios-3" value="4">
		<img src="img/info.ico" style="width: 50px;" alt="Demande d'informations">
	</label>
	</div>
</div>


<div class="form-group">
	<label class="col-ms-6 control-label" for="checkboxes">Project</label>
	<div class="col-ms-6">
	<div class="checkbox">
	<p class="help-block">Pas de projet crée.</p>
	</div>
	</div>
</div>

<div class="form-group">
	<label class="col-ms-6 control-label" for="commentaire">Commentaire</label>
	<div class="col-ms-6">					 
	<textarea class="form-control" id="textarea" name="commentaire" required></textarea>
	</div>
	<p class="help-block errormsg" style="color: red">Anomalie date incorrect</p>
</div>


</div>

<script>
function strcmp(str1,str2){
	return ( ( str1 == str2 ) ? 0 : ( ( str1 > str2 ) ? 1 : -1 ) );
}

$(document).ready(function(){

	var progress = setInterval(function() {
	var $date = $('.datepicker');
	var $datep = $('.datep');

	if (strcmp($datep.val(), $date.val()) >= 0)
		$('.errormsg').css('visibility', 'hidden');
	else
		$('.errormsg').css('visibility', 'visible');

	}, 200);
});

</script>
</div>

<div class="second-column col-lg-11">
	<div class="margin_for">


<div class="alert alert-warning" role="alert">
	<p style="font-style: bold;"><strong>TO DO :</strong></p> 
</div>
<div class="form-group">
	<label class="col-ms-6 control-label">Action</label>
	<div class="col-md-12">
	<input name="action_r" class="col-md-12" type="text" list="elements_r" required>
	<datalist id="elements_r">
	<select class="form-control">
		<option value="Demande d'information">1) Demande d'information</option>
		<option value="Envoi guide de l’investissement en SCPI">2) Envoi guide de l’investissement en SCPI</option>
		<option value="Envoi guide SCPI Fiscale">3) Envoi guide SCPI Fiscale</option>
		<option value="Envoi guide la déclaration">4) Envoi guide la déclaration</option>
		<option value="Envoi Guide du démembrement">5) Envoi Guide du démembrement</option>
		<option value="Envoi guide des acquisition">6) Envoi guide des acquisition</option>
		<option value="Envoi fiche explicative">7) Envoi fiche explicative</option>
		<option value="Envoi BT MeilleureSCPI.com">8) Envoi BT MeilleureSCPI.com</option>
		<option value="Echange sur le projet d'investissement">9) Echange sur le projet d'investissement</option>
		<option value="Document d'accompagnement (LM + QC + PI)">10) Document d'accompagnement (LM + QC + PI)</option>
		<option value="Envoi simulation">11) Envoi simulation</option>
		<option value="Envoi comparaison">12) Envoi comparaison</option>
		<option value="Envoi REC">13) Envoi REC</option>
		<option value="Envoi document de souscription">14) Envoi document de souscription</option>
		<option value="Eléments pour régularisation dossier de souscription">15) Eléments pour régularisation dossier de souscription</option>
		<option value="Envoi CNP">16) Envoi CNP</option>
		<option value="Suivi post-souscription">17) Suivi post-souscription</option>
		<option value="Suivi déclaration fiscale">18) Suivi déclaration fiscale</option>
		<option value="...">Autre ...</option>
	</select>
	</datalist>
	</div>
</div>


<div class="form-group">
	<label class="col-ms-6 control-label" for="date_r">Date prochaine action</label>
	<div class="col-ms-6">
	<div class="input-group">
		<span class="input-group-addon">DATE</span>
		<input id="prependedtext1" class="datep" style="padding: 4px;" name="date_r" class="form-control" <?php echo 'value="' . date("d/m/Y") . '"'; ?> type="text" required>
	</div>

	 <script>
	 $('.datep').datepicker({
	 dateFormat: 'dd-mm-yy',
	 changeMonth: true,
	 changeYear: true,
	 altFormat: "yy-mm-dd",
	 language:"fr",
	 closeText: 'Fermer'
	});
</script>

	</div>
</div>

<div class="form-group">
	<label class="col-ms-6 control-label" for="radios1">Moyen de communication</label>
	<div class="col-ms-6"> 
	<label class="radio-inline" for="radios-4">
		<input type="radio" name="radios1" id="radios-4" value="1" checked="checked">
		<img src="img/phone.ico" style="width: 50px;" alt="Téléphone">
	</label> 
	<label class="radio-inline" for="radios-5">
		<input type="radio" name="radios1" id="radios-5" value="2">
		<img src="img/mail.ico" style="width: 50px;" alt="E-mail">
	</label>
	<label class="radio-inline" for="radios-6">
		<input type="radio" name="radios1" id="radios-6" value="3">
		<img src="img/letter.ico" style="width: 50px;" alt="Voie postale">
	</label> 
	<label class="radio-inline" for="radios-7">
		<input type="radio" name="radios1" id="radios-7" value="4">
		<img src="img/info.ico" style="width: 50px;" alt="Demande d'informations">
	</label>
	</div>
</div>

<div class="form-group">
	<label class="col-ms-6 control-label" for="checkboxes2">Projet</label>
	<div class="col-ms-6">
	<div class="checkbox">
	<p class="help-block">Pas de projet crée.</p>
	</div>
	</div>
</div>

<div class="form-group">
	<label class="col-ms-6 control-label" for="commentaire_r">Commentaire</label>
	<div class="col-ms-6">					 
	<textarea class="form-control" id="textarea" name="commentaire_r" required></textarea>
	</div>
</div>

<div class="form-group">
	<label class="col-ms-6 control-label" for="singlebutton"></label>
	<div class="col-ms-6">
	<button id="singlebutton" name="singlebutton" value="42" class="btn btn-primary">Envoi</button>
	</div>
</div>
</div>
</div></fieldset>
</div>
</form>


		</div>
	</div>
	</div>
</div>-->
