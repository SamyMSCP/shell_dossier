</script>

<script type="text/x-template" id="beneficiairesList">
	<div>
		<div class="listBeneficiaire">
			<div class="listBeneficiaireElmt1" v-for="ben in $store.getters.getBeneficiaireForDh($store.getters.getSelectedDh.id)" > 
				<div class="listBeneficiaireElmt2" @click="showBeneficiaireDetails(ben)">
					<h3>{{ ben.shortName }}</h3>
					<div>
						<img src="<?=$this->getPath()?>img/Gender-blanc_Homme.png" alt="" v-if="ben.typePpStr == 'homme'"/>
						<img src="<?=$this->getPath()?>img/Gender-blanc_Femme.png" alt="" v-if="ben.typePpStr == 'femme'"/>
						<img src="<?=$this->getPath()?>img/Gender-blanc_F-F.png" alt="" v-if="ben.typePpStr == 'femme-femme'"/>
						<img src="<?=$this->getPath()?>img/Gender-blanc_F-H.png" alt="" v-if="ben.typePpStr == 'femme-homme'"/>
						<img src="<?=$this->getPath()?>img/Gender-blanc_H-H.png" alt="" v-if="ben.typePpStr == 'homme-homme'"/>
						<img src="<?=$this->getPath()?>img/Societe_blanc.png" alt="" v-if="ben.typePpStr == 'entreprise'"/>
					</div>
				</div>
			</div>
			<?php
			/*
			<div class="listBeneficiaireElmt1"> 
				<div class="listBeneficiaireElmt2_dashed" @click="$store.dispatch('BENEFICIAIRE_SHOW_ADD')">
					<h2>NOUVEAU<br />BENEFICIAIRE</h2>
					<div>
						<img src="<?=$this->getPath()?>img/Plus-bleuclair-01.png" alt="" />
					</div>
				</div>
			</div>
			*/
			?>
		</div>
	</div>
</script>
<script type="text/x-template" id="beneficiaireAdd">

	<div class="modal fade modalAddBeneficiaire" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modalBenefAdd">
		<div class="modal-dialog modal-lg" style="border-radius: 15px;">
			<div class="modal-content modalViewBeneficiaireContent" style="border-radius: 15px;">
				<div class="modal-header">
					<div class="modalViewBeneficiaireBntClose" data-dismiss="modal" aria-label="Close">
						<img src="<?=$this->getPath()?>img/Close-Jaune.svg" alt="" />
					</div>
					<h3>AJOUTER UN BÉNÉFICIAIRE</h3>
					<div class="traitDonneurModalViewBeneficiaire center-block"></div>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-4 text-center">
							<img src="<?=$this->getPath()?>img/Gender-blanc_Homme.png" class="center-block" height="50" alt="" />
							<div>
								<label @click="changeTypeBenef('seul')">
									<input type="radio" v-model="relBenef" value="self" />
									<span><?= $this->dh->getShortName() ?></span>
								</label>
							</div>
							<div>
								<label @click="changeTypeBenef('seul')">
									<input type="radio" v-model="relBenef" value="conjoint" />
									<span>Son/sa conjoint(e)</span>
								</label>
							</div>
							<div>
								<label @click="changeTypeBenef('seul')">
									<input type="radio" v-model="relBenef" value="parent" />
									<span>Un parent</span>
								</label>
							</div>
							<div>
								<label @click="changeTypeBenef('seul')">
									<input type="radio" v-model="relBenef" value="enfant" />
									<span>Un enfant</span>
								</label>
							</div>
						</div>
						<div class="col-md-4 text-center">
							<img src="<?=$this->getPath()?>img/Gender-blanc_F-H.png" class="center-block" height="50" alt="" />
							<div>
								<label @click="changeTypeBenef('couple')">
									<input type="radio" v-model="relBenef" value="couple" />
									<span><?= $this->dh->getShortName() ?> et son/sa conjoint(e)</span>
								</label>
							</div>
							<div>
								<label @click="changeTypeBenef('couple')">
									<input type="radio" v-model="relBenef" value="parents" />
									<span>Ses parents</span>
								</label>
							</div>
						</div>
						<div class="col-md-4 text-center">
							<img src="<?=$this->getPath()?>img/Societe_blanc.png" class="center-block" height="50" alt="" />
							<div>
								<label @click="changeTypeBenef('Pm')">
									<input type="radio" v-model="relBenef" value="employeur" />
									<span>Son entreprise</span>
								</label>
							</div>
							<div>
								<label @click="changeTypeBenef('Pm')">
									<input type="radio" v-model="relBenef" value="employe" />
									<span>L'entreprise dans laquelle il/elle travail</span>
								</label>
							</div>
						</div>
					</div>
					{{ seulOrCouple}}
					<div class="text-center" v-if="seulOrCouple">
						<template v-if="$store.getters.getPersonnePhysiqueForDh(<?= $this->dh->id_dh ?>).length <= 1">
							Aucune personne physique trouvée
						</template>
						<template v-else>
							<div v-for="pp in $store.getters.getPersonnePhysiqueForDh(<?= $this->dh->id_dh ?>)">
								<input type="checkbox" :value="pp.id_phs" />{{ pp.civ }} {{ pp.nom }} {{ pp.prenom }}
							</div>
						</template>
					</div>
					<div class="row text-center" v-if="typeBenef == 'Pm'">
						<div v-if="$store.getters.getPersonneMoraleForDh(<?= $this->dh->id_dh ?>).length <= 1">
							Aucune personne morale trouvée
						</div>
					</div>
					<div class="row text-right">
						<button class="btn-mscpi" @click="submitBenef">Envoyer</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</script>
