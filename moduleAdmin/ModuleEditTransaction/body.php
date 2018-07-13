<div class="col-md-12 col-md-offset-4">
	<form action="admin_lkje5sjwjpzkhdl42mscpi.php" method="get" accept-charset="utf-8">
		<div class="form-group">
			<div class="col-md-4">
				<select id="selectbasic" name="client" class="form-control">
				<?php
					foreach (Dh::getAll() as $elm)
						if (empty($elm->type) || $elm->type == "client")
							echo '<option', (!empty($GLOBALS['GET']['client']) && $GLOBALS['GET']["client"] == $elm->id_dh ?
								" selected=\"1\" " : " "),
								'value="', $elm->id_dh, '">',$elm->getPersonnePhysique()->getShortName(),
								" <---------> ", (empty($elm->type) ? "Prospect" : UcFirst($elm->type)), '</option>';
					?>
				</select>
			 </div>
		</div>
		<div class="form-group">
			<div class="col-md-4">
				<input type="hidden" name="p" id="token" value="<?php echo $GLOBALS['GET']['p']; ?>"/>
				<button id="singlebutton" class="btn btn-primary">Rechercher</button>
				<div class="btn btn-danger" onclick="if (confirm('Voulez-vous toutes éffacer sans enregistrer ?'))
												window.location = 'admin_lkje5sjwjpzkhdl42mscpi.php?p=EditTransaction';
													">Effacer</div>
			</div>
		</div>
	</form>
</div>
<?php
	if (empty($GLOBALS['GET']["client"]))
		echo '<h2 style="margin-top: 40vh;">Selectionner un DH</h2>';
	else {
?>
<h2>Voir toutes les transactions</h2>
	<table border="1" class="tableTrans">
		<thead>
			<tr>
				<th>ben</th>
				<th>Sociale</th>
				<th>NOM</th>
				<th>Prénom</th>
				<th>Civilité</th>
				<th>Cons</th>
				<th>Commentaire</th>
				<th>MP / MS</th>
				<th>Status de transaction</th>
				<th>Effectuée par</th>
				<th>SCPI</th>
				<th>Date Enr</th>
				<th>Nb parts</th>
				<th>Prix A/V</th>
				<th>Type propriete</th>
				<th>Durée si DT</th>
				<th>Clé répart (NU)</th>
				<th>Valider</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($this->transactions as $key => $elm)
			{
			echo '<form action="" method="post" accept-charset="utf-8">';
			?>
				<tr>
					<?php
						try
						{
							echo "<td>", $elm->getBeneficiaire()->getTypeBeneficiaire(), "</td>";
							if ($elm->getBeneficiaire()->getTypeBeneficiaire() == "Pm")
								echo '<td>', $elm->getBeneficiaire()->getPersonneMorale()[0]->getDenominationSociale(),'</td>';
							else
								echo '<td></td>';
							if (!empty($elm->getBeneficiaire()) && ($elm->getBeneficiaire()->getTypeBeneficiaire() == "seul" ||
								$elm->getBeneficiaire()->getTypeBeneficiaire() == "couple"))
							{
								?>
								<td>
									<?=$elm->getBeneficiaire()->getPersonnePhysique()[0]->getName()?>
								</td>
								<td>
									<?=$elm->getBeneficiaire()->getPersonnePhysique()[0]->getFirstName()?>
								</td>
								<td>
									<?=$elm->getBeneficiaire()->getPersonnePhysique()[0]->getCiviliteFormat()?>
								</td>
								<?php
							}
							else
							{
								?>
								<td></td>
								<td></td>
								<td></td>
								<?php
							}
						}
						catch (Exception $e)
						{
							echo '
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							';
						}
						?>
					
				<?php
					/*if ($elm->getBeneficiaire()->getTypeBeneficiaire() == "Pm")
						echo '<td>', $elm->getBeneficiaire()->getPersonneMorale()[0]->getDenominationSociale(),'</td>';
					else
						echo '<td></td>';
					if (!empty($elm->getBeneficiaire()) && ($elm->getBeneficiaire()->getTypeBeneficiaire() == "seul" ||
						$elm->getBeneficiaire()->getTypeBeneficiaire() == "couple"))
					{
						?>
						<td>
							<?=$elm->getBeneficiaire()->getPersonnePhysique()[0]->getName()?>
						</td>
						<td>
							<?=$elm->getBeneficiaire()->getPersonnePhysique()[0]->getFirstName()?>
						</td>
						<td>
							<?=$elm->getBeneficiaire()->getPersonnePhysique()[0]->getCiviliteFormat()?>
						</td>
						<?php
					}
					else
					{
						?>
						<td></td>
						<td></td>
						<td></td>
						<?php
					}
					*/?>
					<td>
					<?php
						if (!empty($elm->getConseiller()))
							echo $elm->getConseiller()->getLogin();
						?>
					</td>
					<td class="inputIn">
					<?php
						echo '<input name="commentaire" value="', $elm->getCommentaire(), '" />';
					?>
					</td>
					<td class="inputIn">
						<select name="marcher">
							<option value="Primaire"<?php echo ($elm->getMarcher() == "Primaire" ? "selected=1" : "")?>>MP</option>
							<option value="Secondaire"<?php echo ($elm->getMarcher() == "Secondaire" ? "selected=1" : "")?>>MS</option>
						</select>
					</td>
					<td class="inputIn">
						<?=$elm->getStatusTransaction()?>
					</td>
					<td class="inputIn">
					<?php
						echo '<input name="info_trans" value="', $elm->info_trans, '" />';
					?>
					</td>
					<td class="inputIn">
					<select name="scpi">
					<?php
						foreach (SCPI::getAll() as $v)
							echo '<option value="', $v->id, '" ', ($elm->getName() == $v->name ? "selected=1": ""),'>', $v->name,'</option>'
						 
					?>
						</select>
					</td>
					<td class="inputIn">
					<?php
						echo '<input type="date" name="date" value="', $elm->getEnrDate()->format("Y-m-d"), '" />';
					?>
					</td>
					<td class="inputIn">
					<?php
						echo '<input type="number" min="1" name="nbrpart" value="', $elm->getNbrPart(), '" />';
					?>
					</td>
					<td class="inputIn">
						<?php
							echo '<input name="prix" value="', number_format($elm->getPrixPart(), 2, ',', ' '), '" />';
						?>
					</td>
					<td class="inputIn">
						<select name="typepro">
							<option value="Pleine propriété"<?php echo ($elm->getTypePro() == "Pleine propriété" ? "selected=1" : "")?>>PP</option>
							<option value="Nue propriété"<?php echo ($elm->getTypePro() == "Nue propriété" ? "selected=1" : "")?>>NU</option>
							<option value="Usufruit"<?php echo ($elm->getTypePro() == "Usufruit" ? "selected=1" : "")?>>US</option>
						</select>
					</td>
					<td class="inputIn">
						<?php
							echo '<input name="duree" value="', $elm->getDuree(), '" />';
						?>
					</td>
					<td class="inputIn">
					<?php
						echo '<input step="0.001" type="number" min="1" name="cle" value="', $elm->getClefRepartition(), '" />';
					?>
					</td>
					<td>
						<input type="hidden" name="id" value="<?=$elm->id?>"/>
						<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
						<input class="btn btn-success" type="submit" name="actionUpdateTrans" id="actionUpdateTrans" value="updateIt" />
						<!--<input class="btn btn-danger" type="submit" name="actionDeleteTrans" id="actionUpdateTrans" value="DeleteIt" />-->
					</td>
				</tr>
			<?php
			echo "</form>";
			}
			?>
		</tbody>
	</table>
<?php } ?>
