</script>
<script type="text/x-template" id="projectsList">
	<div>
		<div class="projetGlob" v-for="ben in $store.getters.getBeneficiaireForDh($store.getters.getSelectedDh.id)" >
			<h4 :value="ben.id_benf">
				{{ ben.shortName}}
			</h4>
			<div class="projetGlob2">
				<div v-for="elm in $store.getters.getProjetForBeneficiaire(ben.id_benf)" class="projetElement1">
					<div class="projetElement2" @click="showProjectDetails(elm)"  :class="{projectNotComplete: elm.etat_du_projet == -1 }">
						<h3>{{ elm.nom }}</h3>
						<div>
							<img v-if="elm.etat_du_projet >= 8" src="<?=$this->getPath()?>img/Dossiers-blanc_closed.png">
							<img v-else="elm.etat_du_projet >= 8" src="<?=$this->getPath()?>img/Dossiers-blanc_open.png">
						</div>
						<span style="color:white;">{{ elm.etat_du_projet }}</span>
						<h2 v-if="elm.etat_du_projet >= 8" >
							FINALISE
						</h2>
						<h2 v-else>
							EN COURS
						</h2>
					</div>
				</div>

				<div class="projetElement1"> 
					<div class="projetElement2_dashed" @click="CreateProjet()">
						<h2>NOUVEAU<br />PROJET</h2>
						<div>
							<img src="<?=$this->getPath()?>img/Plus-bleuclair-01.png" alt="" />
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</script>