<script type="text/x-template" id="beneficiaireDetails">
	<div v-if="typeof selectedBeneficiaire != 'undefined'" class="modal fade modalViewBeneficiaire" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modalProjet">
		<div class="modal-dialog modal-lg modalViewBeneficiaireContour" style="border-radius: 15px;">
			<div class="modal-content modalViewBeneficiaireContent" style="border-radius: 15px;">
				<div class="modalViewBeneficiaireBntClose" data-dismiss="modal" aria-label="Close">
					<img src="<?=$this->getPath()?>img/Close-Jaune.svg" alt="" />
				</div>
				<div class="modalViewBeneficiaireTitre">
					<?php
					/*
					<select class="noBorder selectBeneficiaire" v-model="$store.state.beneficiaire.selectedBeneficiaire" @change="setSituation">
						<option v-for="ben in $store.state.beneficiaire.lst" :value="ben">{{ ben.shortName }}</option>
					</select>
					*/
					?>
					<h3>
						BENEFICIAIRE : {{ $store.state.beneficiaire.selectedBeneficiaire.shortName }}
						<img src="<?=$this->getPath()?>img/Gender_Homme.png" alt="" v-if="selectedBeneficiaire.typePpStr == 'homme'"/>
						<img src="<?=$this->getPath()?>img/Gender_Femme.png" alt="" v-if="selectedBeneficiaire.typePpStr == 'femme'"/>
						<img src="<?=$this->getPath()?>img/Gender_F-F.png" alt="" v-if="selectedBeneficiaire.typePpStr == 'femme-femme'"/>
						<img src="<?=$this->getPath()?>img/Gender_F-H.png" alt="" v-if="selectedBeneficiaire.typePpStr == 'femme-homme'"/>
						<img src="<?=$this->getPath()?>img/Gender_H-H.png" alt="" v-if="selectedBeneficiaire.typePpStr == 'homme-homme'"/>
						<img src="<?=$this->getPath()?>img/Societe_blanc.png" alt="" v-if="selectedBeneficiaire.typePpStr == 'entreprise'"/>
					</h3>
				</div>
				id : {{ selectedBeneficiaire.id_benf }}
				<div class="traitDonneurModalViewBeneficiaire"></div>

				<div class="modalViewBeneficiaireBlockPp">
					<div class="modalViewBeneficiairePp1" v-for="Pp in selectedBeneficiairePps">
						<div class="modalViewBeneficiairePp2">
							<div class="nomPp">
								<h3>{{ (Pp.civilite == "Monsieur") ? "M." : "Mme"}} {{ Pp.prenom }} {{ Pp.nom }}</h3>
								<img src="<?=$this->getPath()?>img/Gender_Homme.png" alt="" v-if="Pp.civilite == 'Monsieur'"/>
								<img src="<?=$this->getPath()?>img/Gender_Femme.png" alt="" v-else />
							</div>
							<div class="traitDonneurModalViewBeneficiairePp"></div>
							<div class="modalViewBeneficiaireBlockInfo">
								<div class="modalViewBeneficiaireBlockInfoIn blkLeft">
									<ul>
										<li class="benNationalite">
											<img src="<?=$this->getPath()?>img/Flag-bleuclair-01.png" alt="" />
											<span>{{ Pp.nationalite }}</span>
										</li>
										<li class="benTel">
											<img src="<?=$this->getPath()?>img/Phone-bleuclair.png" alt="" />
											<span>{{ Pp.telephone }}</span>
										</li>
										<li class="benMail">
											<img src="<?=$this->getPath()?>img/Email-bleuclair.png" alt="" />
											<span>{{ Pp.mail }}</span>
										</li>
									</ul>
									<div class="beneficiaireViewBtn beneficiaireViewBtnBleu">
										<button @click.stop="$store.commit('SHOW_PROFIL', Pp)" class="btn-mscpi" v-if="typeof Pp.profilInvestisseur != 'undefined'">PROFIL INVESTISSEUR</button>
										<button class="btn-mscpi btn-not-check" v-else>PROFIL INVESTISSEUR</button>
									</div>
								</div>
								<div class="modalViewBeneficiaireBlockInfoIn blkRight">
									<document-btn class="btn-mscpi" v-for="typeDocument in $store.state.personnePhysiqueStore.lstTypeDocument" id_entity="1" :link_entity="Pp.id" :type_document="typeDocument.id" :key="typeDocument.id">
										{{ typeDocument.name }}
									</document-btn>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
				/*
				<div class="modalViewProjectBlockInfos">
					<div class="modalViewProjectBlockOngletInner">
						<div class="blockProjetOnglet">
							<div @click="setOnglet(0)" :class="{blockProjetOngletSelected: onglet == 0}">
								PROJET
							</div>
							<div @click="setOnglet(1)" :class="{blockProjetOngletSelected: onglet == 1}">
								SITUATION JURIDIQUE
							</div>
							<div @click="setOnglet(2)" :class="{blockProjetOngletSelected: onglet == 2}">
								SITUATION FINANCIÈRE
							</div>
							<div @click="setOnglet(3)" :class="{blockProjetOngletSelected: onglet == 3}">
								SITUATION FISCALE
							</div>
							<div @click="setOnglet(4)" :class="{blockProjetOngletSelected: onglet == 4}">
								SITUATION PATRIMONIALE
							</div>
						</div>
						<div class="modalViewProjectBlockOngletInner2">
							<?php
								include('blockProjet.php');
								include('blockSitJur.php');
								include('blockSitFin.php');
								include('blockSitFisc.php');
								include('blockSitPat.php');
							?>
						</div>
					</div>
				</div>
				*/
				?>
			</div>
		</div>
	</div>
