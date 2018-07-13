<?php
/**
 * Created by PhpStorm.
 * User: vthomas
 * Date: 20/02/2018
 * Time: 17:14
 */
?>

<div class="modal fade mdlNew" id="del_scpi" tabindex="-1" role="dialog" aria-labelledby="">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="background-color:#EBEBEB">
			<div class="modal-header" style="margin-top: 10px;">
				<button type="button" class="close right" data-dismiss="modal"><img
							src="/assets/close/Close-Jaune.svg"/></button>
				<span class="modal-title text-uppercase">&nbsp;&nbsp;&nbsp;&nbsp;ATTENTION</span>
			</div>
			<div class="modal-body">
				<div class="container-fluid line"></div>
				<div class="container-fluid">
					Attention, vous êtes sur le point de supprimer la <b>{{ ($store.state.transactions.selectedTransaction !== null) ? $store.state.transactions.selectedTransaction.scpi : "" }}</b> de votre portefeuille. Cette action est irréversible.
					Êtes-vous sûr de votre choix ?
				</div>
			</div>
			<div class="modal-footer">
				<div class="row">
					<div class="col-sm-3 col-sm-offset-3">
						<div class="small button orange text-uppercase" @click="sendDelete()">oui</div>
					</div>
					<div class="col-sm-3">
						<div class="small button red text-uppercase" data-dismiss="modal">non</div>
					</div>
				</div>
				<div class="row small">
					<div class="col-xs-12">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