<script type="text/x-template" id="projectsDetails">
	<div class="modal fade modalViewProject" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modalProjet">
		<div class="modal-dialog modal-lg modalViewProjectContour">
			<div class="modal-content modalViewProjectContent" v-if="seeDetail">

				<div class="modalViewBeneficiaireBntClose" @click.stop="setNoSeeDetails()">
					Revenir
				</div>

				<div class="modalViewProjectTitre">
					<div class="blockProjetTitre">
						DÉTAILS DE LA PROPOSITION
					</div>
				</div>

				<?php
					include('blockPortefeuilleScpiDetails.php');
				?>
			</div>

			<div class="modal-content modalViewProjectContent" v-if="!seeDetail">
				<div class="modalViewBeneficiaireBntClose" data-dismiss="modal" aria-label="Close">
					<img src="<?=$this->getPath()?>img/Close-Jaune.svg" alt="" />
				</div>
				<?php
				/*
				<button  class="btn-mscpi btn-orange" @click="$store.dispatch('GENERATE_REC', selectedProject)">
					Générer le rec
				</button>
				*/
				?>
				<div class="modalViewProjectTitre" v-if="Object.keys(selectedProject).length > 0">
					<div class="blockProjetTitre">
						<div style="position:relative;" >
							PROJET : 
							<input type="text" v-model="selectedProject.nom" class="noBorder" style="min-width: 700px;cursor:auto;" @keyup="setIsModify()" @keyup.enter="$store.dispatch('PROJECTS_SAVE_NAME', selectedProject)"/>

							<div class="outRight" style="top:0px;" v-if="typeof selectedProject.isModify != 'undefined' && selectedProject.isModify == true">
								<div class="outContent" @click="$store.dispatch('PROJECTS_SAVE_NAME', selectedProject)" style="padding: 0px 7px;">
									<i class="fa fa-floppy-o" aria-hidden="true"></i>
								</div>
							</div>
						</div>
					</div>
					<button v-if="selectedProject.etat_du_projet == -1" class="btn-mscpi btn-orange btn-not-check">
						Le client n'a pas encore complété ce projet
					</button>
					<button v-else-if="selectedProject.etat_du_projet == 0" class="btn-mscpi btn-orange" @click="setProjectStatus1(selectedProject)">
						Débuter la réflexion
					</button>
					<button 
						v-else-if="(selectedProject.etat_du_projet == 1 || selectedProject.etat_du_projet == 3) && (!selectedProjectCanREC || originalProject.strategie.length <= 10)"
						class="btn-mscpi btn-orange btn-not-check"
					>
						En attente de 
						<span v-if="$store.getters.getHaveDocument(5, selectedProject.id, 7).length <= 0">d'une COMPARAISON, </span>
						<span v-if="$store.getters.getHaveDocument(5, selectedProject.id, 8).length <= 0">d'une SIMULATION, </span>
						<span v-if="$store.getters.getTransactionForProject(selectedProject.id).length <= 0">d'au moin une TRANSACTION</span>
						<span v-if="originalProject.strategie.length <= 10">de la STRATEGIE</span>
						<span 
							v-if="originalProject.id_objectifs_list_1 == 0 || originalProject.id_objectifs_list_2 == 0 || originalProject.id_objectifs_list_3 == 0"

						>
							des réponses aux OBJECTIFS
						</span>
					</button>
					<button v-else-if="(selectedProject.etat_du_projet == 1 || selectedProject.etat_du_projet == 3)" class="btn-mscpi btn-orange" @click="setProjectStatus2(selectedProject)">
						Soumettre la proposition
					</button>

					<button v-else-if="selectedProject.etat_du_projet == 2" class="btn-mscpi btn-orange btn-not-check" 
						@click="validateProjectForClient(selectedProject)"
					>
						en attente du choix du client
					</button>
					<button v-else-if="selectedProject.etat_du_projet == 4" class="btn-mscpi btn-orange btn-not-check">
						En attente de la signature du REC
					</button>
					<button v-else-if="selectedProject.etat_du_projet == 7" class="btn-mscpi btn-orange">
						Ce projet est finalisé
					</button>
					<button v-else-if="selectedProject.etat_du_projet == 8" class="btn-mscpi btn-orange">
						Ce projet est annulé
					</button>
				</div>

				<div class="blockCree">
					<b>Créé le</b> {{ selectedProject.date_creation  | tsDateStr }} | <b>Mis à jour le </b> {{ selectedProject.date_modification  | tsDateStr }} 
				</div>

				<div class="modalViewProjectBlockInfos">
					<div class="modalViewProjectBlockInfosInner">
						<div class="modalViewProjectBlockInfosInner2">
							<div class="blockProjectModule">
								DÉTAILS DU PROJET
							</div>
							<div class="traitDonneurModalViewBeneficiairePp"></div>
							<div class="modalViewProjectBlockInfosInner3">
								<div class="projetModuleDetail">
									<div class="left">
										Bénéficiaire(s)
									</div>
									<div class="right">
										<span style="cursor:pointer;text-decoration: underline;" @click="showBeneficiaireDetails(selectedProject.id_beneficiaire)" v-if="typeof $store.getters.getPersonnePhysiqueForBeneficiaire(selectedProject.id_beneficiaire) != 'undefined'">
											<span v-for="Pp in $store.getters.getPersonnePhysiqueForBeneficiaire(selectedProject.id_beneficiaire)" >
												{{ (Pp.civilite == "Monsieur") ? "M." : "Mme" }}
												{{ Pp.prenom }}
												{{ Pp.nom}}
											</span>
										</span>
									</div>
								</div>
								<div class="projetModuleDetail">
									<div class="left">
										Budget
									</div>
									<div class="right" v-if="typeof $store.getters.getFourchettes[selectedProject.fourchette_investissement] != 'undefined'">
										{{ $store.getters.getFourchettes[selectedProject.fourchette_investissement][0] | euros }} À
										{{ $store.getters.getFourchettes[selectedProject.fourchette_investissement][1] | euros }}
									</div>
								</div>
								<div class="projetModuleDetail">
									<div class="left">
										Crédit
									</div>
									<div class="right">
										<span v-if="selectedProject.credit = 1">Oui (en totalité)</span>
										<span v-else-if="selectedProject.credit = 2">Oui (en partie)</span>
										<span v-else>non</span>
									</div>
								</div>
								<div class="projetModuleDetail">
									<div class="left" v-if="selectedProject.credit != 0">
										Accompagnement
									</div>
									<div class="right">
										<span v-if="selectedProject.accompagne_investissement = 1">Oui</span>
										<span v-else>non</span>
									</div>
								</div>
								<div class="projetModuleDetail">
									<div class="left">
										Origine des fonds
									</div>
									<div class="right" v-if="typeof selectedProject.origine != 'undefined'">
										<span v-for="(elm, key) in $store.getters.getOrigine" v-if="selectedProject.origine[key]">
											{{  elm }}, <br />
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modalViewProjectBlockInfosInner">
						<div class="modalViewProjectBlockInfosInner2">
							<div class="blockProjectModule">
								OBJECTIFS
							</div>
							<div class="traitDonneurModalViewBeneficiairePp"></div>
							<div class="modalViewProjectBlockInfosInner3">
								<ul class="listObjectif" v-if="typeof $store.getters.getObjectifs != 'undefined' && typeof selectedProject.objectifs != 'undefined'">
									<li>
										<span class="objectPuce">
											1
										</span>
										<span style="position:relative;">
											{{ $store.getters.getObjectifs[selectedProject.objectifs[0]]}}
											<br />
											<select class="noBorder" v-model="selectedProject.id_objectifs_list_1"
												v-if="selectedProject.etat_du_projet == 1 || selectedProject.etat_du_projet == 3"
												:class="{blockNonComplet: originalProject.id_objectifs_list_1 == 0}"
											>
												<option :value="0">-</option>
												<option v-for="chx in $store.state.projets.listObjectifChx" :value="chx.id">{{ chx.name }}</option>
											</select>
											<span class="objectifDetails" v-else-if="selectedProject.etat_du_projet != 0">{{ $store.state.projets.listObjectifChx[selectedProject.id_objectifs_list_1 - 1].name  }}</span>
											<div class="outRight" style="right:-50px;" v-if="selectedProject.id_objectifs_list_1 != originalProject.id_objectifs_list_1" @click="$store.dispatch('PROJECT_SET_OBJECTIF_LIST', 1)">
												<div class="outContent" @click="$store.dispatch('PROJECTS_SAVE_NAME', selectedProject)" style="padding: 5px 8px;">
													<i class="fa fa-floppy-o" aria-hidden="true"></i>
												</div>
											</div>
										</span>
									</li>
									<li>
										<span class="objectPuce">
											2
										</span>
										<span style="position:relative;">
											{{ $store.getters.getObjectifs[selectedProject.objectifs[1]]}}
											<br />
											<select class="noBorder" v-model="selectedProject.id_objectifs_list_2"
												v-if="selectedProject.etat_du_projet == 1 || selectedProject.etat_du_projet == 3"
												:class="{blockNonComplet: originalProject.id_objectifs_list_2 == 0}"
											>
												<option :value="0">-</option>
												<option v-for="chx in $store.state.projets.listObjectifChx" :value="chx.id">{{ chx.name }}</option>
											</select>
											<span class="objectifDetails"  v-else-if="selectedProject.etat_du_projet != 0">{{ $store.state.projets.listObjectifChx[selectedProject.id_objectifs_list_2 - 1].name  }}</span>
											<div class="outRight" style="right:-50px;" v-if="selectedProject.id_objectifs_list_2 != originalProject.id_objectifs_list_2" @click="$store.dispatch('PROJECT_SET_OBJECTIF_LIST', 2)">
												<div class="outContent" @click="$store.dispatch('PROJECTS_SAVE_NAME', selectedProject)" style="padding: 5px 8px;">
													<i class="fa fa-floppy-o" aria-hidden="true"></i>
												</div>
											</div>
										</span>
									</li>
									<li>
										<span class="objectPuce">
											3
										</span>
										<span style="position:relative;">
											{{ $store.getters.getObjectifs[selectedProject.objectifs[2]]}}
											<br />
											<select class="noBorder" v-model="selectedProject.id_objectifs_list_3"
												v-if="selectedProject.etat_du_projet == 1 || selectedProject.etat_du_projet == 3"
												:class="{blockNonComplet: originalProject.id_objectifs_list_3 == 0}"
											>
												<option :value="0">-</option>
												<option v-for="chx in $store.state.projets.listObjectifChx" :value="chx.id">{{ chx.name }}</option>
											</select>
											<span class="objectifDetails" v-else-if="selectedProject.etat_du_projet != 0">{{ $store.state.projets.listObjectifChx[selectedProject.id_objectifs_list_3 - 1].name  }}</span>
											<div class="outRight" style="right:-50px;" v-if="selectedProject.id_objectifs_list_3 != originalProject.id_objectifs_list_3" @click="$store.dispatch('PROJECT_SET_OBJECTIF_LIST', 3)">
												<div class="outContent" @click="$store.dispatch('PROJECTS_SAVE_NAME', selectedProject)" style="padding: 5px 8px;">
													<i class="fa fa-floppy-o" aria-hidden="true"></i>
												</div>
											</div>
										</span>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>

				<div class="modalViewProjectBlockInfos">
					<div class="modalViewProjectBlockOngletInner">
						<div class="blockProjetOnglet">
							<div @click="setOnglet(0)" :class="{blockProjetOngletSelected: onglet == 0, ongletNonComplet: (selectedProject.etat_du_projet == 1 || selectedProject.etat_du_projet == 3) && ($store.getters.getHaveDocument(5, selectedProject.id, 7).length <= 0 || $store.getters.getHaveDocument(5, selectedProject.id, 8).length <= 0)}">
								SIMULATIONS & COMPARAISONS
							</div>
							<div @click="setOnglet(1)" :class="{blockProjetOngletSelected: onglet == 1, ongletNonComplet: (selectedProject.etat_du_projet == 1 || selectedProject.etat_du_projet == 3) && $store.getters.getTransactionForProject(selectedProject.id).length <= 0}">
								PORTEFEUILLE DE SCPI PROPOSÉES
							</div>
							<div @click="setOnglet(2)" :class="{blockProjetOngletSelected: onglet == 2}">
								VOS PROFILS D’INVESTISSEURS
							</div>
							<div @click="setOnglet(5)" :class="{blockProjetOngletSelected: onglet == 5, ongletNonComplet: (selectedProject.etat_du_projet == 1 || selectedProject.etat_du_projet == 3) && originalProject.strategie.length <= 10}">
								STRATÉGIE
							</div>
						</div>
						<div class="modalViewProjectBlockOngletInner2">
							<?php
								include('blockSimulationComparaison.php');
								include('blockPortefeuilleScpi.php');
								include('blockProfilInvestisseur.php');
								include('blockNotifications.php');
								include('blockStrategie.php');
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</script>

