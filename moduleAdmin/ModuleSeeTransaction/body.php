<h2>Voir toutes les transactions</h2>
<form action="" method="post" accept-charset="utf-8">
	<table border="1" class="tableTrans">
		<thead>
			<tr>
				<th>id</th>
				<th>ID TRANSACTION</th>
				<th>Type de bénéficiaire</th>
				<th>Dénomination sociale</th>
				<th>NOM</th>
				<th style="min-width:100px;">Prénom</th>
				<th>Civilité</th>
				<th>Mail / numéro de téléphone (si email absent)</th>
				<th style="min-width:175px">État transaction</th>
				<th>Date enregistrement / Annulation</th>
				<th>Cons</th>
				<th style="min-width:175px">Commentaire</th>
				<th>MP / MS</th>
				<th>Type transaction</th>
				<th>Effectuée par</th>
				<th style="min-width: 250px;">SCPI</th>
				<th>Date Signature BS</th>
				<th>Nb  parts</th>
				<th>Prix Achat / Vente</th>
				<th>Type propriete</th>
				<th>Durée si DT</th>
				<th>Clé répart </th>
				<th>Montant Transaction</th>
				<th>Date entrée Jouis</th>
				<th>Date fin Jouis</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($this->transactions as $key => $elm)
			{
				if ($elm->id < 4745)
					continue ;
			?>
				<tr>
					<td><?=$elm->id?></td>
					<td class="inputIn">
						<?php
						if (empty($elm->getIdMscpi()))
						{
							echo '<input type="number" min="1" name="id_mscpi_' . $elm->id . '" id="id_mscpi_' . $elm->id . '" />';
						}
						else
						{
							echo $elm->getIdMscpi();
						}
						?>
					</td>
					<td>
						<?php
						if (!empty($elm->getBeneficiaire()))
						{
							echo $elm->getBeneficiaire()->getTypeBeneficiaireForTable();
						}
						?>
					</td>
					<td>
						<?php
						if (!empty($elm->getBeneficiaire()) && $elm->getBeneficiaire()->getTypeBeneficiaire() == "Pm")
						{
							echo $elm->getBeneficiaire()->getPersonneMorale()[0]->getDenominationSociale();
						}
						?>
					</td>
					<?php
					if (!empty($elm->getBeneficiaire()) && ($elm->getBeneficiaire()->getTypeBeneficiaire() == "seul" || $elm->getBeneficiaire()->getTypeBeneficiaire() == "couple"))
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
					?>
					<td><?=$elm->getDh()->getLogin()?></td>
					<td><?=$elm->getStatusTransaction()?></td>
					<td>
						<?php
						if (!empty($elm->getEnrDate()))
							echo $elm->getEnrDate()->format("d/m/y");
						?>
					</td>
					<td>
						<?php
						if (!empty($elm->getConseiller()))
							echo $elm->getConseiller()->getLogin();
						?>
					</td>
						<td><?=$elm->getCommentaireForTable()?></td>
					<td><?=$elm->getMarcherForTable()?></td>
					<td><?=$elm->getTypeTransaction()?></td>
					<td><?=$elm->getInfoTransaction()?></td>
					<td><?=$elm->getSCPI()->getName()?></td>
					<td>
						<?php
						if (!empty($elm->getDateSignature()))
							echo $elm->getDateSignature()->format("d/m/y");
						?>
					</td>
					<td><?=str_replace(".", ",", $elm->getNbrPart())?></td>

					<td><?=number_format((float)$elm->getPrixPart(), 4, ",", "")?></td>
					<td><?=$elm->getTypeProForTable()?></td>
					<td>
					<?php 
						if (empty($elm->getDuree()))
						{
							echo "SO";
						}
						else
						{
							echo $elm->getDuree();
						}
					
					?></td>
					<td><?=number_format(floatval($elm->getClefRepartition() / 100), 4, ",", "")?></td>
					<td><?=str_replace(".", ",", $elm->getMontanInvestissement())?></td>
					<td>
						<?php
						if (!empty($elm->getExcelDateEntreeJouissance()))
							echo $elm->getExcelDateEntreeJouissance()->format("d/m/y");
						?>
					</td>
					<td>
						<?php
						if (!empty($elm->getExcelDateFinJouissance()))
							echo $elm->getExcelDateFinJouissance()->format("d/m/y");
						else
							echo "SO";
						?>
					</td>
				</tr>
			<?php
			}
			?>
		</tbody>
	</table>
	<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
	<input type="submit" name="actionUpdateTrans" id="actionUpdateTrans" value="updateIt" />
</form>
