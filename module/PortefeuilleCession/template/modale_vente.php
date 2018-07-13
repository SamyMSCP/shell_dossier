<?php
/**
 * Created by PhpStorm.
 * User: vthomas
 * Date: 20/02/2018
 * Time: 17:14
 */
?>
<div class="modal fade" id="modal_sellPart_old" tabindex="1" role="dialog" aria-labelledby="myModalLabel" style="z-index:2000 !important">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="" name="selling" method="post" class="modal_sell_form">
				<input type="hidden" name="motop" class="modal_to_open" disabled />
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="/assets/close/Close-Jaune.svg"/></button></button>
				<h4 class="modal-title text-center">CESSION DE PARTS</h4>
				<div class="trait" style="margin: 15px auto !important;"></div>
			</div>
				<div class="modal-body">
					<div class="row text-center">
						J’ai cédé <input name="nbr_part_sell" min="1" type="number" v-model="nbr_part" placeholder="Nombre de part" class=" nbr_part_sell" required> parts 
						de la {{ (!!$store.state.transactions.selectedTransaction) ? $store.state.transactions.selectedTransaction.scpi : "" }}
					</div>
					<div class="row text-center"> le
						<input id="dateSelling" name="date_sell" type="text" placeholder="JJ/MM/AAAA"  v-model="date" class="dateenr">
						au prix unitaire <span style="font-weight: bold">net vendeur</span> de
						<input id="prix" name="prix_part_sell" min="1" type="number" v-model="prix_part" step="any" placeholder="Prix de vente de(s) part(s) €" class="prix_part_sell"> euros.
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn-mscpi" data-dismiss="modal">ANNULER</button>
					<button type="button" class="btn-mscpi btn-orange" @click="sell" data-dismiss="modal">VALIDER</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

