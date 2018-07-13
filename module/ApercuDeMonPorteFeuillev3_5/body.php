<?php
$nb_transac = count($this->dh->getTransaction());
?>

<div class="module moduleApercuDeMonPorteFeuille">
	<div class="moduleTitle">
		<img src="<?=$this->getPath() . "img/Portefeuille-Blanc.svg"?>" alt="" />
		<span>APERCU DE MON PORTEFEUILLE</span>
		<div class="btn-mscpi-blanc" <?php if ($nb_transac > 0 && $this->dh->getConfirmation() == "3") { ?>onclick="window.open('index.php?p=ShowPatrimoine')" <?php } else { ?> onmouseover="display_tooltip('Information','Merci de valider votre numéro de téléphone et/ou votre mail pour accéder à votre récapitulatif.')" onmouseout="disable_msg()"<?php } ?>>
			<img src="<?= $this->getPath()?>img/telechargerblanc.png" alt="">
			<span class="txtDownloadRecap">TÉLÉCHARGER UN RÉCAPITULATIF</span>
		</div> 
<?php
	if (ENABLE_VALEUR_ISF && $this->dh->isf == 1) { 
		/*
		<button <?php if($nb_transac === 0) echo 'disabled'?> class="BtnStyle btnValeurIsf" onclick="window.open('index.php?p=ShowValeurIsf')"><span >VALEUR ISF <?=date('Y')?></span></button>
		*/
		?>
		<button <?php if($nb_transac === 0) echo 'disabled'?> class="BtnStyle btnValeurIsf" onclick="showMsgBoxIfi()"><span >VALEUR IFI <?=date('Y')?></span></button>
<?php } ?>
		<button data-toggle="modal" data-target="#add_scpi" class="BtnStyle btnAddScpi" ><img src="<?=$this->getPath()?>img/BTN-Plus_Blanc.png" /><span>AJOUTER UNE SCPI</span></button>
	</div>
	<div class="moduleContent">
