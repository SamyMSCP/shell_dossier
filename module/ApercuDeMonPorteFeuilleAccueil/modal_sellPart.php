<div class="modal fade" id="modal_sellPart_old" tabindex="1" role="dialog" aria-labelledby="myModalLabel" style="z-index:2000 !important">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="" name="selling" method="post" class="modal_sell_form">
				<input type="hidden" name="motop" class="modal_to_open" disabled />
				<input class="modal_id_sell" type="hidden" value="" name="transaction_id" />
				<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="<?= $this->getPath() ?>img/Close-Jaune.svg" alt="" /></button>
				<h4 class="modal-title text-center">CESSION DE PARTS</h4>
				<div class="trait" style="margin: 15px auto !important;"></div>
			</div>
				<div class="modal-body">
					<div class="row text-center">
						J’ai cédé <input name="nbr_part_sell" min="1" type="number" value="1" placeholder="Nombre de part" class=" nbr_part_sell" required> parts
					</div>
					<div class="row text-center">de la <span class="modal_title_sell"></span></div>
					<div class="row text-center"> le <?php
								if (!isMobile())
								{
									?>
									<input id="dateSelling" name="date_sell" type="text" placeholder="" class="dateenr">
									<?php
								}
								else
								{
									?>
									<input id="date" name="date_sell" type="date" placeholder="" class="dateenr" value="<?=date("Y-m-d")?>">
									<?php
								}
						?>
					</div>
					<div class="row text-center">
						au prix unitaire <span style="font-weight: bold">net vendeur</span> de
					</div>
					<div class="row text-center"><input id="prix" name="prix_part_sell" min="1" type="number" value="1" step="any" placeholder="Prix de vente de(s) part(s) €" class="prix_part_sell"> euros.
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn-mscpi" data-dismiss="modal">ANNULER</button>
					<input type="submit" class="btn-mscpi btn-orange"  onclick="setTimeout(function() {$($('.modal_to_open').val()).modal('show')}, 500);"value="VALIDER">
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

