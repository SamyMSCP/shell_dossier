<?= $this->Loading ?>
<?= $this->Nav2 ?>
<?= $this->ToolTip ?>
<?php
$nb_transac = count($this->dh->getTransaction());
?>
<div class="containerPerso vueApp">
	<?= $this->MonCompte ?>
	<?= $this->TransactionFrontComponent ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12">
				<multi-action-modale></multi-action-modale>
				<div class="module main-portefeuille">
					<div class="header">
						<div class="container-fluid">
							<div class="row">
								<div class="col-md-4 col-xs-6">
									<div class="container-fluid text-uppercase">
										<img class="icon" src="assets/Portefeuille/Portefeuille-Blanc.svg"/>
										<span>Mon portefeuille</span>
									</div>
								</div>
								<div class="col-md-8 col-xs-6">
									<div class="container-fluid">
										<div class="col-lg-3 col-sm-6">
											<?php if (ENABLE_VALEUR_ISF && $this->dh->isf == 1) { ?>
											<div class="button orange text-uppercase" @click="showMsgBoxIfi">
												Relevé IFI
											</div>
											<?php } ?>
										</div>
										<div class="col-lg-4 col-sm-6">
											<a class="btn-block button outline white text-uppercase" href="index.php?p=ShowPatrimoine" target="_blank" v-if="$store.state.transactions.transactionsList.length> 0">
												Relevé SCPI
											</a>
										</div>
										<div class="col-lg-5 col-md-12 hidden-sm hidden-xs">
											<div class="btn-block button orange text-uppercase" data-toggle="modal" data-target="#multi-modal-action">
												<img src="/assets/cog/white.svg"/>
												Gérer mon portefeuille
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
								<!-- <div class="btn-mscpi-blanc" <?php if ($nb_transac > 0 && $this->dh->getConfirmation() == "3") { ?>onclick="window.open('index.php?p=ShowPatrimoine')" <?php } else { ?> onmouseover="display_tooltip('Information','Merci de valider votre numéro de téléphone et/ou votre mail pour accéder à votre récapitulatif.')" onmouseout="disable_msg()"<?php } ?>>
									<img src="<?= $this->getPath()?>img/telechargerblanc.png" alt="">
									<span class="txtDownloadRecap">TÉLÉCHARGER UN RÉCAPITULATIF</span>
								</div>
								<?php
									if (ENABLE_VALEUR_ISF && $this->dh->isf == 1) { 
										?>
										<button <?php if($nb_transac === 0) echo 'disabled'?> class="BtnStyle btnValeurIsf" onclick="showMsgBoxIfi()"><span >VALEUR IFI <?=date('Y')?></span></button>
								<?php } ?> -->
					</div>
					<div class="content">
						<div v-if="this.$store.state.transactions.transactionsList.length === 0" class="container-fluid text-center">
						<h3>
							Vous n'avez pas encore renseigné(e) de SCPI dans votre portefeuille,<br/>
							cliquez sur "Gérer mon portefeuille" pour en ajouter une.
						</h3>
						</div>
						<div class="" v-else>
							<stat-trans-all :data="getStats"></stat-trans-all>
							<transaction-list type="Pleine propriété" :list="this.$store.state.transactions.transactionsList"></transaction-list>
							<transaction-list type="Nue propriété" :list="this.$store.state.transactions.transactionsList"></transaction-list>
							<transaction-list type="Usufruit" :list="this.$store.state.transactions.transactionsList"></transaction-list>
							<div class="container">
								<small>
                                    <i class="text-warning fa fa-question-circle"></i>: Il s'agit d'une transaction potentielle.<br/>
                                    <i class="fa fa-star text-primary"></i>: Transaction Nue Propriété arrivée à terme.<br/>
									<i class="text-warning fa fa-exclamation-triangle"></i>: Des informations sont manquantes sur la transaction.
								</small>
							</div>
							<div class="container-fluid background blue total">
								<div class="left text-uppercase">
									PLEINE PROPRIÉTÉ + NUE-PROPRIÉTÉ + USUFRUIT
									<span data-toggle="tooltip" title="Valeur Éstimée">
										<img src="/assets/info/i-Blanc.svg" class="icon" alt="">
									</span>
								</div>
								<div class="right">
									TOTAL : {{ getTotal | formatMoney }}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row" v-if="this.$store.state.transactions.transactionsList.length !== 0">
			<div class="col-md-6 col-lg-4">
				<stats-module text-title="répartition par type de scpi" canvas-id="rep_type" :type-graph="get_graph_settings_donut"></stats-module>
			</div>
			<div class="col-md-6 col-lg-4">
				<stats-module text-title="répartition par catégorie" canvas-id="rep_categ" :type-graph="get_graph_settings_pie"></stats-module>
			</div>
			<div class="col-md-6 col-lg-4">
				<stats-module text-title="répartition géographique" canvas-id="rep_geo" :type-graph="get_graph_settings_radar"></stats-module>
				
			</div>
		</div>
<!-- 		
		<div class="row data-info">
			<bloc-info class="background one" :data="getPanelData.tdvs"></bloc-info>
			<bloc-info class="background two" :data="getPanelData.tdvm"></bloc-info>
			<bloc-info class="background three" :data="getPanelData.tof"></bloc-info>
			<bloc-info class="background four" :data="getPanelData.revalorisation"></bloc-info>
		</div> -->
	</div>
	<div class="row">
		<?= $this->Footer ?>
	</div>
</div>
<?= $this->ModuleBarreBleu ?>
