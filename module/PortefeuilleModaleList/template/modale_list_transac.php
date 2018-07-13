<?php
/**
 * Created by PhpStorm.
 * User: vthomas
 * Date: 20/02/2018
 * Time: 17:14
 */
?>

<div class="modal fade mdlNew" id="modale_list_transact" tabindex="-1" role="dialog" aria-labelledby="">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="background-color:#EBEBEB">
			<div class="modal-header" style="margin-top: 10px;">
				<button type="button" class="close right" data-dismiss="modal"><img
							src="/assets/close/Close-Jaune.svg"/></button>
				<span class="modal-title text-uppercase">{{ getTitle }}</span>
			</div>
			<div class="modal-body">
				<div class="container-fluid line"></div>
				<div class="container-fluid">
					<transaction-list-component-action :action="listSelect" type="Pleine propriété" :list="this.$store.state.transactions.transactionsList"></transaction-list-component-action>
					<transaction-list-component-action :action="listSelect" type="Nue propriété" :list="this.$store.state.transactions.transactionsList"></transaction-list-component-action>
					<transaction-list-component-action :action="listSelect" type="Usufruit" :list="this.$store.state.transactions.transactionsList"></transaction-list-component-action>
				</div>
				<!--					store.state.transactions.transactionsList-->
				<!--					<transaction-list-component :list-element="store.state.transactions.transactionsList"></transaction-list-component>-->
				<!--					<transaction-list-component></transaction-list-component>-->
<!--				<transaction-list-component :list-element="store.state.transactions.transactionsList"></transaction-list-component>-->
				<!--				</div>-->
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>