</script>

<script type="text/javascript" charset="utf-8">

	Vue.component(
		'beneficiairesList',
		{
			computed: {
				projectList: function() {
					return (this.$store.getters.getProjectsForDh(10));
				}
			},
			methods: {
				showBeneficiaireDetails: function (elm) {
					this.$store.commit("BENEFICIAIRE_SET_SELECTED", elm);
					this.$store.dispatch('SET_DEFAULT_SITUATION_JURIDIQUE_BY_ID_SITUATION', elm.id_situation);
					this.$store.dispatch('SET_DEFAULT_SITUATION_FINANCIERE_BY_ID_SITUATION', elm.id_situation);
					this.$store.dispatch('SET_DEFAULT_SITUATION_FISCALE_BY_ID_SITUATION', elm.id_situation);
					this.$store.dispatch('SET_DEFAULT_SITUATION_PATRIMONIALE_BY_ID_SITUATION', elm.id_situation);
					$('.modalViewBeneficiaire').modal('show');
				},
				addBeneficiaireDetails: function () {
					this.$store.commit("BENEFICIAIRE_SET_SELECTED", 0);
					$('.modalViewBeneficiaire').modal('show');
				}
			},
			template: '#beneficiairesList'
		}
	);

	Vue.component(
		'beneficiaireAdd',
		{
			data: function () {
				return ({
					typeBenef: null,
					relBenef: null,
					civ1: null,
					nom1: null,
					prenom1: null,
					civ2: null,
					nom2: null,
					prenom2: null,
					denomCommer: null
				});
			},
			computed: {
				seulOrCouple: function() {
					//if ((this.relBenef != 'null' && this.typeBenef == 'seul') || (this.typeBenef == 'couple' && this.relBenef != 'couple'))
					if (this.typeBenef == 'seul' || this.typeBenef == 'couple')
						return true;
					return false;
				},
				ishSelf: function(id_phs) {
					if (id_phs == <?= $this->dh->id_dh ?> && hSelf())
						return true;
					return false;
				},
				hSelf: function() {
					if (this.relBenef == 'self' || this.relBenef == 'couple')
						return true;
					return false;
				},
				isSubmitable: function() {
					if (this.typeBenef == 'seul')
					{
						if (this.relBenef == 'null')
							return true;
						if (this.civ1 != null && this.nom1 != null && this.prenom1 != null)
							return true;
						return false;
					}
					else if (this.typeBenef == 'couple')
					{
						if (this.relBenef == 'couple' && this.civ2 != null && this.nom2 != null && this.prenom2 != null)
							return true;
						else if (this.civ1 != null && this.nom1 != null && this.prenom1 != null
							&& this.civ2 != null && this.nom2 != null && this.prenom2 != null)
							return true;
						return false;
					}
					else if (this.typeBenef == 'Pm')
					{
						if (this.denomSociale)
							return true;
					}
					return false;
				}
			},
			methods: {
				changeTypeBenef: function( type ) {
					this.typeBenef = type;
				},
				submitBenef: function()
				{
					if (this.typeBenef == 'seul')
					var data = {'id_dh': <?= $this->dh->id_dh ?>, 'typeBenef': this.typeBenef, 'relBenef': this.relBenef, 'civ1': this.civ1, 'nom1': this.nom1, 'prenom1': this.prenom1 };	
					else if (this.typeBenef == 'couple')
					var data = {'id_dh': <?= $this->dh->id_dh ?>,'typeBenef': this.typeBenef, 'relBenef': this.relBenef, 'civ1': this.civ1, 'nom1': this.nom1, 'prenom1': this.prenom1, 'civ2': this.civ2, 'nom2': this.nom2, 'prenom2': this.prenom2 };
					else if (this.typeBenef == 'Pm')
					var data = {'id_dh': <?= $this->dh->id_dh ?>, 'typeBenef': this.typeBenef, 'relBenef': this.relBenef, 'denomCommer': this.denomCommer};
					this.$store.commit('BENEFICIAIRE_ADD', data);
				}
			},
			template: '#beneficiaireAdd'
		}
	);
	Vue.component(
		'beneficiaireDetails',
		{
			data: function() {
				return ({
					onglet: 0
				});
			},
			computed: {
				selectedBeneficiaire: function() {
					return (this.$store.state.beneficiaire.selectedBeneficiaire);
				},
				selectedBeneficiairePps: function() {
					return (this.$store.getters.getPersonnePhysiqueForBeneficiaire(this.selectedBeneficiaire.id_benf));
				},
				selectedSituationJuridique: function() {
					return (this.$store.state.situationJuridique.selected);
				},
				selectedSituationFinanciere: function() {
					return (this.$store.state.situationFinanciere.selected);
				},
				selectedSituationFiscale: function() {
					return (this.$store.state.situationFiscale.selected);
				},
				selectedSituationPatrimoniale: function() {
					return (this.$store.state.situationPatrimoniale.selected);
				},
			},
			methods: {
				setOnglet: function(onglet) {
					this.onglet = onglet;
					this.$store.dispatch('SET_DEFAULT_SITUATION_JURIDIQUE_BY_ID_SITUATION', this.$store.state.beneficiaire.selectedBeneficiaire.id_situation);
					this.$store.dispatch('SET_DEFAULT_SITUATION_FINANCIERE_BY_ID_SITUATION', this.$store.state.beneficiaire.selectedBeneficiaire.id_situation);
					this.$store.dispatch('SET_DEFAULT_SITUATION_FISCALE_BY_ID_SITUATION', this.$store.state.beneficiaire.selectedBeneficiaire.id_situation);
					this.$store.dispatch('SET_DEFAULT_SITUATION_PATRIMONIALE_BY_ID_SITUATION', this.$store.state.beneficiaire.selectedBeneficiaire.id_situation);
				},
				setSituation: function(elm) {
					this.$store.dispatch('SET_DEFAULT_SITUATION_JURIDIQUE_BY_ID_SITUATION', this.$store.state.beneficiaire.selectedBeneficiaire.id_situation);
					this.$store.dispatch('SET_DEFAULT_SITUATION_FINANCIERE_BY_ID_SITUATION', this.$store.state.beneficiaire.selectedBeneficiaire.id_situation);
					this.$store.dispatch('SET_DEFAULT_SITUATION_FISCALE_BY_ID_SITUATION', this.$store.state.beneficiaire.selectedBeneficiaire.id_situation);
					this.$store.dispatch('SET_DEFAULT_SITUATION_PATRIMONIALE_BY_ID_SITUATION', this.$store.state.beneficiaire.selectedBeneficiaire.id_situation);
				},
				showProjectDetails: function(elm) {
					$('.modalViewBeneficiaire').modal('hide');
					showOnglet('PROJETS');
					eval('init_ProjetClient2();');
					this.$store.commit("PROJECTS_SET_SELECTED", elm);
					$('#modalProjet').modal('show');
				}
			},
			template: '#beneficiaireDetails'
		}
	);
