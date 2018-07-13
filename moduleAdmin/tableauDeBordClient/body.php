<div class="tableauDeBordClient">
	<div class="table">
		<div class="ligneBleu1">
			<div class="ligneBleu2">
				<table border="1">
					<tr>
						<th><span>Nombre de souscription</span></th>
						<td>
						<?php 
							$i = 0;
								foreach ($this->table as $key => $elm) {
									if ($key == "precalcul")
										continue ;
									$i++;
								}
								echo $i;
							?>
						</td>
					</tr>
					<tr>
						<th><span>Montant total Investi</span></th>
						<td><?=number_format($this->table['precalcul']['MontantInvestissement'], 2, ",", " ")?>  €</td>
					</tr>
					<tr>
						<th><span>Dont Meilleurescpi.com</span></th>
						<td><?=number_format($this->table['precalcul']['MontantInvestissementMscpi'], 2, ",", " ")?>  €</td>
					</tr>
					<tr>
						<th><span>Montant moyen / souscription</span></th>
						<td><?=number_format($this->table['precalcul']['MontantInvestissement'] / (($i > 0) ? $i : 1), 2, ",", " ")?>  €</td>
					</tr>
				</table>
			</div>
		<div class="repPorte">
			<?=$this->RepartitionPorteFeuille?>
		</div>
		</div>
	</div>
</div>
