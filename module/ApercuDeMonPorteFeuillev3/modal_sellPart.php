<div class="modal fade" id="modal_sellPart" tabindex="1" role="dialog" aria-labelledby="myModalLabel" style="z-index:2000">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<form action="" name="selling" method="post" class="modal_sell_form">
				<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title">CESSION DE PARTS</h3>
				</div>
				<div class="traitOrange"></div>
				<div class="modal-body">
					<div class="lineContent">
						J’ai cédé <input name="nbr_part_sell" min="1" type="number" value="1" placeholder="Nombre de part" class=" nbr_part_sell" required=""> parts de la <span class="modal_title_sell"></span> le <?php
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
						au prix unitaire de <input id="prix" name="prix_part_sell" min="1" type="number" value="1" step="any" placeholder="Prix de vente de(s) part(s) €" class="prix_part_sell">
					</div>
				</div>
				<div class="modal-footer">
					<input class="modal_id_sell" type="hidden" value="" name="transaction_id" />
					<input type="submit" class="btn-mscpi btn-orange" value="VALIDER">
					<button type="button" class="btn-mscpi" data-dismiss="modal">ANNULER</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

