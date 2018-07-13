<div <?php echo 'class="modal mdl fade modal_' . $keyType . '_' .  str_replace(array(' ', '"', "'"), '_' , $name) . '" id="' . $keyType . '_' .  str_replace(' ', '_' , $name) . '"'; ?> tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-lg">
		<div class="modal-content" style="background-color:#ebebeb;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="<?=$this->getPath()?>img/Close-Jaune.svg" alt="" /></button>
				<h4 class="modal-title" style="margin-top: 20pxmargin-top: 20px;;text-align: center;"><?php echo mb_strtoupper(htmlspecialchars(substr($name, 5))); ?>
				<?php
				if ($keyType === "Pleine") {
					echo " - PLEINE PROPRIÉTÉ";
				}
				else if ($keyType === "Usu") {
					echo " - USUFRUIT";
				} else {
					echo " - NUE PROPRIÉTÉ";
				}
				?>
				<h4>
			</div>
			<div class="traitOrange"></div>
			<form method="post" action="?p=Portefeuille">
				<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
				<div class="modal-body">

<?php
ob_start();
?>
					<?php
					if ((count($dataType) -1) > 5)
					{
						?>
						<div class="modal-footer">
							<button name="singlebutton" class="btn-add-scpi update_info">Valider</button>
							<button type="button" class="btn-more-info " data-dismiss="modal">Fermer</button>

						</div>
						<?php
					}
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
				<td colspan="10" style="padding: 4px;font-weight: 800;">
			<?php } else if (strstr($keyType, "Nue")) { ?>
				<td colspan="12" style="padding: 4px;font-weight: 800;">
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
				<th  onmouseover="display_tooltip_table_head('Action', '.',event)" onmouseout="disable_msg(event)" style="cursor:help;">Action</th>
			<?php } ?>
		</tr>
		<?php
			//ob_start();
			if (!isset($buy["buy"]))
				continue ;
		?>
		<tr class="toSlide toSlide_<?=$key?>">
			<td>Achat</td>
			<td style="position:relative;">
				<?php 
				if ($buy["buy"]->getEnrDate() instanceof DateTime)
					//echo $buy["buy"]->getEnrDate()->format("d/m/Y");
					echo ft_decrypt_crypt_information($buy["buy"]->enr_date);
				else {
				?>
					<div class="flechAide">
						<span class="glyphicon glyphicon-arrow-down"></span>
					</div>
					<span style='cursor:pointer; color: #01528A; text-decoration: underline;' onclick="ft_change_at_input(this, <?=$buy["buy"]->id?>, 'date', <?=$key?>)">Renseigner une valeur ?</span>
				<?php
				}
				?>
			</td>
			<td ><?=$buy["buy"]->getTypePro()?></td>
			<?php
			if ($buy["buy"]->getTypePro() != "Pleine propriété") {
				?>
				<td ><?=number_format($buy["buy"]->getClefRepartition(), 2, ",", " ")?> %</td>
				<td><?=$buy["buy"]->getDemembrement()?></td>
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
					<div class="flechAide">
						<span class="glyphicon glyphicon-arrow-down"></span>
					</div>
					<span style='cursor:pointer; color: #01528A; text-decoration: underline;' onclick="ft_change_at_input(this, <?=$buy["buy"]->id?>, 'prix', 42)">Renseigner une valeur ?</span>
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
			<td>-</td>
			<?php } ?>
		</tr>
		<?php
			if (isset($buy["sell"]) && !strstr($buy["buy"]->getTypePro(), "Usu")){
				foreach ($buy["sell"] as $sell) {
					?>
					<tr  class="toSlide toSlide_<?=$key?>">
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
							<td ><?=number_format($sell->getClefRepartition(), 2, ",", " ")?> %</td>
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
						<td></td>
					</tr>
					<?php
						}
					}
					if (!strstr($buy["buy"]->getTypePro(), "Usu")){
					?>
				<tr style="cursor:pointer;background-color:#F4DDBC;" >
						<td>Sous total</td>
						<td></td>
						<td><?=$buy['buy']->getTypePro()?></td>
						<?php
						if ($buy["buy"]->getTypePro() != "Pleine propriété") {
							?>
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
							<?php
							if (!$buy['precalcul']['flagMissingInfo'] && (strstr($buy['buy']->getTypePro(), "Pleine") || $buy['buy']->getEndDemembrement() < new DateTime(date("Y-m-d")))) {
							?>
								<div class="vendreBtn" data-toggle="modal" data-dismiss="modal"
									onclick="
										prepareSellPart(
											<?=$buy["buy"]->id?>,
											'<?=addslashes($buy['buy']->getScpi()->name)?> - <?=$buy['buy']->getTypePro()?>',
											'<?php
												if (!isMobile())
												{
													if (strstr($buy['buy']->getTypePro(), "Nue"))
														echo $buy['buy']->getDateDebutDividendes()->format('d/m/Y');
													else
														echo $buy['buy']->getEnrDate()->format("d/m/Y");
												}
												else
												{
													if (strstr($buy['buy']->getTypePro(), "Nue"))
														echo $buy['buy']->getDateDebutDividendes()->format('Y-m-d');
													else
														echo $buy['buy']->getEnrDate()->format("Y-m-d");
												}
												?>',
												<?=$buy['precalcul']['prix_actuel']?>)" data-target="#modal_sellPart" href="" class="red_dis mention">
							<div class="flechAide modalSellMsg">
								<span style="color:#01528A;" class="glyphicon glyphicon-arrow-down"></span>
							</div>
								Vendre</div>
							<?php
							}
							?>
						</td>
					</tr>
					<?php } ?>
				<tr class="table_separateur">
				<?php if ($keyType != "Pleine") { ?>
						<td colspan="13"></td>
				<?php } else { ?>
						<td colspan="11"></td>
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
<p class="MsgSeeScpi">Vous détenez <?=$dataType['precalcul']["nbr_part"]?> part<?= ($dataType['precalcul']["nbr_part"] > 1) ? "s" : "" ?> de la <?=$dataType['precalcul']['name']?> en <?php
	if ($keyType === "Pleine") {
		echo "Pleine propriété";
	}
	else if ($keyType === "Usu") {
		echo "Usufruit";
	} else {
		echo "Nue propriété";
	}
?>. Vous avez réalisé <?= $dataType['precalcul']["nbr_transaction"]?> transaction<?php echo ($dataType['precalcul']["nbr_transaction"] > 1) ? "s" : ""; ?> pour cette SCPI. </p>
<p class="modalSellMsg">Veuillez renseigner les parts que vous avez cédé</p>
<?=$dataTmp?>
				</div>
				<div class="modal-footer">
					<button name="singlebutton" class="btn-add-scpi update_info">Valider</button>
					<button type="button" class="btn-more-info " data-dismiss="modal">Fermer</button>

				</div>
			</form>
		</div>
	</div>
</div>
