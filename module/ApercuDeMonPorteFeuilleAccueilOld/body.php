<?php
$nb_transac = count($this->dh->getTransaction());
?>

<div class="module moduleApercuDeMonPorteFeuille">
	<div class="moduleTitle">
		<img src="<?= $this->getPath() . "img/Portefeuille-Blanc.svg" ?>" alt=""/>
		<span>APER&Ccedil;U DE MON PORTEFEUILLE</span>
		<button data-toggle="modal" data-target="#add_scpi" class="btn btn-scpi-add"><img
					src="<?= $this->getPath() ?>img/BTN-Plus_Blanc.png"/><span>AJOUTER UNE SCPI</span></button>
	</div>
	<div class="moduleContent container-fluid" id="valeur_cont">
		<?php
		$flagerror = 0;
		if ($nb_transac !== 0) {
		?>
		<table class=" tablePortefeuille container-fluid" id="table" style="margin-bottom:0px">
			<thead>
			<tr id="tbl_th" class="container-fluid row">
				<th class="col-lg-2 col-md-2 col-sm-2 col-xs-3 sortable-cursor text-uppercase text-center"
					id="sortscpi">Nom de la SCPI
				</th>
				<th class="col-lg-1 sortable-cursor text-uppercase text-center hidden-md hidden-sm hidden-xs">Type de
					propri&eacute;t&eacute;
				</th>
				<th class="col-lg-2 sortable-cursor text-uppercase text-center hidden-md hidden-sm hidden-xs">Cat&eacute;gorie</th>
				<th class="col-lg-1 col-md-2 col-sm-2 sortable-cursor text-uppercase text-center hidden-xs">Dernier
					tof
				</th>
				<th class="col-lg-1 col-md-2 col-sm-2 sortable-cursor text-uppercase text-center hidden-xs">TDVM 2017
				</th>
				<th class="col-lg-2 col-md-2 col-sm-2 col-xs-3 sortable-cursor text-uppercase text-center">Montant
					d'investissement
				</th>
				<th class="col-lg-2 col-md-2 col-sm-2 col-xs-3 sortable-cursor text-uppercase text-center">Montant
					global de revente
				</th>
				<th class="align-middle col-lg-1 col-md-2 col-sm-2 col-xs-3 sortable-cursor text-uppercase text-center">
					+ ou - value
				</th>
			</tr>
			</thead>
			<tbody>
			<?php
			/*
				type -> ['precalcul']['scpi']['TypeCapital']
				categorie -> ['precalcul']['scpi']['category_id']
				tof -> ['precalcul']['scpi']['Tof']
				TDVM -> A calculer
				Montant d'investissement -> ['precalcul']["MontantInvestissement"]
				Montant Global d'investissement -> ['precalcul']['ventePotentielle']
				+ ou - value -> ['precalcul']["plusMoinValuePourcent"]
			*/
			$index = -1;
			$trans = $this->dh->getTransaction();
			foreach ($this->data as $key => $elmData) {
				$index++;
				if ($key == 'precalcul')
					continue;
				foreach ($elmData as $key2 => $elmData2) {
					if ($key2 == 'precalcul')
						continue;
					$elm = $elmData2['precalcul'];

					$_p = strtolower(substr($elm["type_pro"], 0, 1));

					if ($_p === "p")
						$type = "PP";
					else if ($_p === "n")
						$type = "NP";
					else if ($_p === "u")
						$type = "US";
					else
						$type = "-";

					?>
					<tr class=" hover_blue_back text-center row <?php if ($elm['flagMissingInfo']) {
						echo "orange_back";
						$flagerror = 1;
					} ?>">
						<td class="col-lg-2 col-md-2 col-sm-2 col-xs-3 "><?= substr($elm["name"], 5) ?>
							<span>(<?= ($elm['scpi']->TypeCapital == "fixe") ? "F" : "V" ?>)</span></td>
						<td class="col-lg-1 hidden-md hidden-sm hidden-xs"><?= $type ?></td>
						<td class="col-lg-2 hidden-md hidden-sm hidden-xs"><?= $elm['scpi']->getCategoryStr() ?></td>
						<td class="col-lg-1 col-md-2 col-sm-2 hidden-xs">
							<?php
							try {
								if (floatval($elm['scpi']->Tof) === 0.0)
									Throw new Exception("Value equal to zero");
								echo (number_format(floatval($elm['scpi']->Tof), 2, ",", " ")) . " %";
							} catch (Exception $e) {
								echo "-";
							}
							?></td>
						<td class="col-lg-1 col-md-2 col-sm-2 hidden-xs">
							<?php
							if ($elm['scpi']->Tdvm === "")
								echo("0,00");
							else
								echo number_format($elm['scpi']->Tdvm, 2, ",", "");
							?> %
						</td>
						<td class="col-lg-2 col-md-2 col-sm-2 col-xs-3">
							<?php
							if (!$elm['flagMissingInfo']) {
								echo number_format(floatval($elm["MontantInvestissement"]), 2, ",", " ") . " €";
							} else {
								echo "-";
							}
							?>
						</td>
						<td class="col-lg-2 col-md-2 col-sm-2 col-xs-3">
							<?= number_format($elm["ventePotentielle"], 2, ",", " ") ?> €
						</td>
						<?php
						if (is_numeric($elm["plusMoinValuePourcent"]) && !$elm['flagMissingInfo'] && !strstr($elm["type_pro"], "Usu")) {
							?>
							<td class="col-lg-1 col-md-2 col-sm-2 col-xs-3">
								<?php echo(number_format($elm["plusMoinValuePourcent"], 2, ",", " ")); ?> %
							</td>
							<?php
						} else {
							?>
							<td class="col-lg-1 col-md-2 col-sm-2 col-xs-3">
								-
							</td>
							<?php
						}
						?>
					</tr>
					<?php
				}
			}
			?>
			</tbody>
			<tfoot>
			<tr id="tbl_tt" class="text-center container-fluid row">
				<th class='hidden-md hidden-sm hidden-xs'></th>
				<th class='hidden-md hidden-sm hidden-xs'></th>
				<th class='hidden-xs'></th>
				<th class='hidden-xs '></th>
				<th style="text-align:center;">Total :</th>
				<th class='text-center'><?= number_format($this->data['precalcul']['MontantInvestissement'], 2, ",", " ") ?>
					€
				</th>
				<th class="text-center"><?= number_format($this->data['precalcul']['ventePotentielle'], 2, ",", " ") ?>
					€
				</th>
				<?php if (is_numeric($this->data['precalcul']['plusMoinValuePourcent']) && !$this->data['precalcul']['flagMissingInfo']
					&& !$this->data['precalcul']['haveUsu'] && !$this->data['precalcul']['haveNue']) { ?>
					<th class='text-center'><?= number_format($this->data['precalcul']['plusMoinValuePourcent'], 2, ",", " ") ?>
						%
					</th>
				<?php } else { ?>
					<th class='text-center'>-</th>
				<?php } ?>
			</tr>
			</tfoot>
		</table>
		<div class="legend-out-table">
			(V = Variable, F = Fixe, PP = Pleine Propriet&eacute;, NP = Nue Propriete, US = Usufruit)
		</div>
	</div>
	<script type="text/javascript">

		$(document).ready(function () {
			$("#table").tablesorter();
			$("#sortscpi").click();
		})
	</script>

	<?php } else
	{
	if (!isset($GLOBALS['haveNotif']) || !$GLOBALS['haveNotif']) {
		?>
		<div class="modal fade modal_push_scpi in" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel"
			 aria-hidden="false">
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
						<p style="font-size: 24px; text-align: center; color: grey; font-weight: bold;">Votre
							portefeuille est actuellement vide.</p>
						<div class="row" style="margin-top: 30px;">
							<div class="col-sm-6 col-xs-12">
								<div class="btn-left" data-toggle="modal" data-target="#add_scpi"
									 onclick="setModalNewFixed(<?= $elm['id_scpi'] ?>,'<?= $elm['type_pro'] ?>')">
									<p class="btn_text">AJOUTER DES SCPI<br>QUE JE DÉTIENS</p>
								</div>
							</div>
							<div class="col-sm-6 col-xs-12 margin_response">
								<div class="btn_right" data-dismiss="modal" data-toggle="modal"
									 data-target="#modaleContact" style="">
									<p class="btn_text">INVESTIR DANS UNE SCPI</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" charset="utf-8">
			setTimeout(function () {
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
				<img src="<?= $this->getPath() ?>img/BTN-Plus_Blanc.png"/><span> AJOUTER UNE SCPI</span>
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
