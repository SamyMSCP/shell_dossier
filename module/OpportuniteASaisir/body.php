<?php
$json = json_decode(file_get_contents("module/OpportuniteASaisir/opportunity.json"), true);
$data = $json[1];
?>
<div class="modal fade " id="action-a-saisir">
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
						<a class="btn btn-popup-consult" href="<?= $data['url'] ?>" target="_blank">
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


<div class="module" id="op-module">
	<div class="carousel slide main-carousel" id="op-carrousel" data-ride="carousel">

		<div class="text-center container-opportunite">
			<div class="opportunite">
				<div class="part-up">
					<div class="filter">
					</div>
					<a href="#" data-toggle="modal" data-target="#action-a-saisir"><?= $data['name'] ?></a>
				</div>
				<div class="text-uppercase op-important-message">
					<a href="#" data-toggle="modal" data-target="#action-a-saisir" style="color: inherit">
					Opportunit&eacute; &agrave; saisir !
					</a>
				</div>
				<div class="part-down">
					<div>
						<h1>
							<?= $data['key'] ?>
						</h1>
						<div class="info-rend text-uppercase"><?= $data['text'] ?>
							<br/>
<br/>
<span class="" style="color: inherit; text-transform: none;">
<a href="#" data-toggle="modal" data-target="#action-a-saisir" style="color: #ffffff;">Je suis int&eacute;ress&eacute;(e)</a><br/><br/>
							<a href="#mention-risque" style="color: #f0f0f0; font-size: 0.8em;">Consulter les risques</a>
</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

