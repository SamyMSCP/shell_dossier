<?php
include("listeNationalite.php")
?>
</script>
<script type="text/x-template" id="personne-physique-detail">
	<div class="modal fade" id="modalPp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" style="border-radius: 15px;">
			<div class="modal-content" style="background-color: #EBEBEB;border-radius: 15px;">
				<div class="modal-body">
					<h1>PERSONNE PHYSIQUE</h1>
					<div class="traitOrange"></div>
						<div style="margin-top:20px;max-width: 542px;margin-left: auto;margin-right: auto;">


							<div class="form-group">
							<label class="labelForm control-label" for="prenom">Id</label>
								<div class="inputForm">
									{{ selectedPp.id }}
								</div>
							</div>
							<div class="blockContact">
								<button style="height:80px;width: 80px;flex:0;" class="btn-mscpi" :class="{'btn-not-check' : selectedPp.civilite != 'Monsieur'}" @click="changeCivilite('Monsieur')">
									<img v-if="selectedPp.civilite == 'Monsieur'" src="<?=$this->getPath()?>img/Gender-blanc_Homme.png"/>
									<img v-else src="<?=$this->getPath()?>img/Gender_Homme.png"/>
								</button>
								<button style="height:80px;width: 80px;flex:0;" class="btn-mscpi" :class="{'btn-not-check' : selectedPp.civilite != 'Madame'}" @click="changeCivilite('Madame')">
									<img v-if="selectedPp.civilite == 'Madame'" src="<?=$this->getPath()?>img/Gender-blanc_Femme.png"/>
									<img v-else src="<?=$this->getPath()?>img/Gender_Femme.png"/>
								</button>
							</div>

							<div class="form-group">
							<label class="labelForm control-label" for="prenom">Prénom</label>
								<div class="inputForm">
									<input v-model="selectedPp.prenom" type="text" id="prenom" maxlength="256" placeholder="Prénom" class="form-control input-md">
								</div>
							</div>

							<div class="form-group">
								<label class="labelForm control-label" for="nom">Nom</label>
								<div class="inputForm">
									<input v-model="selectedPp.nom" type="text" id="nom" maxlength="256" placeholder="Nom" class="form-control input-md">
								</div>
							</div>


							<div class="form-group" v-if="selectedPp.civilite == 'Madame'">
								<label class="labelForm control-label" for="nom_jeune_fille">Nom de jeune fille</label>
								<div class="inputForm">
									<input v-model="selectedPp.nom_jeune_fille" type="text" id="nom_jeune_fille" maxlength="256" placeholder="Nom de jeune fille" class="form-control input-md">
								</div>
							</div>

							<div class="form-group">
							<label class="labelForm control-label" for="mail">Mail</label>
								<div class="inputForm">
									<input v-model="selectedPp.mail" type="text" id="mail" maxlength="256" placeholder="E-mail" class="form-control input-md">
								</div>
							</div>

							<form action="#" method="get" accept-charset="utf-8" onkeypress="return event.keyCode != 13;">

								<div class="form-group"> <label class="labelForm control-label" for="indicatif">Indicatif téléphonique</label>  
									<div class="inputForm">
										<div class="arrSelect" style="border : 1px solid #ccC !important;" id="selectInd">
											<select
												id="countries_phone3"
												class="form-control bfh-countries"
												data-country='FR'
												v-model="selectedPp.indicatif_telephonique"
											>
											</select>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label class="labelForm control-label" for="num">Téléphone Portable</label>
									<div class="inputForm">
										<input
											v-model="selectedPp.telephone"
											id="num"
											type="text"
											class="form-control bfh-phone"
											data-country="countries_phone3"
											required
										>
									</div>
								</div>

								<div class="form-group"> <label class="labelForm control-label" for="indicatif">Indicatif téléphonique fixe</label>  
									<div class="inputForm">
										<div class="arrSelect" style="border : 1px solid #ccC !important;" id="selectInd">
											<select
												id="countries_phone4"
												class="form-control bfh-countries"
												data-country='FR'
												v-model="selectedPp.indicatif_telephonique_fixe"
											>
											</select>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label class="labelForm control-label" for="num_fixe">Téléphone fixe</label>
									<div class="inputForm">
										<input
											v-model="selectedPp.telephone_fixe"
											id="num_fixe"
											type="text"
											class="form-control bfh-phone"
											data-country="countries_phone4"
											required
										>
									</div>
								</div>
								
							</form>

							<div class="form-group">
								<label class="labelForm control-label" for="date_naissance">Date de naissance</label>
								<div class="inputForm">
									<my-datepicker id="dateNaissance" v-model="selectedPp.date_naissance"></my-datepicker>
								</div>
							</div>

							<div class="form-group">
								<label class="labelForm control-label" for="lieu_naissance">Lieu de naissance</label>
								<div class="inputForm">
									<input v-model="selectedPp.lieu_naissance" type="text" id="lieu_naissance" maxlength="256" placeholder="Lieu de naissance" class="form-control input-md">
								</div>
							</div>

							<div class="form-group">
								<label class="labelForm control-label" for="pays_de_naissance">Pays de naissance</label>  
								<div class="inputForm">
									<my-select v-model="selectedPp.paysNaissance" id="pays_de_naissance" name="pays_de_naissance" class="form-control">
										<?php
										foreach (Pays::getAll() as $key => $elm)
										{
											?>
											<option value="<?=$elm->nom_fr_fr?>"><?=$elm->nom_fr_fr?></option>
											<?php
										}
										?>
									</my-select>
								</div>
							</div>


							<div class="form-group">
								<label class="labelForm control-label" for="etat_civil">Etat civil</label>
								<div class="inputForm">
									<my-select v-model="selectedPp.etat_civil" id="etat_civil" class="form-control" >
										<option value="marie">Marié(e)</option>
										<option value="pacse">Pacsé(e)</option>
										<option value="unionlibre">Union libre</option>
										<option value="celibataire">Célibataire</option>
										<option value="veuf">Veuf(e)</option>
										<option value="divorce">Divorce</option>
									</my-select>
								</div>
							</div>

							<div class="form-group">
								<label class="labelForm control-label" for="nom">Nationalite</label>  
								<div class="inputForm">
									<my-select v-model="selectedPp.nationalite" name="nationalite" id="Nationalite" class="form-control">
										<?php
										foreach ($lstNat as $key => $elm)
										{
											?>
											<option value="<?=$elm['title']?>"><?=$elm['title']?></option>
											<?php
										}
										?>
									</my-select>
								</div>
							</div>

							<div class="form-group">
							<label class="labelForm control-label" for="profession">Profession</label>
								<div class="inputForm">
									<input v-model="selectedPp.profession" type="text" id="profession" maxlength="256" placeholder="Profession" class="form-control input-md">
								</div>
							</div>

							<div class="form-group">
							<label class="labelForm control-label" for="numeroRue">Numéro de rue</label>
								<div class="inputForm">
									<input v-model="selectedPp.numeroRue" type="text" id="numeroRue" maxlength="256" placeholder="Numéro de rue" class="form-control input-md">
								</div>
							</div>

							<div class="form-group">
							<label class="labelForm control-label" for="voie">Type de voie</label>
								<div class="inputForm">
									<select v-model="selectedPp.type_voie" type="text" id="type_voie" class="form-control input-md">
										<option v-for="tv in lstTypeVoie" :value="tv">{{ tv }}</option>
									</select>
								</div>
							</div>


							<div class="form-group">
							<label class="labelForm control-label" for="voie">Voie</label>
								<div class="inputForm">
									<input v-model="selectedPp.voie" type="text" id="voie" maxlength="256" placeholder="Voie" class="form-control input-md">
								</div>
							</div>

							<div class="form-group">
							<label class="labelForm control-label" for="codePostal">Code postal</label>
								<div class="inputForm">
									<input v-model="selectedPp.codePostal" type="text" id="codePostal" maxlength="256" placeholder="codePostal" class="form-control input-md">
								</div>
							</div>

							<div class="form-group">
							<label class="labelForm control-label" for="ville">Ville</label>
								<div class="inputForm">
									<input v-model="selectedPp.ville" type="text" id="ville" maxlength="256" placeholder="Ville" class="form-control input-md">
								</div>
							</div>

							<div class="form-group">
							<label class="labelForm control-label" for="pays">Pays</label>
								<div class="inputForm">
									<my-select v-model="selectedPp.pays"  id="pays" name="pays" >
										<?php
										foreach (Pays::getAll() as $key => $elm)
										{
											?>
											<option value="<?=$elm->nom_fr_fr?>"><?=$elm->nom_fr_fr?></option>
											<?php
										}
										?>
									</my-select>
								</div>
							</div>

							<div class="form-group">
								<label class="labelForm control-label" for="us_person">US Person ?</label>
								<div class="inputForm">
									<label class="radio-inline" for="us_person-0">
										<input type="radio" id="us_person-0" v-model="selectedPp.us_person" value="1"><span></span>
										Oui
									</label>
									<label class="radio-inline" for="us_person-1">
										<input type="radio" id="us_person-1" v-model="selectedPp.us_person" value="0"><span></span>
										Non
									</label>
								</div>
							</div>

							<div class="form-group">
								<label class="labelForm control-label" for="politique">politiquement exposée ?</label>
								<div class="inputForm">
									<label class="radio-inline" for="politique-0">
										<input type="radio" v-model="selectedPp.politique" id="politique-0" value="1" ><span></span>
										Oui
									</label>
									<label class="radio-inline" for="politique-1">
										<input type="radio" v-model="selectedPp.politique" id="politique-1" value="0"><span></span>
										Non
									</label>
								</div>
							</div>
						</div>


						<div class="align-btn-center">
							<button v-if="selectedPp.haveBeneficiaireSeul === false && selectedPp.id != 0" @click="addBeneficiaireSeul()" class="btn-mscpi btn-orange">Ajouter Beneficiaire</button>
							<button @click="saveSelected()" v-if="selectedPp.id != 0" class="btn-mscpi">Modifier</button>
							<button @click="saveSelected()"  v-else class="btn-mscpi">Ajouter</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</script>

