<script>
var i = 1;
function display_btn(){
	if (i % 2)
		window.location = <?php echo '"index.php?p=monportefeuille&active=' . $_COOKIE['token'] . '#edit"'; ?>;
	else
		window.location = "index.php?p=monportefeuille#edit";
	i++;
}
</script> 

<div class="modal fade mdlNew" id="add_scpi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="background-color:#EBEBEB">
			<div class="modal-header" style="margin-top: 10px;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="<?=$this->getPath()?>img/Close-Jaune.svg" alt="" /></button>
				<h4 class="modal-title">UNE SCPI QUE JE DÉTIENS PAR AILLEURS</h4>
			</div>
			<div class="traitOrange"></div>
			<div class="modal-body">
				<form class="form-horizontal formAddNewScpi" method="POST" action="?p=Portefeuille">
					<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
					<fieldset>
						<!-- Select Basic -->
						<div class="form-group">
							<label class="col-xs-4 control-label" for="SCPI"><img src="<?=$this->getPath()?>img/tooltip.ico" onmouseover="display_tooltip('Nom de la SCPI', 'Sélectionnez votre SCPI')" onmouseout="disable_msg(event)" style="width: 20px;"> Nom de la SCPI ? *</label>
							<div class="col-xs-4">
								<select id="SCPI" name="SCPI" class="form-control" style="border: 2px solid #018A13">
								<?php
									
									$this->lst_scpi = Scpi::getShowList();
									foreach ($this->lst_scpi as $elem)
									{
										echo '<option value="' , $elem->id ,  '">' , substr($elem->name, 4) , '</option>';
									}
								?>
								</select>
							</div>
							<img class="valid" style="display:block" src="<?=$this->getPath()?>img/valid.png">
						</div>

						<!-- Text input-->
						<div class="form-group">
							<label class="col-xs-4 control-label" for="part"><img src="<?=$this->getPath()?>img/tooltip.ico" onmouseover="display_tooltip('Nombre de parts achetées', 'Nombre de parts souscrites')" onmouseout="disable_msg(event)" style="width: 20px;"> Nombre de parts achetées *</label>
							<div class="col-xs-4">
								<input id="part" name="part" type="text" pattern="\d+((\.|,)(\d{1,5}))?" placeholder="Nombre de part" class="form-control input-md" required>
							</div>
							<img class="valid2" src="<?=$this->getPath()?>img/valid.png"> <img class="erreur2" src="<?=$this->getPath()?>img/warning.ico">
						</div>
						<!-- Select Basic -->
						<div class="form-group">
							<label class="col-xs-4 control-label" for="propriete"><img src="<?=$this->getPath()?>img/tooltip.ico" onmouseover="display_tooltip('Type de propriété', 'Sélectionner le type de propriété')" onmouseout="disable_msg(event)" style="width: 20px;"> Type de propriété</label>
							<div class="col-xs-4">
							<select id="propriete" name="propriete" class="form-control">
								<option value="Pleine propriété">Pleine propriété</option>
								<option value="Nue propriété">Nue propriété</option>
								<option value="Usufruit">Usufruit</option>
							</select>
							</div>
							<img class="valid" style="display:block;" src="<?=$this->getPath()?>img/valid.png"> <img class="erreur5" src="<?=$this->getPath()?>img/warning.ico">
						</div>

						<div id="moredtl">

							<div class="form-group">
								<label class="col-xs-4 control-label" for="cle">Clé de répartition %</label>	
								<div class="col-xs-4">
									<input id="cle" name="cle" pattern="\d{1,2}((\.|,)(\d{1,5}))?" type="text" placeholder="" class="form-control input-md">
								</div>
								<img class="valid1" src="<?=$this->getPath()?>img/valid.png"><img class="erreur1" src="<?=$this->getPath()?>img/warning.ico">
							</div>
							
							<div class="form-group">
								<label class="col-xs-4 control-label">Type de démembrement</label>	
								<div class="col-xs-4">
									<select id="type_demembrement" name="type_demembrement" class="form-control" >
										<option value="temporaire">Temporaire</option>
										<option value="viage">Viager</option>
									</select>
								</div>
								<img class="valid1" src="<?=$this->getPath()?>img/valid.png"><img class="erreur1" src="<?=$this->getPath()?>img/warning.ico">
							</div>
							
							<div class="form-group" id="demembrement">
								<label class="col-xs-4 control-label" for="duree">Durée de démembrement (en années)</label>
								<div class="col-xs-4">
									<input id="duree" name="duree" min="1" max="20" type="number" placeholder="" class="form-control input-md">
								</div>
								<img class="valid6" src="<?=$this->getPath()?>img/valid.png"> <img class="erreur6" src="<?=$this->getPath()?>img/warning.ico">
							</div>
						</div>

						<!-- Text input-->
						<div class="form-group visibility_form">
							<label class="col-xs-4 control-label" for="date">
								<img src="<?=$this->getPath()?>img/tooltip.ico" onmouseover="display_tooltip('Date d\'enregistrement', 'Date où votre souscription a été enregistrée par la société de gestion')" onmouseout="disable_msg(event)" style="width: 20px;">
								Date d'enregistrement
							</label>
							<div class="col-xs-4">
							<?php
							if (!isMobile())
							{
								?>
								<input style="1px solid #ccc" id="date" name="date" type="text" placeholder="" class="form-control input-md dateenr" <?php /*echo 'value="' . date("Y-m-d") . '"'; */?> >
								<?php
							}
							else
							{
								?>
								<input style="1px solid #ccc" id="date" name="date" type="date" max="<?=date("Y-m-d")?>" placeholder="" class="form-control input-md dateenr" <?php /*echo 'value="' . date("Y-m-d") . '"'; */?> >
								<?php
							}
							?>
							</div>
							<img class="valid valid9" src="<?=$this->getPath()?>img/valid.png"><img style="display:block;" class="erreur erreur9" src="<?=$this->getPath()?>img/warning.ico">
						</div>
						
						<div class="more_dt">

							<div class="form-group visibility_form">
								<label class="col-xs-4 control-label" for="prix">Prix de la part en Pleine propriété (frais compris)</label>
								 <div class="col-xs-4">
									 <input id="prix" name="prix" type="number" min="1" step="0.00001" placeholder="Prix d'achat de(s) part(s) €" class="form-control input-md">
								 </div>
								<img class="valid valid8" src="<?=$this->getPath()?>img/valid.png"> <img	style="display:block;" class="erreur erreur8" src="<?=$this->getPath()?>img/warning.ico">
							</div>
							<div class="form-group">
								<label class="col-xs-4 control-label" for="marche">Marché ?<p class="help-block">Sélectionner un type de marché</p></label>
								<div class="col-xs-4">
									<select id="marche" name="marche" class="form-control">
										<option value="-">-</option>
										<option value="Primaire">Primaire</option>
										<option value="Secondaire">Secondaire</option>
										<option value="Gris à gris">Gré à gré</option>
									</select>
								</div>
								<img class="valid3" src="<?=$this->getPath()?>img/valid.png"> <img class="erreur3" src="<?=$this->getPath()?>img/warning.ico">
							</div>
							
							<!-- Text input-->
							<div class="form-group">
								<label class="col-xs-4 control-label" for="transaction">Transaction effectuée ?</label>	
								<div class="col-xs-4">
									 <select id="transaction" name="transaction" class="form-control">
										<option value="-">-</option>
										<option value="Société de gestion">avec une Société de gestion</option>
										<option value="CGPI">avec un CGPI</option>
										<option value="Banque">avec ma Banque</option>
										<option value="Assureur">avec mon Assureur</option>
									</select>
								</div>
								<img class="valid4" src="<?=$this->getPath()?>img/valid.png"><img class="erreur4" src="<?=$this->getPath()?>img/warning.ico">
							</div>

							<div class="more_info">
								<div class="form-group">
									<label class="col-xs-4 control-label" for="informations" id="preci">Une précision ?</label>	
									<div class="col-xs-4">
										 <input id="informations" name="informations" type="text" placeholder="" class="form-control input-md">
									</div>
									<img class="valid7" src="<?=$this->getPath()?>img/valid.png"> <img class="erreur7" src="<?=$this->getPath()?>img/warning.ico">
								</div>
							</div>

							<script>
								$("#transaction").change(function (){
									if ($("#transaction option:selected").val() == "Société de gestion"){
										$("#preci").html("Quelle " + $("#transaction option:selected").val().toLowerCase() + " ?");
										document.getElementById("informations").setAttribute("disabled", "1");
										document.getElementById("preci").style.visibility = "hidden";
										document.getElementById("informations").setAttribute("placeholder", "Avec la societe de gestion directement");
									}
									else if ($("#transaction option:selected").val() == "Banque")
									{
								document.getElementById("informations").removeAttribute("disabled");
								$("#preci").html("Quelle " + $("#transaction option:selected").val().toLowerCase() + " ?");
										document.getElementById("informations").setAttribute("placeholder", "");
										document.getElementById("preci").style.visibility = "block";
									}
									else
									{
								document.getElementById("informations").removeAttribute("disabled");
										document.getElementById("preci").style.visibility = "block";
										document.getElementById("informations").setAttribute("placeholder", "");
										$("#preci").html("Quel " + $("#transaction option:selected").val().toLowerCase() + " ?");
									}
								})
							</script>
							<div class="form-group">
								<label class="col-xs-4 control-label">Montant emprunté ?</label>
								<div class="col-xs-4">
									<input id="montant_credit" name="montant_credit" type="text" class="form-control" value="" >
								</div>
							</div>
							<div class="form-group">
								<label class="col-xs-4 control-label">Durée de l'emprunt (en mois)</label>
								<div class="col-xs-4">
									<input id="duree_credit" name="duree_credit" type="text" class="form-control" value="" >
								</div>
							</div>
							<div class="form-group">
								<label class="col-xs-4 control-label">Date de début</label>
								<div class="col-xs-4">
							<?php
							if (!isMobile())
							{
								?>
								<input style="1px solid #ccc" id="date_debut_credit" name="date_debut_credit" type="text" placeholder="" class="form-control input-md" <?php /*echo 'value="' . date("Y-m-d") . '"'; */?> >
								<?php
							}
							else
							{
								?>
								<input style="1px solid #ccc" id="date_debut_credit" name="date_debut_credit" type="date" max="<?=date("Y-m-d")?>" placeholder="" class="form-control input-md" <?php /*echo 'value="' . date("Y-m-d") . '"'; */?> >
								<?php
							}
							?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-xs-4 control-label">Taux de l'emprunt</label>
								<div class="col-xs-4">
									<input id="taux_credit" name="taux_credit" type="text" class="form-control" value="" >
								</div>
							</div>
							<div class="form-group">
								<label class="col-xs-4 control-label">Mensualité</label>
								<div class="col-xs-4">
									<input id="mensualite_credit" name="mensualite_credit" type="text" class="form-control" value="" >
								</div>
							</div>
						</div>

						<div class="modal-footer">
							<div class="form-group">
								<label class="col-md-6 control-label" for="button2id">Une question ? Contactez nous au 0 805 696 022 (appel gratuit depuis un fixe).</label>
								<div class="col-md-6">
									<input type="hidden" name="isMore" id="isMore" value="0" />
									<button id="button2id" name="button2id" value="addTransaction" class="btn-add-scpi">Ajouter à mon portefeuille</button>
									<button onclick="event.preventDefault();more_info_scpi()" class="btn-more-info  btn_more_dt">Plus de détails</button>
								</div>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
function more_info_scpi()
{
	if ($(".more_dt").css('display') == "none"){
		$(".more_dt").css("display", "block");
		$(".visibility_form").css("visibility", "visible");
		$(".btn_more_dt").html("Moins de détails");
		$("#isMore").val("1");
//		$('.more_dt div div input').attr('required', '1');
	}
	else{
		$(".more_dt").css('display', "none");
		$(".visibility_form").css("visibility", "hidden");
		$(".btn_more_dt").html("Plus de détails");
		$('.more_dt div div input').val("");
		$("#isMore").val("0");
//		$('.more_dt div div input').removeAttribute('required');
	}
}
 </script>
