<table border="1">
	<thead>
		<th>Info Scpi</th>
		<th>Info Transaction</th>
		<th>Timeline 2017</th>
		<th>Timeline 2018</th>
	</thead>
	<tbody>
		<?php
		foreach($this->trans as $key => $elm)
		{
			//$elm->setDebutFinValorisationDividendes();
			if ($elm->getTypeTransaction() == "V")
				;//continue;
			?>
			<tr>
				<td>
					<table border="0" class="infoScpi">
						<tr>
							<th>Id</th>
							<td><?=$elm->getScpi()->id?></td>
						</tr>
						<tr>
							<th>Nom</th>
							<td><?=$elm->getScpi()->name?></td>
						</tr>
						<tr>
							<th>Liste Delai de jouissance</th>
							<td>
								<ul>
								<?php
								foreach ($elm->getScpi()->getAllDelaiJouissance() as $key2 => $elm2)
								{
									?>
										<li style="min-width:175px;"><?=$elm2->getValueEntreJouissanceStr()?>
										<?=$elm2->getValueSortieJouissanceStr()?>
										<?=$elm2->getDatePriseEffet()->format("d/m/Y")?></li>
									<?php
								}
								?>
								</ul>
							</td>
						</tr>
						<tr>
							<th>Valeur revente / parts</th>
							<td><?=number_format($elm->getScpi()->getActualValue(), 2)?></td>
						</tr>
					</table>
				</td>
				<td>
					<table border="0" class="infoTrans">
						<tr>
							<th>Donneur d'ordre</th>
							<td><?=$elm->getDh()->getShortName()?></td>
						</tr>
						<tr>
							<th>Id</th>
							<td><?=$elm->id?></td>
						</tr>
						<tr>
							<th>Ventes liées</th>
							<td>
								<ul>
									<?php
									foreach($elm->getTransactionVentes() as $key2 => $elm2)
									{
										?>
										<li>
											id: <?=$elm2->id?><br />
											Nombre parts : <?=$elm2->getNbrPart()?> parts <br />
											Date Enregistrement : <?=$elm2->getEnrDate()->format("d/m/Y")?><br />
											Debut Valorisation : <?=$elm2->getDateDebutValorisation()->format('d/m/Y')?><br />
											Debut Dividendes : <?=$elm2->getDateDebutDividendes()->format('d/m/Y')?><br />
											<br />
										</li>
										<?php
									}
									?>
								</ul>
							</td>
						</tr>
						<tr>
							<th>Nbr Parts</th>
							<td><?=$elm->getNbrPart()?></td>
						</tr>
						<tr>
							<th>Type Pro</th>
							<td><?=$elm->getTypePro()?></td>
						</tr>
						<tr>
							<th>Durée de Demembrement</th>
							<td>
								<?php
									if ($elm->isPleinePro())
										echo "-";
									else if ($elm->getDemembrement() != 0)
										echo $elm->getDemembrement();
									else
										echo "Viager";
										
								?>
							</td>
						</tr>
						<tr>
							<th>Durée en jours du Demembrement</th>
							<td>
								<?php
									if ($elm->isPleinePro())
										echo "-";
									else if ($elm->getDemembrement() != 0)
										echo $elm->getDemembrementJours();
									else
										echo "Viager";
										
								?>
							</td>
						</tr>
						<?php
						if (!$elm->isPleinePro())
						{
							?>
							<tr>
								<th>Cle de répartition</th>
								<td>
									<?=$elm->getClefRepartition()?>
								</td>
							</tr>
						<?php
						}
						?>
						<tr>
							<th>Date enregistrement</th>
							<td><?=($elm->getEnrDate() instanceof DateTIme) ? $elm->getEnrDate()->format("d/m/Y") : "-"?></td>
						</tr>
						<tr>
							<th class="manualColor">Debut Valorisation Manuel</th>
							<td><?=($elm->getDateDebutValorisationManuel()->getTimestamp() != 0) ? $elm->getDateDebutValorisationManuel()->format('d/m/Y') : "-"?></td>
						</tr>
						<tr>
							<th class="manualColor">fin valorisation Manuel</th>
							<td><?=($elm->getDateFinValorisationManuel()->getTimestamp() != 0) ? $elm->getDateFinValorisationManuel()->format('d/m/Y') : "-"?></td>
						</tr>
						<tr>
							<th class="manualColor">debut Dividendes Manuel</th>
							<td><?=($elm->getDateDebutDividendesManuel()->getTimestamp() != 0) ? $elm->getDateDebutDividendesManuel()->format('d/m/Y') : "-"?></td>
						</tr>
						<tr>
							<th class="manualColor">fin dividendes Manuel</th>
							<td><?=($elm->getDateFinDividendesManuel()->getTimestamp() != 0) ? $elm->getDateFinDividendesManuel()->format('d/m/Y') : "-"?></td>
						</tr>
						<tr>
							<th class="excelColor">Date Entre Jouissance Excel</th>

							<td><?=($elm->getExcelDateEntreeJouissance() instanceof DateTime) ? $elm->getExcelDateEntreeJouissance()->format("d/m/Y") : "-"?></td>
						</tr>
						<tr>
							<th class="excelColor">Fin de Jouissance Excel</th>
							<td><?=($elm->getExcelDateFinJouissance() instanceof DateTime) ? $elm->getExcelDateFinJouissance()->format("d/m/Y") : "-"?></td>
						</tr>
						<tr>
							<th class="calcColor">Debut Valorisation Calculé</th>
							<td><?=($elm->calcDebutValorisation() instanceof Datetime) ? $elm->calcDebutValorisation()->format('d/m/Y') : "-"?></td>
						</tr>
						<tr>
							<th class="calcColor">fin valorisation Calculé (Uniquement Usufruit)</th>
							<td><?=($elm->calcFinValorisation() instanceof Datetime) ? $elm->calcFinValorisation()->format('d/m/Y') : "-"?></td>
						</tr>
						<tr>
							<th class="calcColor">debut Dividendes Calculé</th>
							<td><?=($elm->calcDebutDividendes() instanceof Datetime) ? $elm->calcDebutDividendes()->format('d/m/Y') : "-"?></td>
						</tr>
						<tr>
							<th class="calcColor">fin dividendes Calculé</th>
							<td><?=($elm->calcFinDividendes() instanceof Datetime) ? $elm->calcFinDividendes()->format('d/m/Y') : "-"?></td>
						</tr>
						<tr>
							<th class="dbColor">Debut Valorisation</th>
							<td><?=($elm->getDateDebutValorisation()->getTimestamp() != 0) ? $elm->getDateDebutValorisation()->format('d/m/Y') : "-"?></td>
						</tr>
						<tr>
							<th class="dbColor">fin valorisation</th>
							<td><?=($elm->getDateFinValorisation()->getTimestamp() != 0) ? $elm->getDateFinValorisation()->format('d/m/Y') : "-"?></td>
						</tr>
						<tr>
							<th class="dbColor">debut Dividendes</th>
							<td><?=($elm->getDateDebutDividendes()->getTimestamp() != 0) ? $elm->getDateDebutDividendes()->format('d/m/Y') : "-"?></td>
						</tr>
						<tr>
							<th class="dbColor">fin dividendes</th>
							<td><?=($elm->getDateFinDividendes()->getTimestamp() != 0) ? $elm->getDateFinDividendes()->format('d/m/Y') : "-"?></td>
						</tr>
					</table>
				</td>
				<td style="paddingg:0px" class="infoTimeline">
					<table border="0">
						<tr>
							<th></th>
							<th colspan="3">T1</th>
							<th colspan="3">T2</th>
							<th colspan="3">T3</th>
							<th colspan="3">T4</th>
						</tr>
						<tr style="font-weight:900">
							<th></th>
							<td>Jan</td>
							<td>Fev</td>
							<td>Mar</td>
							<td>Avr</td>
							<td>Mai</td>
							<td>Juin</td>
							<td>Juil</td>
							<td>Aou</td>
							<td>Sep</td>
							<td>Oct</td>
							<td>Nov</td>
							<td>Dec</td>
						</tr>
						<tr style="font-weight:900">
							<th>Acomptes</th>
							<?php
							for ($j = 1; $j <= 4; $j++)
							{
								?>
								<td colspan="3">
									Ex : <?=$elm->getScpi()->getAcompteExYearT(2017, $j)?> <br />
									Ord : <?=$elm->getScpi()->getAcompteOrdYearT(2017, $j)?><br />
									Total : <?=$elm->getScpi()->getAcompteYearT(2017, $j)?>
								</td>
								<?php
							}
							?>
						</tr>
						<tr>
							<th class="excelColor">Parts Valorisation</th>
							<?php
							for($i = 1; $i <= 12; $i++)
							{
								?>
								<td>
									<?=$elm->getNbrPartsForValorisationAtTimestamp(DateTime::createFromFormat("d/m/Y H:i:s", "1/" . $i . "/2017 00:00:00")->getTimestamp())?>
								</td>
								<?php
							}
							?>
						</tr>
						<?php
						if (!$elm->isPleinePro())
						{
							?>
							<tr>
								<th class="excelColor">Jours Ecoulés</th>
								<?php
								for($i = 1; $i <= 12; $i++)
								{
									?>
									<td>
											<?=intval($elm->getJoursEcoule(DateTime::createFromFormat("d/m/Y H:i:s", "1/" . $i . "/2017 00:00:00")->getTimestamp()))?>
									</td>
										<?php
								}
								?>
							</tr>
						<?php
						}
						?>
						<?php
						if (!$elm->isPleinePro())
						{
							?>
							<tr>
								<th class="excelColor">Cle Dynamique</th>
								<?php
								for($i = 1; $i <= 12; $i++)
								{
									?>
									<td>
											<?=number_format($elm->getClefRepartitionAtTimestamp(DateTime::createFromFormat("d/m/Y H:i:s", "1/" . $i . "/2017 00:00:00")->getTimestamp()), 5, ",", " ")?>
									</td>
										<?php
								}
								?>
							</tr>
						<?php
						}
						?>
						<tr>
							<th class="excelColor">Valorisation</th>
							<?php
							for($i = 1; $i <= 12; $i++)
							{
								?>
								<td>
										<?=number_format($elm->getValorisationAtTimestamp(DateTime::createFromFormat("d/m/Y H:i:s", "1/" . $i . "/2017 00:00:00")->getTimestamp()), 2, ",", " ")?>
								</td>
									<?php
							}
							?>
						</tr>
						<tr>
							<th class="dbColor">Parts Dividendes</th>
							<?php
							for($i = 1; $i <= 12; $i++)
							{
								?>
								<td>
									<?=$elm->getNbrPartsForDividendesAtTimestamp(DateTime::createFromFormat("d/m/Y H:i:s", "1/" . $i . "/2017 00:00:00")->getTimestamp())?>
								</td>
								<?php
							}
							?>
						</tr>
						<tr>
							<th class="dbColor">Dividendes</th>
							<?php
							for($i = 1; $i <= 12; $i++)
							{
								?>
								<td>
									<?php
										echo number_format($elm->getDividendeYearMonth(2017,  $i), 2, ",", " ");
										?>
								</td>
								<?php
							}
							?>
						</tr>
						<tr>
							<th class="dbColor">Dividendes T</th>
							<?php
							for($i = 1; $i <= 4; $i++)
							{
								?>
								<td colspan="3">
									<?php
										echo number_format($elm->getDividendeYearT(2017,  $i), 2, ",", " ");
										?>
								</td>
								<?php
							}
							?>
						</tr>
						<tr>
							<th class="dbColor">Dividendes Year</th>
							<td colspan="12">
								<?php
									echo number_format($elm->getDividendeYear(2017), 2, ",", " ");
									?>
							</td>
						</tr>
						
					</table>
				</td>
				<td style="paddingg:0px" class="infoTimeline">
					<table border="0">
						<tr>
							<th></th>
							<th colspan="3">T1</th>
							<th colspan="3">T2</th>
							<th colspan="3">T3</th>
							<th colspan="3">T4</th>
						</tr>
						<tr style="font-weight:900">
							<th></th>
							<td>Jan</td>
							<td>Fev</td>
							<td>Mar</td>
							<td>Avr</td>
							<td>Mai</td>
							<td>Juin</td>
							<td>Juil</td>
							<td>Aou</td>
							<td>Sep</td>
							<td>Oct</td>
							<td>Nov</td>
							<td>Dec</td>
						</tr>
						<tr style="font-weight:900">
							<th>Acomptes</th>
							<?php
							for ($j = 1; $j <= 4; $j++)
							{
								?>
								<td colspan="3">
									Ex : <?=$elm->getScpi()->getAcompteExYearT(2018, $j)?> <br />
									Ord : <?=$elm->getScpi()->getAcompteOrdYearT(2018, $j)?><br />
									Total : <?=$elm->getScpi()->getAcompteYearT(201, $j)?>
								</td>
								<?php
							}
							?>
						</tr>
						<tr>
							<th class="excelColor">Parts Valorisation</th>
							<?php
							for($i = 1; $i <= 12; $i++)
							{
								?>
								<td>
									<?=$elm->getNbrPartsForValorisationAtTimestamp(DateTime::createFromFormat("d/m/Y H:i:s", "1/" . $i . "/2018 00:00:00")->getTimestamp())?>
								</td>
								<?php
							}
							?>
						</tr>

						<?php
						if (!$elm->isPleinePro())
						{
							?>
							<tr>
								<th class="excelColor">Jours Ecoulés</th>
								<?php
								for($i = 1; $i <= 12; $i++)
								{
									?>
									<td>
											<?=intval($elm->getJoursEcoule(DateTime::createFromFormat("d/m/Y H:i:s", "1/" . $i . "/2018 00:00:00")->getTimestamp()))?>
									</td>
										<?php
								}
								?>
							</tr>
						<?php
						}
						?>
						<?php
						if (!$elm->isPleinePro())
						{
							?>
							<tr>
								<th class="excelColor">Cle Dynamique</th>
								<?php
								for($i = 1; $i <= 12; $i++)
								{
									?>
									<td>
											<?=number_format($elm->getClefRepartitionAtTimestamp(DateTime::createFromFormat("d/m/Y H:i:s", "1/" . $i . "/2018 00:00:00")->getTimestamp()), 5, ",", " ")?>
									</td>
										<?php
								}
								?>
							</tr>
						<?php
						}
						?>
						<tr>
							<th class="excelColor">Valorisation</th>
							<?php
							for($i = 1; $i <= 12; $i++)
							{
								?>
								<td>
										<?=number_format($elm->getValorisationAtTimestamp(DateTime::createFromFormat("d/m/Y H:i:s", "1/" . $i . "/2018 00:00:00")->getTimestamp()), 2, ",", " ")?>
								</td>
								<?php
							}
							?>
						</tr>
						<tr>
							<th class="dbColor">Parts Dividendes</th>
							<?php
							for($i = 1; $i <= 12; $i++)
							{
								?>
								<td>
									<?=$elm->getNbrPartsForDividendesAtTimestamp(DateTime::createFromFormat("d/m/Y H:i:s", "1/" . $i . "/2018 00:00:00")->getTimestamp())?>
								</td>
								<?php
							}
							?>
						</tr>
						<tr>
							<th class="dbColor">Dividendes</th>
							<?php
							for($i = 1; $i <= 12; $i++)
							{
								?>
								<td>
									<?php
										echo number_format($elm->getDividendeYearMonth(2018,  $i), 2, ",", " ");
										?>
								</td>
								<?php
							}
							?>
						</tr>
						<tr>
							<th class="dbColor">Dividendes T</th>
							<?php
							for($i = 1; $i <= 4; $i++)
							{
								?>
								<td colspan="3">
									<?php
										echo number_format($elm->getDividendeYearT(2018,  $i), 2, ",", " ");
										?>
								</td>
								<?php
							}
							?>
						</tr>
						<tr>
							<th class="dbColor">Dividendes Year</th>
							<td colspan="12">
								<?php
									echo number_format($elm->getDividendeYear(2018), 2, ",", " ");
									?>
							</td>
						</tr>
						
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<br /><br />
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>
