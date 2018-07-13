<div class="container-fluid">
	<div id="cammemberts">
		<div class="col-md-6" style="min-height: 50%">
		<?= $this->RepartitionAcceuil ?>
		</div>
		<div class="col-md-6" style="min-height: 50%">
				<div class="moduleVerticalAlign">
					<div class="module moduleDividendes">
						<div class="moduleTitle">
							<img src="<?=$this->getPath() . "img/Billet-Blanc.svg"?>" alt="" />
							<span>MES DIVIDENDES 2017</span>
							<sup class="_tooltip_r">2</sup>
						</div>
						<div class="moduleContent">
<?php if ($this->table['precalcul']['flagMissingInfo']) : ?>
							<h3 style='color:#505050;font-size:16px;'>Pour connaitre le montant de vos dividendes, merci de compléter certaines données manquantes de vos transactions.</h3>
<?php elseif ($this->dividendes) : ?>
							<table>
								<thead>
									<tr>
										<!--<th>&nbsp;</th>-->
										<th><h4>1T</h4></th>
										<th><h4>2T</h4></th>
										<th><h4>3T</h4></th>
										<th><h4>4T</h4></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<?php
										/*
										<td><h4><?=(date('Y')-1)?></h4></td>
										*/
										?>
										<td>
	<?php if (!empty($this->dividendes['lastDividendesTrimestre']['T1'])) : ?>
											<h3><?= number_format($this->dividendes['lastDividendesTrimestre']['T1'], 2, ',', ' ') ?></h3>
	<?php else : ?><span>-</span><?php endif ; ?>
										</td>
										<td>
									<?php if (!empty($this->dividendes['lastDividendesTrimestre']['T2'])) : ?>
										<h3><?= number_format($this->dividendes['lastDividendesTrimestre']['T2'], 2, ',', ' ') ?></h3>
									<?php else : ?><span>-</span><?php endif ; ?>
									</td>
									<td>
									<?php if (!empty($this->dividendes['lastDividendesTrimestre']['T3'])) : ?>
										<h3><?= number_format($this->dividendes['lastDividendesTrimestre']['T3'], 2, ',', ' ') ?> </h3>
									<?php else : ?><span>-</span><?php endif ; ?>
									</td>
									<td>
									<?php if (!empty($this->dividendes['lastDividendesTrimestre']['T4'])) : ?>
										<h3><?= number_format($this->dividendes['lastDividendesTrimestre']['T4'], 2, ',', ' ') ?></h3>
									<?php else : ?><span>-</span><?php endif ; ?>
									</td>
								</tr>
								<!--<tr>
									<td style="width: 25%">
									<?php if (!empty($this->dividendes['actualDividendesTrimestre']['T1'])) : ?>
										<h3><?= number_format($this->dividendes['actualDividendesTrimestre']['T1'], 2, ',', ' ') ?></h3>
									<?php else : ?><span>-</span><?php endif ; ?>
									</td>
									<td style="width: 25%">
									<?php if (!empty($this->dividendes['actualDividendesTrimestre']['T2'])) : ?>
										<h3><?= number_format($this->dividendes['actualDividendesTrimestre']['T2'], 2, ',', ' ') ?></h3>
									<?php else : ?><span>-</span><?php endif ; ?>
									</td>
									<td style="width: 25%">
									<?php if (!empty($this->dividendes['actualDividendesTrimestre']['T3'])) : ?>
										<h3><?= number_format($this->dividendes['actualDividendesTrimestre']['T3'], 2, ',', ' ') ?> </h3>
									<?php else : ?><span>-</span><?php endif ; ?>
									</td>
									<td style="width: 25%">
									<?php if (!empty($this->dividendes['actualDividendesTrimestre']['T4'])) : ?>
										<h3><?= number_format($this->dividendes['actualDividendesTrimestre']['T4'], 2, ',', ' ') ?></h3>
									<?php else : ?><span>-</span><?php endif ; ?>
									</td>
								</tr>-->
							</tbody>
						</table>
		<?php endif ; ?>
					</div>
				</div>
			<?= $this->TauxDOccupation ?>
			</div>
		</div>
		<div class="col-md-6">
		<?= $this->RepartitionGeographique ?>
		</div>
		<div class="col-md-6">
		<?= $this->RepartitionParCategorie ?>
		</div>
	</div>
</div>
