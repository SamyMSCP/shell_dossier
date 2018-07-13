</script>

<script type="text/x-template" id="ModalProjetTemplate">
	<div class="modal fade modalViewFrontProject" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modalProjet">
		<div class="modal-dialog modal-lg modalViewProjectContour" v-if="selectedProject != null">
			<div class="modal-content modalViewProjectContent" v-if="seeDetail">

				<div class="modalViewBeneficiaireBntClose" @click.stop="setNoSeeDetails()">
					<img src="<?=$this->getPath()?>img/Close-Gris.svg" alt="" />
				</div>

				<div class="projectTitle">
					DÉTAILS DE LA PROPOSITION
				</div>

				<?php
					include('blockPortefeuilleScpiDetails.php');
				?>
			</div>

			<div class="modal-content modalViewProjectContent" v-if="!seeDetail">

				<div class="modalViewBeneficiaireBntClose">
					<button class="btn-mscpi btn-orange" v-if="selectedProject.etat_du_projet == 2" @click="clickValidateProject(selectedProject)">JE VALIDE MON PROJET</button>
					<button class="btn-mscpi btn-orange" v-if="selectedProject.etat_du_projet == 4" @click="signerRec(selectedProject)">SIGNER LE REC</button>
					<img src="<?=$this->getPath()?>img/Close-Gris.svg" data-dismiss="modal" aria-label="Close"/>
				</div>

				<div class="projectTitle">
					<span>
						{{ selectedProject.nom | upper }}
					</span>
					<div v-if="selectedProject.etat_du_projet == 0" style="border-color:#1781e0;">
						<img src="<?=$this->getPath()?>img/Proposition_BleuClair.png" alt="" />
						<div style="color:#1781e0">
							PROJET CRÉÉ
						</div>
					</div>

					<div v-else-if="selectedProject.etat_du_projet >= 1 && selectedProject.etat_du_projet <= 4" style="border-color:#1781e0">
						<img src="<?=$this->getPath()?>img/ProjetReflexionPlan de travail 1.svg" alt="" />
						<div style="color:#1781e0">
							Projet en cours de réflexion
						</div>
					</div>

					<div v-else-if="selectedProject.etat_du_projet == 5 || selectedProject.etat_du_projet == 6" style="border-color:#1781e0">
						<img src="<?=$this->getPath()?>img/EnCoursRealisation-Bleu.svg" alt="" />
						<div style="color:#1781e0">
							Projet en cours de réalisation
						</div>
					</div>

					<div v-else-if="selectedProject.etat_du_projet == 7" style="border-color:#20BF55">
						<img src="<?=$this->getPath()?>img/Termine-Vert.svg" alt="" />
						<div style="color:#20BF55">
							Projet finalisé
						</div>
					</div>
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
							<div class="traitOrangeProjet"></div>
							<div class="modalViewProjectBlockInfosInner3">
								<div class="projetModuleDetail">
									<div class="left">
										Bénéficiaire(s)
									</div>
									<div class="right">
										<span>
											{{ selectedProject.beneficiaireShortName }}<br />
										</span>
									</div>
								</div>
								<div class="projetModuleDetail">
									<div class="left">
										Budget projeté
									</div>
									<div class="right" >
										{{ selectedProject.budget }}
									</div>
								</div>
								<div class="projetModuleDetail" v-if="selectedProject.etat_du_projet > 1 && selectedProject.etat_du_projet != 3">
									<div class="left">
										Budget réel
									</div>
									<div class="right" >
										{{ getTotalInvestissement() | euros }}
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
											{{  elm }} <br />
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
							<div class="traitOrangeProjet"></div>
							<div class="modalViewProjectBlockInfosInner3">

								<ul class="listObjectif">
									<li v-for="(obj, key) in selectedProject.lstObjectifs">
										<span class="objectPuce">
											{{ key + 1}}
										</span>
										<span style="position:relative;">
											{{ obj }}
										</span>
									</li>
								</ul>
							</div>
						</div>
					</div>

					<div class="modalViewProjectBlockInfosInner">
						<div class="modalViewProjectBlockInfosInner2">
							<div class="blockProjectModule">
								VOTRE CONSEILLER
							</div>
							<div class="traitOrangeProjet"></div>
							<div class="modalViewProjectBlockInfosInner3" style="flex-direction:row;">
								<div class="blockConseiller">
									<div class="conseillerNom">
										{{ selectedProject.conseillerShortName }}<br />
									</div>
									<div>
										<b>T</b> {{ selectedProject.conseillerPhone }}
									</div>
									<div>
										<b>E</b> {{ selectedProject.conseillerMail }}
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>

				<div class="modalViewProjectBlockInfos" style=" margin-top: 10px;" >
					<div class="modalViewProjectBlockOngletInner" style="width: 100%;">
						<div class="blockProjetOnglet">
							<div @click="setOnglet(0)" :class="{blockProjetOngletSelected: onglet == 0}" >
								SIMULATIONS & COMPARAISONS
							</div>
							<div @click="setOnglet(1)" :class="{blockProjetOngletSelected: onglet == 1}">
								PORTEFEUILLE DE SCPI PROPOSÉES
							</div>
							<div @click="setOnglet(2)" :class="{blockProjetOngletSelected: onglet == 2}">
								PROFILS INVESTISSEURS
							</div>
							<?php
							/*
							<div @click="setOnglet(3)" :class="{blockProjetOngletSelected: onglet == 3}">
								NOTIFICATIONS
							</div>
							<div @click="setOnglet(4)" :class="{blockProjetOngletSelected: onglet == 4}">
								QUESTIONS & RÉPONSES
							</div>
							*/
							?>
						</div>
						<div class="modalViewProjectBlockOngletInner2">
							<?php
								include('blockSimulationComparaison.php');
								include('blockPortefeuilleScpi.php');
								include('blockProfilInvestisseur.php');
							/*
								include('blockNotifications.php');
								*/
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
		'modalProjetComponent',
		{
			data: function() {
				return ({
					onglet: 0,
					seeDetail: false
				})
			},
			methods: {
				signerRec: function(projet) {
					window.location.href='?p=SignatureRec&projet=' + projet.url
				},
				expandTrans: function(transaction) {
					Vue.set(transaction, "expand", true);
				},
				clickValidateProject: function(project) {
					var that = this;
					msgBox.show("Acceptez-vous cette proposition ?",[
						{
							text: "J'accepte",
							action: function() {
								// Une requete ajax pour set le projet au status 4 et envoyer un messageau conseiller
								that.$store.dispatch('PROJECT_SET_STATUS_4', project);
							},
							class: "btn-orange"
						},
						{
							text: "Je refuse",
							action: function() {
								// TODO Récupérer le message dans un textedit.

								msgBox.showText("Pourriez-vous nous donner quelques précision à propos de votre refus ?",[
									{
										text: "Enregistrer",
										action: function(message) {
											// Une requete ajax pour set le projet au status 4 et envoyer un messageau conseiller
											project.message = message;
											that.$store.dispatch('PROJECT_SET_STATUS_3', project);
										},
										class: "btn-orange"
									},
									{
										text: "Annuler",
										action: function() {  }
									},
								]);
							},
							class: "btn-orange"
						},
						{
							text: "Être contacté par mon conseiller",
							action: function() { 
								that.$store.dispatch('PROJECT_CONTACT', project).then(
									function() {
										console.log("C'est okay");
										msgBox.show("Votre demande de contact à bien été enregistrée !");
									},
									function() {}
								);
							}
						}
						<?php
						/*
						,
						{
							text: "Décider plus tard",
							action: function() {  }
						},
						*/
						?>
					]);
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
					rt =  this.getTransactionInvestissement(transaction) / this.getTotalInvestissement();
					return (rt * 100);
				},
				getTotalInvestissement: function () {
					var that = this;
					var rt = 0;
					var project = this.selectedProject;
					var transaction = project.transactions;
					transaction.map(function(elm) {
						rt += that.getTransactionInvestissement(elm);
					});
					return (rt);
				},
				setSeeDetails: function () {
					this.seeDetail = true;
				},
				setNoSeeDetails: function() {
					this.seeDetail = false;
				}
			},
			computed: {
				getPreparedDocument: function() {
					return (this.selectedProject.documents
						.sort(function(a, b) {
							return (b.date_creation - a.date_creation);
						})
					);
				},
				selectedProject: function() {
					return (this.$store.getters.getSelectedProject);
				}
			},
			template: "#ModalProjetTemplate"
		}
	);
