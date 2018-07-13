 <?php
$link = 'modal_' . $keyType . '_' .  str_replace(array(' ', '"', "'"), '_' , $name);
?>
<div <?php echo 'class="modal modalEditTrans mdl fade ' . $link . '" id="' . $keyType . '_' .  str_replace(' ', '_' , $name) . '"'; ?> tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-lg" style="width: 90%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" style="text-align: center;">MeilleureSCPI.com - <?php echo htmlspecialchars(substr($name, 5)); ?>
				<?php
				if ($keyType === "Pleine") {
					echo " - Pleine propriété";
				}
				else if ($keyType === "Usu") {
					echo " - Usufruit";
				} else {
					echo " - Nue propriété";
				}
				?>
				<h4>
			</div>
			<form method="post" action="?p=Portefeuille">
				<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
				<div class="modal-body">

<?php
ob_start();
?>
					<div class="tablePortefeuille">
						<table class="table table_modal">
	<tbody>
		<?php
		$tmp = 0;
		//ob_start();
		$compteur = 0;
		$haveNoDate = false;
		foreach ($dataType as $key => $buy) {
		if ($key == "precalcul")
			continue;
		$compteur++;
		?>
		<tr style="background-color:#cdcdcd;"
			<?php 
			//if ($haveNoDate && ($buy['buy']->getEnrDate() instanceof DateTime)) {
			 if ($haveNoDate && (!$buy['precalcul']['flagMissingInfo'])) {
				$haveNoDate = false;
				echo " class='endNoDate' ";
			}
			?>
		>
			<?php
			if (strstr($keyType, "Usu")) {
			?>
				<td colspan="13" style="padding: 4px;font-weight: 800;">
			<?php } else if (strstr($keyType, "Nue")) { ?>
				<td colspan="15" style="padding: 4px;font-weight: 800;">
			<?php
			} else { ?>
				<td colspan="10" style="padding: 4px;font-weight: 800;">
			<?php
			}
			if ($compteur === 1 && $buy['precalcul']['flagMissingInfo']) {
				$haveNoDate = true;
			?>
				<div class="blockContour">
				</div>
				<?php
			}
			?>
			<?=$compteur?> : Transaction du <?php
				if ($buy['buy']->getEnrDate() instanceof DateTime)
					echo $buy['buy']->getEnrDate()->format("d/m/Y");
				else
					echo "-";
				?>
			</td>
		</tr>
		<tr style="background-color: #01528A;" class="alignChildMiddle">
			<th onmouseover="display_tooltip_table_head('Type de transaction', 'Achat - Vente - Fusion.',event)" onmouseout="disable_msg(event)" style="cursor:help;">Type de transaction</th>
			<th  onmouseover="display_tooltip_table_head('Date de la transaction', 'Date où la transaction a été enregistrée',event)" onmouseout="disable_msg(event)" style="cursor:help;">Date de la transaction</th>
			<th  onmouseover="display_tooltip_table_head('Type de propriété', 'Pleine-propriété, nue-propriété ou usufruit',event)" onmouseout="disable_msg(event)" style="cursor:help;">Type de propriété</th>
			<?php
			if ($keyType != "Pleine") {
				?>
				<th  onmouseover="display_tooltip_table_head('Clé de repartition', 'Clé de répartition de la nue propriété ou de l\'usufruit ',event)" onmouseout="disable_msg(event)" style="cursor:help;">Clé de répartition</th>
				<th  onmouseover="display_tooltip_table_head('Durée', 'Durée en nombre d\'années du démembrement ',event)" onmouseout="disable_msg(event)" style="cursor:help;">Durée</th>
				<th  onmouseover="display_tooltip_table_head('Durée', 'Durée en nombre d\'années du démembrement ',event)" onmouseout="disable_msg(event)" style="cursor:help;">Debut Jouissance</th>
				<th  onmouseover="display_tooltip_table_head('Durée', 'Durée en nombre d\'années du démembrement ',event)" onmouseout="disable_msg(event)" style="cursor:help;">Fin Demembrement</th>
				<th  onmouseover="display_tooltip_table_head('Durée', 'Durée en nombre d\'années du démembrement ',event)" onmouseout="disable_msg(event)" style="cursor:help;">Jours restant</th>
				<?php
			}
			?>
			<th  onmouseover="display_tooltip_table_head('Nombre de part(s)', 'Nombre de part(s) détenue(s)',event)" onmouseout="disable_msg(event)" style="cursor:help;">Nombre de part(s)</th>
			<th  onmouseover="display_tooltip_table_head('Prix par part', 'Prix d\'achat frais compris ou prix de revente (net vendeur) ou prix moyen d\'achat.', event)" onmouseout="disable_msg(event)" style="cursor:help;">Prix par part</th>
			<th  onmouseover="display_tooltip_table_head('Montant de la transaction', 'Si achat : prix d\'achat x nombre de parts. <br />Si vente prix de vente x nombre de parts',event )" onmouseout="disable_msg(event)" style="cursor:help;">Montant de la transaction</th>
			<th  onmouseover="display_tooltip_table_head('Valeur potentielle de revente', 'Valeur dans le cas d\'une revente à la valeur de retrait ou du prix d\'execution',event)" onmouseout="disable_msg(event)" style="cursor:help;">Valeur potentielle de revente</th>
			<?php if (!strstr($keyType, "Usu")){ ?>
				<th  onmouseover="display_tooltip_table_head('+ ou - value en %', 'potentielle pour les parts détenues, réalisée  avant fiscalité pour les parts cédés en %', event)" onmouseout="disable_msg(event)" style="cursor:help;">+ ou - value en %</th>
				<th  onmouseover="display_tooltip_table_head('+ ou - value en euros', 'potentielle pour les parts détenues, réalisée avant fiscalité pour les parts cédés en valeur',event)" onmouseout="disable_msg(event)" style="cursor:help;">+ ou - value en euros</th>
			<?php } ?>
				<th  onmouseover="display_tooltip_table_head('Action', '.',event)" onmouseout="disable_msg(event)" style="cursor:help;">Action</th>
		</tr>
		<?php
			//ob_start();
			if (!isset($buy["buy"]))
				continue ;
		?>
		<tr class="toSlide toSlide_<?=$key?>">
			<!--<td><?=substr($buy["buy"]->getScpi()->name, 5)?></td>-->
			<td>
				Achat
				<?php
					if ($buy['precalcul']['doByMscpi'])
					{
						?>
						<div class="doMscpi">
							<div></div>
						</div>
						<?php
					}
					if ($buy['precalcul']['doByOther'])
					{
						?>
						<div class="doOther"></div>
						<?php
					}
				?>
			</td>
			<td style="position:relative;">
				<?php 
				if ($buy["buy"]->getEnrDate() instanceof DateTime)
					//echo $buy["buy"]->getEnrDate()->format("d/m/Y");
					echo ft_decrypt_crypt_information($buy["buy"]->enr_date);
				else {
				?>
					<span >-</span>
				<?php
				}
				?>
			</td>
			<td ><?=$buy["buy"]->getTypePro()?></td>
			<?php
			if ($buy["buy"]->getTypePro() != "Pleine propriété") {
				?>
				<td ><?=number_format($buy["buy"]->getClefRepartition(), 2, ",", " ")?> %</td>
				<td><?=$buy["buy"]->getDemembrementStr()?></td>
				<td><?=$buy["buy"]->getDelaiJouissance()->getEntreeJouissanceStr()?></td>
				<td><?=$buy["buy"]->getDelaiJouissance()->getSortieJouissanceStr()?></td>
				<td><?=$buy["buy"]->getNombreJoursRestant()?></td>
				<?php
			}
			?>
			<td ><?=$buy["buy"]->getNbrPart()?></td>
			<td style="position:relative;">
				<?php
				if ($buy["buy"]->prix_part != 0)
					echo number_format($buy["buy"]->prix_part, 2, ",", " ") . " €";
				else {
				?>
					<span>-</span>
				<?php
				}
				?>
			<td><?=number_format($buy["buy"]->getMontanInvestissement(), 2, ",", " ")?> €</td>
			<?php if (strstr($buy["buy"]->getTypePro(), "Usu")){ ?>
				<td><?=number_format($buy["buy"]->Usufruit, 2, ",", " ")?> €</td>
			<?php } else { echo "<td>-</td>"; }?>
		
			<?php if (!strstr($keyType, "Usu")){ ?>
			<td>-</td>
			<td>-</td>
			<?php } ?>
						<td style="position:relative;">
							<div class="vendreBtn" data-toggle="modal"
								onclick="
									editTransaction(<?=$buy["buy"]->id?>, {
										'name': '<?=$dataType['precalcul']['name']?>',
										'typePro': '<?=$dataType['precalcul']['type_pro']?>',
										'nbrPart': '<?=$buy["buy"]->getNbrPart()?>',
										'cle': '<?=$buy["buy"]->getClefRepartition()?>',
										'duree': '<?=$buy["buy"]->getDemembrement()?>',
										'prixPart': '<?=$buy["buy"]->prix_part?>',
										'montantTotal': '<?=$buy["buy"]->getMontanInvestissement()?>',
										'status_trans': '<?=$buy['buy']->status_trans?>',
										'id_transaction': '<?=$buy['buy']->id?>',
										'id_ben': '<?=$buy['buy']->id_beneficiaire?>',
										'commentaire': '<?=$buy['buy']->getCommentaire()?>',
										'link': '<?=$link?>',
										'marche': '<?=$buy['buy']->getMarcher()?>',
										'entreeJouissance': '<?=$buy['buy']->getDelaiJouissance()->getEntreeJouissanceStr()?>',
										'sortieJouissance': '<?=$buy['buy']->getDelaiJouissance()->getSortieJouissanceStr()?>',
										'date_bs': '<?=$buy['buy']->getDateSignatureStr()?>',
										'enr_date': '<?=$buy['buy']->getEnrDateStr()?>'
									})"
							>
								Editer
							</div>
							<?php
							if ($this->collaborateur->type == "yoda")
							{
								?>
								<div class="vendreBtn" data-toggle="modal"
									onclick="showDeleteTransaction(<?=$buy['buy']->id?>)"
								>
									Supprimer

                                </div>
								<?php
							}
							?>
						</td>
		</tr>
		<?php
			if (isset($buy["sell"]) && !strstr($buy["buy"]->getTypePro(), "Usu")){
				foreach ($buy["sell"] as $sell) {
					?>
					<tr  class="toSlide toSlide_<?=$key?>">
						<!--<td><?=$sell->getScpi()->name?></td>-->
						<td>Vente</td>
						<td>
							<?php 
							if ($sell->getEnrDate() instanceof DateTime)
								echo $sell->getEnrDate()->format("d/m/Y");
							else
								echo "-";
							?>
						</td>
						<td ><?=$sell->getTypePro()?></td>
						<?php
						if ($buy["buy"]->getTypePro() != "Pleine propriété") {
							?>
							<td ><?=$sell->getClefRepartition()?> %</td>
							<td>Durée</td>
							<?php
						}
						?>
						<td><?=$sell->getNbrPart()?></td>
						<td><?=number_format($sell->prix_part_vente, 2, ",", " ")?> €</td>
						<td><?=number_format($sell->getMontantGlobalDeRevente(), 2, ",", " ")?> €</td>
						<td>-</td>
						<td>
							<?php
							if (is_numeric($sell->plusMoinValuePourcent)) {
								echo number_format($sell->plusMoinValuePourcent, 2, ",", " ") . " %";
							} else
								echo "-";
							?>
						</td>
						<td>
							<?php
							if (is_numeric($sell->plusMoinValueEuro)) {
								echo number_format($sell->plusMoinValueEuro, 2, ",", " ") . " €";
							} else
								echo "-";
							?>
						</td>
						<td>
							<?php
							if ($this->collaborateur->type == "yoda")
							{
								?>
								<div class="vendreBtn" data-toggle="modal"
									onclick="showDeleteTransactionSell(<?=$sell->id?>)"
								>
									Supprimer
								</div>
							<?php
							}
							?>
						</td>
					</tr>
					<?php
						}
					}
					if (!strstr($buy["buy"]->getTypePro(), "Usu")){
					?>
				<tr style="cursor:pointer;background-color:#86a7c1;" class="hover_blue_back" onclick="$('.toSlide_<?=$key?>').slideToggle();">
						<td>Sous total</td>
						<td></td>
						<td><?=$buy['buy']->getTypePro()?></td>
						<?php
						if ($buy["buy"]->getTypePro() != "Pleine propriété") {
							?>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<?php
						}
						?>
						<td><?=$buy['precalcul']["nbr_part"]?></td>
						<td><?=number_format($buy['precalcul']['prix_achat'], 2, ",", " ")?> €</td>
						<td></td>
						<td><?=number_format($buy['precalcul']['ventePotentielle'], 2, ",", " ")?> €</td>
						<td>
							<?php
							if (is_numeric($buy['precalcul']['plusMoinValuePourcent']))
								echo number_format($buy['precalcul']['plusMoinValuePourcent'], 2, ",", " ") . " %";
							else
								echo "-";
							?>
						</td>
						<td>
							<?php
							if (is_numeric($buy['precalcul']['plusMoinValueEuro']))
								echo number_format($buy['precalcul']['plusMoinValueEuro'], 2, ",", " ") . " €";
							else
								echo "-";
							?>
						</td>
						<td style="position:relative;">
						</td>
					</tr>
					<?php } ?>
				<tr class="table_separateur">
				<?php if ($keyType != "Pleine") { ?>
						<td colspan="13"></td>
				<?php } else { ?>
						<td colspan="10"></td>
				<?php } ?>
				</tr>
			<?php
			}
			?>
			<tr style="background-color: #01528A;" class="endNoDate">
				<th>Total Global</th>
				<th></th>
				<th></th>
				<?php
				if ($keyType != "Pleine") {
					?>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<?php
				}
				?>
				<th><?=$dataType['precalcul']['nbr_part']?></th>
				<th>
				<?php 
					if (!$dataType['precalcul']['flagMissingInfo']) {
						echo number_format($dataType['precalcul']['MoyennePrixPart'], 2, ",", " ") . " €";
					} else {
						echo "-";
					}
				?>
				</th>
					<th></th>
				<th><?=number_format($dataType['precalcul']['ventePotentielle'], 2, ",", " ")?> €</th>
				<?php
				if (!strstr($keyType, "Usu")){
					if (is_numeric($dataType['precalcul']['plusMoinValuePourcent']) && !$dataType['precalcul']['flagMissingInfo']) {
					?>
						<th><?=number_format($dataType['precalcul']['plusMoinValuePourcent'], 2, ",", " ")?> %</th>
						<th><?=number_format($dataType['precalcul']['plusMoinValueEuro'], 2, ",", " ")?> €</th>
						<?php
					} else {
						?>
						<th>-</th>
						<th>-</th>
						<?php
					}
					?>
					<th></th>
				<?php
				} else {
					?>
					<th></th>
					<?php
				}
				?>
			</tr>
			<?php
			//echo $dataTmp;
			?>
	</tbody>
</table>
</div>

<?php
$dataTmp =  ob_get_contents();
ob_end_clean();
?>
<p>Vous détenez <?=$dataType['precalcul']["nbr_part"]?> part<?= ($dataType['precalcul']["nbr_part"] > 1) ? "s" : "" ?> de la <?=$dataType['precalcul']['name']?> en <?php
	if ($keyType === "Pleine") {
		echo "Pleine propriété";
	}
	else if ($keyType === "Usu") {
		echo "Usufruit";
	} else {
		echo "Nue propriété";
	}
?>. Vous avez réalisé <?= $dataType['precalcul']["nbr_transaction"]?> transaction<?php echo ($dataType['precalcul']["nbr_transaction"] > 1) ? "s" : ""; ?> pour cette SCPI.</p>
<p class="modalSellMsg">Veuillez renseigner les parts que vous avez cédé</p>
<?=$dataTmp?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn-mscpi" data-dismiss="modal">Fermer</button>
				</div>
			</form>
		</div>
	</div>
</div>