<script type="text/javascript" charset="utf-8">

	Vue.component(
		'projectsList',
		{
			computed: {
				projectList: function() {
					return (this.$store.getters.getProjectsForDh(10));
				}
			},
			methods: {
				showProjectDetails: function(elm) {
					if (elm.etat_du_projet == -1)
						window.location = "?p=InfoProjetAdmin&client=<?=intval($GLOBALS['GET']['client'])?>&projet=" + elm.url;
					else
					{
						this.$store.commit("PROJECTS_SET_SELECTED", elm);
						$('#modalProjet').modal('show');
					}
				},
				CreateProjet: function() {
					//window.location = "?p=CreationProjetAdmin&client=<?=intval($GLOBALS['GET']['client'])?>";
					window.location = "?p=PageCreationProjetAdmin&client=<?=intval($GLOBALS['GET']['client'])?>";
				}
			},
			template: '#projectsList'
		}
	);

	Vue.component(
		'projectsDetails',
		{
			data: function () {
				return {
					documentSend: 0,
					onglet: 0,
					seeDetail: false
				};
			},
			computed: {
				selectedProjectOrigine: function() {
				/*
					this.$store.getters.lstOrigine.filter(function(elm, key) {
						console.log(key);
						return (true)
					});
					this.selectedProject.filter()
					*/
				},
				selectedProject: function() {
					return (this.$store.getters.getSelectedProject);
				},
				originalProject: function() {
					var that = this;
					return (that.$store.state.projets.lst.find(function(elm) {
						return (elm.id == that.selectedProject.id);
					}));
				},
				getLstDocument: function() {
					return (this.$store.getters.getSelectedProjectDocuments);
				},
				getTotalInvestissement: function () {
					var that = this;
					var rt = 0;
					var project = this.selectedProject;
					var transaction = this.$store.getters.getTransactionForProject(project.id);
					transaction.map(function(elm) {
						rt += that.getTransactionInvestissement(elm);
					});
					return (rt);
				},
				selectedProjectCanREC: function() {
					//Vérifier si il y a bien une comparaison, que le status du projet est 0 et qu'on a au moin une comparaison et une simulation.
					return (
						this.$store.getters.getTransactionForProject(this.selectedProject.id).length > 0 &&
						this.$store.getters.getHaveDocument(5, this.selectedProject.id, 7).length > 0 &&
						this.$store.getters.getHaveDocument(5, this.selectedProject.id, 8).length > 0 &&
						this.originalProject.id_objectifs_list_1 != 0 &&
						this.originalProject.id_objectifs_list_2 != 0 &&
						this.originalProject.id_objectifs_list_3 != 0
					);
				}
			},
			methods: {
				expandTrans: function(transaction) {
					Vue.set(transaction, "expand", true);
				},
				showBeneficiaireDetails: function(elm) {
					$('#modalProjet').modal('hide');
					showOnglet('BENEFICIAIRES');
					eval('init_BeneficiaireClient2();');
					this.$store.commit("BENEFICIAIRE_SET_SELECTED", this.$store.getters.getBeneficiaire(elm));
					this.$store.dispatch('SET_DEFAULT_SITUATION_JURIDIQUE_BY_ID_SITUATION', elm.id_situation);
					$('.modalViewBeneficiaire').modal('show');
				},
				getScpi: function(id) {
					return (this.$store.getters.getScpi(id));
				},
				setModifyChangeScpi: function(elm) {
					this.setModify(elm);
					elm.prix_part = this.$store.getters.getScpi(elm.id_scpi).prix_acquereur;
				},
				setModify: function (elm) {
					elm.isModify = true;
				},
				setProjectStatus1: function (elm) {
					this.$store.dispatch("PROJECT_SET_STATUS_1", elm);
				},
				setProjectStatus2: function (elm) {
					this.$store.dispatch("PROJECT_SET_STATUS_2", elm);
				},
				setProjectStatus3: function (elm) {
					this.$store.dispatch("PROJECT_SET_STATUS_3", elm);
				},
				setProjectStatus4: function (elm) {
					this.$store.dispatch("PROJECT_SET_STATUS_4", elm);
				},
				setDelete: function(elm) {
					var that = this;
					msgBox.show("Voulez-vous vraiment supprimer cette transaction ?",[
						{
							text: "Oui",
							action: function() { 
								that.$store.dispatch("TRANSACTIONS_DELETE", elm);
							}
						},
						{
							text: "Non",
							action: function() {  }
						},
					]);
				},
				createTransaction: function () {
					this.$store.dispatch("TRANSACTIONS_CREATE", {
						id_dh: this.$store.getters.getSelectedDh.id,
						id_beneficiaire: this.selectedProject.id_beneficiaire,
						id_projet: this.$store.getters.getSelectedProject.id,
						status_trans: "0-0",
						info_trans: "MS.C",
						doByMscpi: true
					});
				},
				setOnglet: function(onglet) {
					this.onglet = onglet;
				},
				getTransactionInvestissement: function (transaction) {
					var rt = transaction.prix_part * transaction.nbr_part;
					if (transaction.type_pro != 'Pleine propriété')
						rt *= (transaction.cle_repartition / 100);
					return (rt);
				},
				getTransactionPourcentage: function (transaction) {
					var rt = 0;
					rt =  this.getTransactionInvestissement(transaction) / this.getTotalInvestissement;
					return (rt * 100);
				},
				setIsModify: function() {
					Vue.set(this.selectedProject, 'isModify', true);
				},
				setSeeDetails: function () {
					this.seeDetail = true;
				},
				setNoSeeDetails: function () {
					this.seeDetail = false;
				},
				setAutresElementsIsChanged: function() {
					Vue.set(this.selectedProject, 'autresElementsIsModify', true);
				},
				setStrategieIsChanged: function() {
					Vue.set(this.selectedProject, 'strategieIsModify', true);
				},
				setCommentaireIsChanged: function() {
					Vue.set(this.selectedProject, 'commentIsModify', true);
				},
				moveLeftSpeed: function() {
					var position = $(".timeline_notification")[0].scrollLeft;
					position -= $(".timeline_notification").outerWidth() * 0.8;
					if (position < 0)
						position = 0;
					var position = $(".timeline_notification").animate({scrollLeft: position}, 1000);
				},
				moveRightSpeed: function() {
					var position = $(".timeline_notification")[0].scrollLeft;
					position += $(".timeline_notification").outerWidth() * 0.8;
					var max = $(".timeline_notification")[0].scrollWidth - $(".timeline_notification").outerWidth();
					if (position > max)
						position = max;
					var position = $(".timeline_notification").animate({scrollLeft: position}, 1000);
				},
				validateProjectForClient: function(selectedProject) {
					var that = this;
					msgBox.show("Voulez-vous valider ou refuser la proposition pour le client ?",[
						{
							text: "Accepter",
							action: function() { 
								that.setProjectStatus4(selectedProject);
							}
						},
						{
							text: "Refuser",
							action: function() {
								that.setProjectStatus3(selectedProject);
							}
						},
					]);
				},
			},
			template: '#projectsDetails'
		}
	);

