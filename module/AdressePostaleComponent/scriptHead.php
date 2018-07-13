</script>

<script type="text/x-template" id="adressePostaleTemplate">
	<div class="modal fade modal-mscpi" id="modal_adresse_postale"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" data-backdrop="static" data-keyboard="false" >
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-center">Adresse postale</h4>
					<div class="modal-trait"></div>
				</div>
				<div class="modal-body">
					<div>
						Pouvez-vous compléter votre adresse postale ?
					</div>
					<div class="inputFormAdresse">
						<div>Pays <span class="err">*</span></div>
						<select v-model="getPp.pays" :class="{inputError: typeof getError.pays != 'undefined'}">
							<?php
							foreach (Pays::getAll() as $key => $elm)
							{
								?>
								<option value="<?= $elm->nom_fr_fr ?>"><?= $elm->nom_fr_fr ?></option>
								<?php
							}
							?>
						</select>
					</div>
					<div class="errorMsg" v-if="typeof getError.pays != 'undefined'">
						<div></div>
						<div>
							{{ getError.pays }}
						</div>
					</div>

					<div class="inputFormAdresse">
						<div>Nº <span class="err">*</span></div>
						<input min="1" type="number" v-model="getPp.numeroRue" :class="{inputError: typeof getError.numero != 'undefined'}"/>
					</div>

					<div class="errorMsg" v-if="typeof getError.numero != 'undefined'">
						<div></div>
						<div>
							{{ getError.numero }}
						</div>
					</div>

					<div class="inputFormAdresse">
						<div>Extension</div>
						<input type="text" v-model="getPp.extension"/>
					</div>

					<div class="inputFormAdresse" >
						<div>Type de voie <span class="err">*</span></div>
						<select v-model="getPp.type_voie" :class="{inputError: typeof getError.type_voie != 'undefined'}">
							<?php
							foreach (Pp::$_type_voie as $key => $elm)
							{
								?>
								<option value="<?=$elm?>"><?=$elm?></option>
								<?php
							}
							?>
						</select>
					</div>

					<div class="errorMsg" v-if="typeof getError.type_voie != 'undefined'">
						<div></div>
						<div>
							{{ getError.type_voie }}
						</div>
					</div>

					<div class="inputFormAdresse">
						<div>Complément d'adresse </div>
						<input type="text" v-model="getPp.complementAdresse"/>
					</div>

					<div class="inputFormAdresse">
						<div>Voie <span class="err">*</span></div>
						<input type="text" v-model="getPp.voie" :class="{inputError: typeof getError.voie != 'undefined'}"/>
					</div>


					<div class="errorMsg" v-if="typeof getError.voie != 'undefined'" >
						<div></div>
						<div>
							{{ getError.voie }}
						</div>
					</div>

					<datalist id="codePostalList">
						<option v-for="(elm, key) in List">{{ elm.Nom_commune }} / {{ elm.Code_postal }}</option>
					</datalist>

					<div class="inputFormAdresse">
						<div>Code postal <span class="err">*</span></div>
						<input type="text" v-model="getPp.codePostal" list="codePostalList" @input="getCodeVille" :class="{inputError: typeof getError.code_postal != 'undefined'}"/>
					</div>

					<div class="errorMsg" v-if="typeof getError.code_postal != 'undefined'">
						<div></div>
						<div>
							{{ getError.code_postal }}
						</div>
					</div>

					<div class="inputFormAdresse">
						<div>Ville <span class="err">*</span></div>
						<input type="text" v-model="getPp.ville"  list="codePostalList"  @input="getCodeVille" :class="{inputError: typeof getError.ville != 'undefined'}"/>
					</div>

					<div class="errorMsg" v-if="typeof getError.ville != 'undefined'">
						<div></div>
						<div>
							{{ getError.ville }}
						</div>
					</div>

					<div>
						<button class="btn-mscpi" @click="saveAdressePostale(getPp)">ENREGISTRER</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</script>

<script>
	 Vue.component(
		'adressePostaleComponent',
		{
			data: function() {
				return ({
					List: {}
				});
			},
			computed: {
				getPp: function() {
					return (this.$store.getters.getPersonnePhysique2);
				},
				getError: function() {
					return (this.$store.getters.getPersonnePhysiqueAdressError);
				}
			},
			methods: {
				validate: function(elm) {
					var value = String(elm.target.value).split(" / ", 2);
					if (value.length < 2)
						return ;
					for (var l in this.List)
					{
						if (this.List[l].Nom_commune == value[0] && this.List[l].Code_postal == value[1])
						{
							this.$store.commit("PP_UPDATE_ADRESSE", {
								code: value[1],
								ville: value[0],
							})
							return (true);
						}
					}
					return (false);
				},
				getCodeVille: function getFromCodeCommune(elm) {
					if (this.getPp.pays != "France")
						return ;
					var that = this;
					if (this.validate(elm))
						return ;
					var codeVal = this.getPp.codePostal;
					var communeVal = this.getPp.ville;
					Vue.http.post(
							'index.php?p=GetCodeVille',
							{
								code: codeVal,
								commune: communeVal,
								token: "<?=$_SESSION['csrf'][0]?>"
							},
							{emulateJSON: true}
						).then(
							function (res) {
								Vue.set(that, "List", res.body);
							},
							function() {}
						);
				},
				saveAdressePostale: function(Pp) {
					this.$store.dispatch("PP_SAVE_ADRESSE_POSTALE", Pp).then(
						function() {
							$("#modal_adresse_postale").modal("hide");
							msgBox.show("Votre adresse postale à bien été enregistrée !");
						},
						function() {}
					);
				}			},
			template: '#adressePostaleTemplate'
		}
	);