<?php
$flagerror = 0;
if ($nb_transac !== 0) {

	$havePleine = 0;
	$haveNue = 0;
	$haveUsu = 0;
?>
			<table class="table tablePortefeuille" id="table" style="margin-bottom:0px" border="1">
				<thead style="background-color: #01528A;">
					<tr id="tbl_th">
						<th id="sortscpi" style="cursor:alias;" >Nom de la SCPI</th>
						<th style="cursor:alias;" class="mobile_resp">Nombre de parts</th>
						<th style="cursor:alias;" class="mobile_resp">Type de propriété</th>
						<th style="cursor:alias;" class="mobile_resp">Montant d’investissement</th>
						<th style="cursor:alias;">Montant global de revente (*)</th>
						<th style="cursor:alias;" class="mobile_resp">+ ou - value</th>
						<th style="cursor:alias;width: 260px;" class="mobile_resp"></th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach($this->data as $key => $elmData) {
						if ($key == 'precalcul')
							continue;
						foreach ($elmData as $key2 => $elmData2) {
							if ($key2 == 'precalcul')
								continue;
							$elm = $elmData2['precalcul'];

							$_p = strtolower(substr($elm["type_pro"], 0, 1));
							if (empty($elm['flagMissingInfo']))
							{
								if ($_p == 'p')
									$havePleine += $elm["MontantInvestissement"] ;
								else if ($_p == 'u')
									$haveUsu += $elm["MontantInvestissement"] ;
								else if ($_p == 'n')
									$haveNue += $elm["MontantInvestissement"] ;
							}
					?>
					<tr class="hover_blue_back <?php if ($elm['flagMissingInfo']){ echo "orange_back"; $flagerror = 1;}?>">
						<td style="cursor:pointer;" onclick="$('#modal_histotransac_<?=$elm['modal_link']?>').modal('show');isSellModal=false;"><?=substr($elm["name"],5)?></td>
						<td class="mobile_resp" style="cursor:pointer;" onclick="$('#modal_histotransac_<?=$elm['modal_link']?>').modal('show');isSellModal=false;"><?= ($elm["nbr_part"] < 1) ? number_format($elm["nbr_part"], getNFP($elm["nbr_part"]), '.', ' ') : (string)$elm["nbr_part"] ?></td>
						<td class="mobile_resp" style="cursor:pointer;" onclick="$('#modal_histotransac_<?=$elm['modal_link']?>').modal('show');isSellModal=false;"><?=$elm["type_pro"]?></td>
						<td class="mobile_resp" style="cursor:pointer;" onclick="$('#modal_histotransac_<?=$elm['modal_link']?>').modal('show');isSellModal=false;">
							<?php
							if (!$elm['flagMissingInfo']) {
								echo number_format($elm["MontantInvestissement"], 2, ",", " ") . " €";
							} else {
								echo "-";
							}
							?>
						</td>
						<td style="cursor:pointer;" onclick="$('#modal_histotransac_<?=$elm['modal_link']?>').modal('show');isSellModal=false;"><?=number_format($elm["ventePotentielle"], 2, ",", " ")?> €</td>
						<?php
						if (is_numeric($elm["plusMoinValuePourcent"]) && !$elm['flagMissingInfo'] && !strstr($elm["type_pro"], "Usu")) {
							?>
							<td class="mobile_resp" style="cursor:pointer;" onclick="$('#modal_histotransac_<?=$elm['modal_link']?>').modal('show');isSellModal=false;"><?php echo (number_format($elm["plusMoinValuePourcent"], 2, ",", " ")); ?> %</td>
							<?php
						} else {
							?>
							<td class="mobile_resp" style="cursor:pointer;" onclick="$('#modal_histotransac_<?=$elm['modal_link']?>').modal('show');isSellModal=false;">-</td>
							<?php
						}
						?>
							<td style="padding:3px" class="mobile_resp cursor_big" id="btn_opt"><div class="reinvestirBtn"  data-toggle="modal" data-target=".modal_addnew<?=$elm['modal_link']?>">Réinvestir</div>
							<?php
							if (!strstr($elm['type_pro'], "Usu") && $elm["nbr_part"] > 0) {
								?>
									<div class="vendreBtn" data-toggle="modal" data-target=".modal_del<?=$elm['modal_link']?>">Vendre</div></td>
								<?php
							}
							?>
					</tr>
										<!--<div <?php echo 'class="modal fade modal_del' . $elm['modal_link']. '"'; ?> tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
											<div class="modal-backdrop fade in"></div>
											<div class="modal-dialog" style="z-index:3100">
												<div class="modal-content" style="background-color:#EBEBEB;">
													<div class="modal-body">
														<div data-dismiss="modal" aria-label="Close" class="btn_close_prepapre">
															<span aria-hidden="true" class="btn_close">×</span>
														</div>
														<h2 style="text-align: center;">Information</h2>
														<div>
															<hr class="hr_bar">
														</div>
														<div class="row" style="margin-top: 30px;">
															<div class="col-md-6">
																<div class="btn-left" data-toggle="modal" data-target="#modal_sellPart">
																	<p class="btn_text">RETIRER DES PARTS<br />DE MON PORTEFEUILLE</p>
																</div>
															</div>

															<div class="col-md-6">
															<div class="btn_right" data-toggle="modal"  data-dismiss="modal" onclick="demandeContact('contact vente', <?=$elm["scpi"]->id?>)" style="">
																	<p class="btn_text">VENDRE MES PARTS</p>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>-->
<?php

ob_start();
?>
<div class="modal fade modal_del<?= $elm['modal_link'] ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog" style="z-index:3100 !important">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="<?= $this->getPath() ?>img/Close-Jaune.svg" alt="" /></button>
				<h4 class="modal-title text-center">Information</h4>
				<div class="trait" style="margin: 15px auto !important;"></div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<button class="btn_left" onclick="msgBox.show('Merci de renseigner votre vente à partir de votre transaction d\'achat')">J'ai vendu<br />des parts et<br />souhaite renseigner<br />mon portefeuille</button>
					</div>
					<div class="col-md-6">
						<button class="btn_right" data-toggle="modal" data-dismiss="modal" onclick="demandeContact('contact vente', <?= $elm["scpi"]->id ?>)">Je souhaite vendre<br />des parts et<br />être accompagné<br />par Meilleurescpi.com</button>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				&nbsp;
			</div>
		</div>
	</div>
</div>
<?php
$this->modal_content .= ob_get_contents();
ob_end_clean();

?>
										<!--  Ajouter des part a une Scpi -->
										<div <?php echo 'class="modal fade modal_addnew' . $elm['modal_link']. '"'; ?> tabindex="-1"  role="dialog" aria-labelledby="myLargeModalLabel">
											<div class="modal-backdrop fade in"></div>
											<div class="modal-dialog" style="z-index:1100">
												<div class="modal-content" style="background-color:#EBEBEB;">
													<div class="modal-body">
														<div data-dismiss="modal" aria-label="Close" class="btn_close_prepapre">
															<span aria-hidden="true" class="btn_close">×</span>
														</div>
														<h2 style="text-align: center;">Information</h2>
														<div>
															<hr class="hr_bar">
														</div>
														<div class="row" style="margin: 30px 0;">


															<div class="col-md-6">
																<div class="btn_left" data-toggle="modal" data-dismiss="modal" data-target="#add_scpi" onclick="setModalNewFixed(<?=$elm['id_scpi']?>,'<?=$elm['type_pro']?>')">
																	<p class="btn_text">AJOUTER DES PARTS<br>QUE JE DÉTIENS DEJA</p>
																</div>
															</div>
															<div class="col-md-6">
																<div class="btn_right" data-toggle="modal"  data-dismiss="modal"  onclick="demandeContact('contact achat', <?=$elm["scpi"]->id?>)" style="">
																	<p class="btn_text">JE SOUHAITE REINVESTIR DANS CETTE SCPI</p>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
					<?php
					}
}
?>
				</tbody>
			</table>
			<table class="table tableTotal">
				<tbody>
					<?php
					if ($havePleine) {
					?>
					<tr id="tbl_tt" class="Total">
						<td class='mobile_resp'></td>
						<td class='mobile_resp'></td>
						<td style="text-align:center;">Total Pleine Propriété :</td>
						<td class='mobile_resp'><?= number_format($havePleine, 2, ",", " "); ?>  €</td>
						<td><?=number_format($this->data['precalcul']['ventePotentiellePleine'], 2, ",", " ")?> €</td>
						<?php if (is_numeric($this->data['precalcul']['plusMoinValuePourcentPleine']) && !$this->data['precalcul']['flagMissingInfoPleine']) { ?>
							<td class='mobile_resp'><?=number_format($this->data['precalcul']['plusMoinValuePourcentPleine'] , 2, ",", " ")?> %</td>
						<?php } else { ?>
							<td class='mobile_resp'>-</td>
						<?php } ?>
						<td class='mobile_resp'></td>
					</tr>
					<?php
					}
					if ($haveNue) {
					?>
					<tr id="tbl_tt" class="Total">
						<td class='mobile_resp'></td>
						<td class='mobile_resp'></td>
						<td style="text-align:center;">Total Nue Propriété :</td>
						<td class='mobile_resp'><?=number_format($haveNue, 2, ",", " ")?>  €</td>
<?php if (is_numeric($this->data['precalcul']['ventePotentielleNue']) && $this->data['precalcul']['ventePotentielleNue'] > 0) { ?>
						<td><?=number_format($this->data['precalcul']['ventePotentielleNue'], 2, ",", " ")?> €</td>
<?php } else { ?>
							<td class='mobile_resp'>-</td>
<?php }  
	  if (is_numeric($this->data['precalcul']['plusMoinValuePourcentNue']) && !$this->data['precalcul']['flagMissingInfoNue']) { ?>
							<td class='mobile_resp'><?=number_format($this->data['precalcul']['plusMoinValuePourcentNue'] , 2, ",", " ")?> %</td>
<?php } else { ?>
							<td class='mobile_resp'>-</td>
<?php } ?>
						<td class='mobile_resp'></td>
					</tr>
					<?php
					}
					if ($haveUsu) {
					?>
					<tr id="tbl_tt" class="Total">
						<td class='mobile_resp'></td>
						<td class='mobile_resp'></td>
						<td style="text-align:center;">Total Usufruit : </td>
						<td class='mobile_resp'><?=number_format($haveUsu, 2, ",", " ")?>  €</td>
						<td><?=number_format($this->data['precalcul']['ventePotentielleUsu'], 2, ",", " ")?> €</td>
						<td class='mobile_resp'></td>
						<td class='mobile_resp'></td>
					</tr>
					<?php
					}
					?>
					<tr id="tbl_tt" style="background-color: #01528A;">
						<th class='mobile_resp'></th>
						<th class='mobile_resp'></th>
						<th style="text-align:center;">Total : </th>
						<th class='mobile_resp'><?=number_format($havePleine + $haveNue + $haveUsu, 2, ",", " ")?>  €</th>
						<th><?=number_format($this->data['precalcul']['ventePotentielle'], 2, ",", " ")?> €</th>
						<?php if (is_numeric($this->data['precalcul']['plusMoinValuePourcent']) && !$this->data['precalcul']['flagMissingInfo']
							&& !$this->data['precalcul']['haveUsu'] && !$this->data['precalcul']['haveNue']) { ?>
							<th class='mobile_resp'><?=number_format($this->data['precalcul']['plusMoinValuePourcent'] , 2, ",", " ")?> %</th>
						<?php } else { ?>
							<th class='mobile_resp'>-</th>
						<?php } ?>
						<th class='mobile_resp'></th>
					</tr>
				</tbody>
			</table>
			<div style="text-align:left;width:100%;margin-top: 5px;margin-left: 10px;">
				<span style="font-size:12px;font-weight:400;color:#505050;font-style:italic;">* Il s'agit du montant estimé potentiel de revente. Pour toute demande, merci de nous contacter : contact@meilleurescpi.com</span>
			</div>
</div>
    <script type="text/javascript">

    $(document).ready(function() 
    { 
        $("#table").tablesorter(); 
		$("#sortscpi").click();
	})
    </script>

<?php } else
		{
			 if (!isset($GLOBALS['haveNotif']) || !$GLOBALS['haveNotif']){
		?>
<div class="modal fade modal_push_scpi in" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="false">
	<div class="modal-backdrop fade in"></div>
	<div class="modal-backdrop fade in"></div>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div data-dismiss="modal" aria-label="Close" class="btn_close_prepapre">
					<span aria-hidden="true" class="btn_close">×</span>
				</div>
				<h2 style="text-align: center; font-size: 36px; font-family: Montserrat;">BIENVENUE</h2>
				<div>
					<hr class="hr_bar">
				</div>
				<p style="font-size: 24px; text-align: center; color: grey; font-weight: bold;">Votre portefeuille est actuellement vide.</p>
				<div class="row" style="margin-top: 30px;">
					<div class="col-sm-6 col-xs-12">
						<div class="btn-left" data-toggle="modal" data-target="#add_scpi" onclick="setModalNewFixed(<?=$elm['id_scpi']?>,'<?=$elm['type_pro']?>')">
							<p class="btn_text">AJOUTER DES SCPI<br>QUE JE DÉTIENS</p>
						</div>
					</div>
					<div class="col-sm-6 col-xs-12 margin_response">
						<div class="btn_right"  data-dismiss="modal" data-toggle="modal" data-target="#modaleContact" style="">
							<p class="btn_text">INVESTIR DANS UNE SCPI</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" charset="utf-8">
	setTimeout(function() {
		$('.modal_push_scpi').modal('show');
	}, 5000);
</script>
<?php 
}
?>
		<div class="col-md-12">
			<div class="alert alert-info" role="alert" style="width: 100%;margin-top: 30px;">
					<strong>Mon portefeuille est vide ? </strong>
					Je peux dès à présent commencer à ajouter mes SCPI en cliquant sur <br>
					<button data-toggle="modal" data-target="#add_scpi" class="BtnStyle  btnNewAdd btnAddScpi">
						<img src="<?=$this->getPath()?>img/BTN-Plus_Blanc.png" /><span > AJOUTER UNE SCPI</span>
					</button>
				</div>
		</div>
	</div>
<?php
}
?>
<?= $this->modal_content ?>
<?php include($this->getPath() . "modal_sellPart.php"); ?>
	</div>

<div class="modal fade" id="modaleContact" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document" style="width: 600px !important;">
		<div class="modal-content">
			<div class="modal-header">
				<div data-dismiss="modal" aria-label="Close" class="btn_close_prepapre">
					<span aria-hidden="true" class="btn_close">×</span>
				</div>
				<h4>Contact</h4>
			</div>
			<div class="traitOrange"></div>
			<div class="modal-body">
				<p>Un conseiller à été notifié de votre demande et prendra contact avec vous très bientôt.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn-mscpi" data-dismiss="modal">Fermer</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
