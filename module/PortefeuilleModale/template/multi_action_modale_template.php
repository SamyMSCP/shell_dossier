<?php
/**
 * Created by PhpStorm.
 * User: vthomas
 * Date: 20/02/2018
 * Time: 14:45
 */
?>
<div>
	<transaction></transaction>
	<modale-suppr-scpi></modale-suppr-scpi>
	<modale-add-scpi></modale-add-scpi>
	<modal-reinvest-scpi></modal-reinvest-scpi>
	<transaction></transaction>
	<!-- Modale de choix de vente -->
	<modale-vente-scpi></modale-vente-scpi>
	<!-- Modale de cession de part -->
	<modale-cession></modale-cession>
	<modale-list-transaction :list-select="this.list_select"></modale-list-transaction>
	<div class="modal fade" role="dialog" id="multi-modal-action">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close right button" data-dismiss="modal"><img
								src="/assets/close/Close-Jaune.svg"/></button>
					<span class="modal-title text-uppercase">GÉRER MON PORTEFEUILLE</span>
				</div>
				<div class="modal-body">
					<div class="container-fluid line"></div>
					<div class="container-fluid">
						<div class="row">
							<div class="col-sm-6">
								<div class="big button blue text-uppercase" @click="openReinvest()">
									<div class="row">
										<div class="col-xs-12"><img src="/assets/money/white.svg"/></div>
										<div class="col-xs-12 text-content">Investir dans une SCPI ou réinvestir</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="big button green text-uppercase" @click="openAdd()">
									<div class="row">
										<div class="col-xs-12"><img src="/assets/plus/white.svg"/></div>
										<div class="col-xs-12 text-content">ajouter une scpi que je détiens déjà</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="big button orange text-uppercase" @click="openVente()">
									<div class="row">
										<div class="col-xs-12"><img src="/assets/Portefeuille/white.svg"/></div>
										<div class="col-xs-12 text-content">vendre des scpi</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="big button light blue text-uppercase" @click="openEdit()">
									<div class="row">
										<div class="col-xs-12"><img src="/assets/edit/white.svg"/></div>
										<div class="col-xs-12 text-content">modifier mon portefeuille
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
