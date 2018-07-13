<?php
$json = json_decode(file_get_contents("module/MonthSuggest/month.json"), true);
$data = $json[0];
?>
<div class="modal fade " id="action-month-suggest">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
				<h4 class="modal-title text-center">Que souhaitez vous faire ?</h4>
			</div>
			<div class="traitOrange"></div>
			<div class="modal-body">
				<div class="row text-center">
					<div class="text-uppercase col-lg-6">
						<a class="btn btn-popup-consult" href="<?= $data['url'] ?>"
						   target="_blank">
							Consulter la fiche de la SCPI
						</a>
					</div>
					<div class="text-uppercase col-lg-6">
						<a class="btn btn-popup-contact"
						   href="?p=<?= $GLOBALS['GET']['p'] ?>&suggest=<?= $_SESSION['anticsrf'] ?>">
							contacter un conseiller
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="module" id="month-module">
	<div class="carousel slide main-carousel" id="month-carrousel" data-ride="carousel">
		<div class="text-center container-month">
			<div class="month-suggest">
				<div class="part-up">
					<div class="filter">
					</div>
					<a href="#" data-toggle="modal" data-target="#action-month-suggest"><?= $data['name'] ?></a>
				</div>
				<div class="text-uppercase month-important-message">
					<a href="#" data-toggle="modal" data-target="#action-month-suggest" style="color: inherit">Suggestion du mois</a>
				</div>
				<div class="part-down">
					<div>
						<h1>
							<?= $data['key'] ?>
						</h1>
						<div class="info-rend text-uppercase">
							<?= $data['text'] ?>
							<br/>
							<br/>
							<span style="text-transform: none;">
							<a href="#" data-toggle="modal" data-target="#action-month-suggest">Je suis int&eacute;ress&eacute;(e)</a><br/><br/>
							<a href="#mention-risque" style="color: #808080; font-size: 0.8em;">Consulter les risques</a>
							</span>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
