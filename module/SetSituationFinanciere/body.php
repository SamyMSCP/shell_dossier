<h1 style="color: #1781e0;">CRÉATION DE VOTRE PROJET</h1>
<div class="progressBlk">
	<?=$this->ProgressBlock?>
</div>
<form method="POST" class="form-horizontal" id="tosendinfo">
	<div class="contentSituation">
		<div class="blockSituation block1 blockSelected">
			<div class="titleBlockSituation">
				REVENUS DE <?=mb_strtoupper($this->ben->getShortName())?>
			</div>
			<div class="contentBlockSituation">
				<div class="contenuOut">
						<?php
						include('block1.php');
						?>
				</div>
				<div class="nextBlockSituation">
					<div class="btn-next btn-next-inactive">
						<div class="inactive">
							QUESTION SUIVANTE
							<img src="<?=$this->getPath()?>img/CP-Fleche-GrisFonce.svg" alt="" />
						</div>
					</div>
					<div class="btn-next btn-next-step" style="display:none;">
						<div class="active" >
							QUESTION SUIVANTE
							<img src="<?=$this->getPath()?>img/CP-Fleche-BleuClair.svg" alt="" />
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="contentSituation">
		<div class="blockSituation block2">
			<div class="titleBlockSituation">
				CHARGES ANNUELLES DE <?=mb_strtoupper($this->ben->getShortName())?>
			</div>
			<div class="contentBlockSituation">
				<div class="contenuOut">
						<?php
						include('block2.php');
						?>
				</div>
				<div class="nextBlockSituation">
					<div class="btn-next btn-next-inactive">
						<div class="inactive">
							QUESTION SUIVANTE
							<img src="<?=$this->getPath()?>img/CP-Fleche-GrisFonce.svg" alt="" />
						</div>
					</div>
					<div class="btn-next btn-next-step" style="display:none;">
						<div class="active" >
							QUESTION SUIVANTE
							<img src="<?=$this->getPath()?>img/CP-Fleche-BleuClair.svg" alt="" />
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
	<input type="hidden" name="action" id="" value="setSituationFinanciere" />
	<?php
	/*
	<input style="margin-top: 20px;" class="tosend" type="image" src="<?=$this->getPath()?>img/btn_1_hd.jpg" name="send" value="send">
	*/
	?>
</form>
