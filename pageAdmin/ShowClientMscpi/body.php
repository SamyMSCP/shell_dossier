<?=$this->Nav?>
<?=$this->MessageBox?>
<div class="containerPerso">
	<h2>Les clients MSCPI</h2>
	<div>
		<table class='table'>
			<thead>
				<tr>
					<th>Id</th>
					<th>Civilité</th>
					<th>Nom</th>
					<th>Prénom</th>
					<th>email</th>
					<th>Indicatif téléphonique</th>
					<th>Téléphone</th>
					<th>Parrain</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$dhs = Dh::getAll();
				$count = 0;
				foreach ($dhs as $key => $dh) {
					if (
						!$dh->haveTransactionMscpi()
						||
						(
							$dh->getType() != null && 
							$dh->getType() != 'client'
						)
					)
						continue ;
					$count++;
					$pp = $dh->getPersonnePhysique();
					?>
					<tr>
						<td><?=$dh->id_dh?></td>
						<td><?=$pp->getCiviliteFormat()?></td>
						<td><?=$pp->getName()?></td>
						<td><?=$pp->getFirstName()?></td>
						<td><?=$pp->getMail()?></td>
						<td><?=$pp->getIndicatifPhone()?></td>
						<td><?=$pp->getPhone()?></td>
						<td>
						<?php
							$parrain = $dh->getParrain();
							if (!empty($parrain))
								echo $parrain->getShortName();
						?>
						</td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
		<?="nbr: $count\n"?>
	</div>
</div>
