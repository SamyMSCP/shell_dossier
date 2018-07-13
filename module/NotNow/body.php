<div class="modal fade" id="NotNow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div data-dismiss="modal" aria-label="Close" class="btn_close_prepapre">
					<span aria-hidden="true" class="btn_close">×</span>
				</div>
				<h4 >EN COURS DE DÉVELOPPEMENT</h4>
			</div>
			<div class="traitOrange"></div>
			<div class="modal-body">
			<?php
				$prenom = "Missing information";
				$nom = $prenom;
				$telephone = $prenom;
				$login = $prenom;
				$civilite = "Missing information";
				if (!empty($this->dh->getConseiller())) {
					$prenom = $this->dh->getConseiller()->getPersonnePhysique()->getFirstName();
				$nom = $this->dh->getConseiller()->getPersonnePhysique()->getName();
				$telephone = $this->dh->getConseiller()->getPersonnePhysique()->getPhoneFixe();
				$login = $this->dh->getConseiller()->getLogin();
				$civilite = $this->dh->getConseiller()->getPersonnePhysique()->getCivilite();
			?>
			<p>Cette fonctionnalité n'est pas encore disponible en ligne. Nous vous invitons à contacter <?=$civilite?> <?=$prenom?> <?=$nom?> par téléphone au <?=get_display_num($telephone, $this->dh->getConseiller()->getPersonnePhysique()->getIndicatifPhoneFixe())?> ou par mail à <?=$login?>.</p>
	<?php
	} else {
	?>
			<p>Vous etes un conseiller. Vous n'avez donc pas de conseiller</p>
	<?php
	}
	?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn-mscpi" data-dismiss="modal">Fermer</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