<script type="text/x-template" id="personne-physique">
	<div>
		<div @click="changeSelectedPersonnePhysique(Pp)" class="personneElement1" v-for="Pp in lstPersonnePhysique">
			<div class="personneElement2">
				<h3>
					{{Pp.civilite}} {{Pp.prenom}} {{Pp.nom}}
				</h3>
				<div>
					<img v-if="Pp.civilite == 'Monsieur'" src="<?=$this->getPath()?>img/Gender-blanc_Homme.png" alt="" />
					<img v-else src="<?=$this->getPath()?>img/Gender-blanc_Femme.png" alt="" />
				</div>
			</div>
		</div>
		<div class="personneElement1" @click="addPersonnePhysique()">
			<div class="personneElement2_dashed">
				<h2>NOUVELLE<br />PERSONNE PHYSIQUE</h2>
				<div>
					<img src="<?=$this->getPath()?>img/Plus-bleuclair-01.png" alt="" />
				</div>
			</div>
		</div>
	</div>
</script>

<script type="text/javascript" charset="utf-8">
<?php
/*
	store.registerModule('personne_physique', {
		state: {
			name: "Mathieu"
		},
		mutations : {
			PERSONNE_PHYSIQUE_TEST: function(state, data) {
				console.log(state);
			}
		},
		actions: {
			PERSONNE_PHYSIQUE_UPDATE_ALL: function(context, data) {
				// Boucle sur les personnes Physique.
				// Lancer une requete pour mettre a jours l'element.
				// commit le changement
			},
			PERSONNE_PHYSIQUE_GET: function(context, data) {
				// Lancer une requete pour mettre recuperer l'element
				// commit le changement
			},
			PERSONNE_PHYSIQUE_POST: function(context, data) {
				// Pour creer une nouvelle personne Physique
				// committer l'insertiotn de l'elemt si okay
				// dans le return on appel resolve, ou reject
				// C'est le component lui meme qui decide si il doit determiner
				//     son comportement en fnction de ca.
			}
		},
		getters: {
			get: function(state, getters) {
				return ("coucou");
			}
		}
	})
	*/

	?>

	function init_PersonneClient2() {

	}

	function PersonneStore() {
		var that = this;
		this.lstPersonnePhysique = <?=json_encode($this->lstPersonnePhysique)?>;
		this.selectedPp = this.lstPersonnePhysique[0];
		this.createPersonnePhysique = function() {
			var rt = {
				id: 0,
				civilite: "",
				nom_jeune_fille: "",
				nom: "",
				prenom: "",
				mail: "",
				telephone: "",
				indicatif_telephonique: "",
				telephone_fixe: "",
				indicatif_telephonique_fixe: "",
				date_naissance: 0,
				lieu_naissance: "",
				nationalite: "",
				etat_civil: "",
				us_person: "",
				politique: "",
				complementAdresse: "",
				numeroRue: "",
				type_voie: "",
				voie: "",
				codePostal: "",
				ville: "",
				pays: "",
				paysNaissance: "",
				profession: "",
				haveBeneficiaireSeul: false
			}
			return (rt);
		};
		this.lstTypeVoie = <?=json_encode(Pp::$_type_voie)?>;
		this.newPersonnePhysique = this.createPersonnePhysique();
		this.saveSelected = function () {
			this.$http.post('ajax_request.php?client=<?=$GLOBALS['GET']['client']?>', {
				req: 'updatePp',
				data: this.selectedPp,
				token: "<?=$_SESSION['csrf'][0]?>"
			}, {emulateJSON: true}).then(
				function (res) {
					if (that.selectedPp.id == 0)
						that.newPersonnePhysique = that.createPersonnePhysique();
					that.lstPersonnePhysique = res.body;
					$('#modalPp').modal('hide');
				},
				function (res) {
						if (typeof res.body.err != 'undefined')
						msgBox.show(res.body.err);
					else 
						msgBox.show("La Personne Physique n'a pas pu etre enregistrée !");
				}
			);
			return ;
		};
		this.addBeneficiaireSeul =  function() {
			this.$http.post('ajax_request.php?client=<?=$GLOBALS['GET']['client']?>', {
				req: 'AddBeneficiaireSeul',
				data: that.selectedPp,
				token: "<?=$_SESSION['csrf'][0]?>"
			}, {emulateJSON: true}).then(
				function (res) {
					that.lstPersonnePhysique = res.body[0];
					$('#modalPp').modal('hide');
				},
				function (res) {
					if (typeof res.body.err != 'undefined')
						msgBox.show(res.body.err);
					else 
						msgBox.show("La Personne Physique n'a pas pu etre enregistrée !");
				}
			);
			return ;
		};
	}

	var myPersonneStore = new PersonneStore();

	Vue.component(
		'test',
		{
			data: function() {
				return (myPersonneStore);
			},
			template: '#personne-physique-detail',
			methods: {
				changeCivilite: function(civ) {
					this.selectedPp.civilite = civ;
				}
			}
		}
	);


	Vue.component(
		'personnePhysiqueDetail',
		{
			data: function() {
				return (myPersonneStore);
			},
			template: '#personne-physique-detail',
			methods: {
				changeCivilite: function(civ) {
					this.selectedPp.civilite = civ;
				},
			}
		}
	);

	Vue.component(
		'personnePhysiqueTable',
		{
			data: function() {
				return (myPersonneStore);
			},
			template: '#personne-physique',
			methods: {
				changeSelectedPersonnePhysique: function (Pp) {
					this.selectedPp = JSON.parse(JSON.stringify(Pp));
					$('#modalPp').modal('show');
				},
				addPersonnePhysique: function() {
					this.selectedPp = this.newPersonnePhysique;
					$('#modalPp').modal('show');
				}
			}
		}
	);
