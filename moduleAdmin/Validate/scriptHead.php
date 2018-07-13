</script>
<script type="text/x-template" id="centreinteretscomponent">
<div>
	<div class="modal fade modadel modal-mscpi" id="modal_centreinteret"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog">
			<div class="modal-content" v-if="Object.keys($store.state.dh.actual).length">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="<?= $this->getPath() ?>img/Close-Jaune.svg" alt="" /></button>
					<h4 class="modal-title text-center">CENTRES D’INTÉRÊTS</h4>
					<div class="modal-trait"></div>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="checkbox-mscpi-col-3">
							<h6 class="modal-subtitle center-block text-center">Achat de parts</h6>
							<div class="checkbox-mscpi">
								<input id="pp" :checked="$store.state.dh.actual.ci[1]" @click="$store.commit('TOGGLE_ACTUAL_CI', [1, [2,3,4]])" type="checkbox"><label for="pp">Pleine propriété</label>
								<div class="checkbox-mscpi checkbox-mscpi-margsup">
									<input id="cf" :checked="$store.state.dh.actual.ci[2]"  @click="$store.commit('TOGGLE_ACTUAL_CI', [2])" :disabled="$store.state.dh.actual.ci[1]" type="checkbox"><label for="cf">Capital fixe</label>
								</div>
								<div class="checkbox-mscpi">
									<input id="cv" :checked="$store.state.dh.actual.ci[3]"   @click="$store.commit('TOGGLE_ACTUAL_CI', [3])" :disabled="$store.state.dh.actual.ci[1]" type="checkbox"><label for="cv">Capital variable</label>
								</div>
								<div class="checkbox-mscpi checkbox-mscpi-margdown">
									<input id="cpv" :checked="$store.state.dh.actual.ci[4]"  @click="$store.commit('TOGGLE_ACTUAL_CI', [4])" :disabled="$store.state.dh.actual.ci[1]" type="checkbox"><label for="cpv">Capitalisation/Plue-value</label>
								</div>
							</div>
							<div class="checkbox-mscpi">
								<input id="demb" :checked="$store.state.dh.actual.ci[5]"  @click="$store.commit('TOGGLE_ACTUAL_CI', [5, [6,7,8]])" type="checkbox"><label for="demb">Démembrement</label>
								<div class="checkbox-mscpi checkbox-mscpi-margsup">
									<input id="nue" :checked="$store.state.dh.actual.ci[6]"  @click="$store.commit('TOGGLE_ACTUAL_CI', [6])" :disabled="$store.state.dh.actual.ci[5]" type="checkbox"><label for="nue">Nue-propriété</label>
								</div>
								<div class="checkbox-mscpi">
									<input id="usu" :checked="$store.state.dh.actual.ci[7]"  @click="$store.commit('TOGGLE_ACTUAL_CI', [7])" :disabled="$store.state.dh.actual.ci[5]" type="checkbox"><label for="usu">Usufruit</label>
								</div>
								<div class="checkbox-mscpi checkbox-mscpi-margdown">
									<input id="cred" :checked="$store.state.dh.actual.ci[8]"  @click="$store.commit('TOGGLE_ACTUAL_CI', [8])" :disabled="$store.state.dh.actual.ci[5]" type="checkbox"><label for="cred">SCPI à crédit</label>
								</div>
							</div>
							<div class="checkbox-mscpi">
								<input id="pd" :checked="$store.state.dh.actual.ci[9]"  @click="$store.commit('TOGGLE_ACTUAL_CI', [9])" type="checkbox"><label for="pd">Parts décôtées</label>
							</div>
							<div class="checkbox-mscpi checkbox-mscpi-margdown ">
								<input id="finpart" :checked="$store.state.dh.actual.ci[10]"  @click="$store.commit('TOGGLE_ACTUAL_CI', [10])" type="checkbox"><label for="finpart">Financement des parts</label>
							</div>
						</div>
						<div class="checkbox-mscpi-col-3">
							<h6 class="modal-subtitle center-block text-center">SCPI</h6>
							<div class="checkbox-mscpi">
								<input id="jscpi" :checked="$store.state.dh.actual.ci[11]" @click="$store.commit('TOGGLE_ACTUAL_CI', [11])"  type="checkbox"><label for="jscpi">Jeunes SCPI</label>
							</div>
							<div class="checkbox-mscpi">
								<input id="scpithem" :checked="$store.state.dh.actual.ci[12]" @click="$store.commit('TOGGLE_ACTUAL_CI', [12, [13,14,15]])" type="checkbox"><label for="scpithem">SCPI thématiques</label>
								<div class="checkbox-mscpi checkbox-mscpi-margsup">
									<input id="sant" :checked="$store.state.dh.actual.ci[13]" :disabled="$store.state.dh.actual.ci[12]" @click="$store.commit('TOGGLE_ACTUAL_CI', [13])" type="checkbox"><label for="sant">Santé</label>
								</div>
								<div class="checkbox-mscpi">
									<input id="hotel" :checked="$store.state.dh.actual.ci[14]" :disabled="$store.state.dh.actual.ci[12]" @click="$store.commit('TOGGLE_ACTUAL_CI', [14])" type="checkbox"><label for="hotel">Hôtels</label>
								</div>
								<div class="checkbox-mscpi checkbox-mscpi-margdown">
									<input id="devdur" :checked="$store.state.dh.actual.ci[15]" :disabled="$store.state.dh.actual.ci[12]" @click="$store.commit('TOGGLE_ACTUAL_CI', [15])" type="checkbox"><label for="devdur">Dév. durable</label>
								</div>
							</div>
							<div class="checkbox-mscpi">
								<input id="locgeo" :checked="$store.state.dh.actual.ci[16]"@click="$store.commit('TOGGLE_ACTUAL_CI', [16, [17,18,19,20]])" type="checkbox"><label for="locgeo">Localisation géographique</label>
								<div class="checkbox-mscpi checkbox-mscpi-margsup">
									<input id="region" :checked="$store.state.dh.actual.ci[17]" :disabled="$store.state.dh.actual.ci[16]" @click="$store.commit('TOGGLE_ACTUAL_CI', [17])" type="checkbox"><label for="region">Régions (France)</label>
								</div>
								<div class="checkbox-mscpi">
									<input id="paris" :checked="$store.state.dh.actual.ci[18]" :disabled="$store.state.dh.actual.ci[16]" @click="$store.commit('TOGGLE_ACTUAL_CI', [18])" type="checkbox"><label for="paris">Paris</label>
								</div>
								<div class="checkbox-mscpi">
									<input id="monde" :checked="$store.state.dh.actual.ci[19]" :disabled="$store.state.dh.actual.ci[16]" @click="$store.commit('TOGGLE_ACTUAL_CI', [19])" type="checkbox"><label for="monde">Monde</label>
								</div>
								<div class="checkbox-mscpi checkbox-mscpi-margdown">
									<input id="europe" :checked="$store.state.dh.actual.ci[20]" :disabled="$store.state.dh.actual.ci[16]" @click="$store.commit('TOGGLE_ACTUAL_CI', [20])" type="checkbox"><label for="europe">Europe</label>
								</div>
							</div>
							<div class="checkbox-mscpi">
								<input id="conjimmo" :checked="$store.state.dh.actual.ci[21]"@click="$store.commit('TOGGLE_ACTUAL_CI', [21])" type="checkbox"><label for="conjimmo">Conjoncture immobilière</label>
							</div>
						</div>
						<div class="checkbox-mscpi-col-3">
							<h6 class="modal-subtitle center-block text-center">Ouverture</h6>
							<div class="checkbox-mscpi">
								<input id="fisc" :checked="$store.state.dh.actual.ci[22]"@click="$store.commit('TOGGLE_ACTUAL_CI', [22, [23,24,25,26]])" type="checkbox"><label for="fisc">Fiscalité/Défiscalisation</label>
								<div class="checkbox-mscpi checkbox-mscpi-margsup">
									<input id="deffonc" :checked="$store.state.dh.actual.ci[23]" :disabled="$store.state.dh.actual.ci[22]" @click="$store.commit('TOGGLE_ACTUAL_CI', [23])" type="checkbox"><label for="deffonc">Déficit foncier</label>
								</div>
								<div class="checkbox-mscpi">
									<input id="isf" :checked="$store.state.dh.actual.ci[24]" :disabled="$store.state.dh.actual.ci[22]" @click="$store.commit('TOGGLE_ACTUAL_CI', [24])" type="checkbox"><label for="isf">ISF</label>
								</div>
								<div class="checkbox-mscpi">
									<input id="malraux" :checked="$store.state.dh.actual.ci[25]" :disabled="$store.state.dh.actual.ci[22]" @click="$store.commit('TOGGLE_ACTUAL_CI', [25])" type="checkbox"><label for="malraux">Malraux</label>
								</div>
								<div class="checkbox-mscpi checkbox-mscpi-margdown">
									<input id="pinel" :checked="$store.state.dh.actual.ci[26]" :disabled="$store.state.dh.actual.ci[22]" @click="$store.commit('TOGGLE_ACTUAL_CI', [26])" type="checkbox"><label for="pinel">Pinel</label>
								</div>
							</div>
							<div class="checkbox-mscpi">
								<input id="fintech" :checked="$store.state.dh.actual.ci[27]"
								@click="$store.commit('TOGGLE_ACTUAL_CI', [27])" type="checkbox"><label for="fintech">FinTech (nouveautés)</label>
							</div>
							<div class="checkbox-mscpi">
								<input id="asso" :checked="$store.state.dh.actual.ci[28]" @click="$store.commit('TOGGLE_ACTUAL_CI', [28])" type="checkbox"><label for="asso">Devenir associé-fondateur</label>
							</div>
							<div class="checkbox-mscpi checkbox-mscpi-corrheight">
								<input id="cons" :checked="$store.state.dh.actual.ci[29]" @click="$store.commit('TOGGLE_ACTUAL_CI', [29])" type="checkbox"><label for="cons"><span>Être membre du conseil de </span><span>surveillance</span></label>
							</div>
							<div class="checkbox-mscpi">
								<input id="investloc" :checked="$store.state.dh.actual.ci[30]" @click="$store.commit('TOGGLE_ACTUAL_CI', [30])" type="checkbox"><label for="investloc">Investissement locatif</label>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="bttn-mscpi-ctn center-block">
						<button class="btn-mscpi" @click="nextModal"><span>SUIVANT</span></button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade modadel modal-mscpi" id="modal_centreinteretscpi" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog">
			<div class="modal-content" v-if="Object.keys($store.state.dh.actual).length">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="<?= $this->getPath() ?>img/Close-Jaune.svg" alt="" /></button>
					<h4 class="modal-title text-center">ALERTES ACTUALITÉS</h4>
					<div class="modal-trait"></div>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="checkbox-mscpi-col-2">
							<h6 class="modal-subtitle">SCPI présentes dans le portefeuille</h6>
							<div v-for="scpi in $store.state.dh.Dh.scpi" class="checkbox-mscpi">
								<input :id="scpi.id_scpi" 
								@click="$store.commit('TOGGLE_ACTUAL_CISCPI', [scpi.id_scpi])" type="checkbox" :checked="$store.getters.getActualCISCPI[scpi.id_scpi]"><label :for="scpi.id_scpi">{{ $store.getters.getScpi(scpi.id_scpi).name | unprefix_scpi }}</label>
							</div>
						</div>
						<form class="checkbox-mscpi-col-2">
							<h6 class="modal-subtitle">Autres SCPI (maximum 3)</h6>
							<select class="form-control select-mscpi" v-model="ciscpi_1" v-bind:class="{ 'select-mscpi-nochoice' : isCISPCI_1Null }">
								<option :value="null">Choisir une SCPI</option>
								<option v-for="scpi in ScpiNotCISCPI($store.state.scpi.lst, 1)" :value="scpi" :disabled="(ciscpi_2 != null && ciscpi_2 == scpi) || (ciscpi_3 != null && ciscpi_3 == scpi)">{{ scpi.name | unprefix_scpi }}</option>
							</select>
							<select class="form-control select-mscpi" v-model="ciscpi_2" v-bind:class="{ 'select-mscpi-nochoice' : isCISPCI_2Null }">
								<option :value="null">Choisir une SCPI</option>
								<option v-for="scpi in ScpiNotCISCPI($store.state.scpi.lst, 2)" :value="scpi" :disabled="(ciscpi_1 != null && ciscpi_1 == scpi) || (ciscpi_3 != null && ciscpi_3 == scpi)">{{ scpi.name | unprefix_scpi }}</option>
							</select>
							<select class="form-control select-mscpi" v-model="ciscpi_3" v-bind:class="{ 'select-mscpi-nochoice' : isCISPCI_3Null }">
								<option :value="null"s>Choisir une SCPI</option>
								<option v-for="scpi in ScpiNotCISCPI($store.state.scpi.lst, 3)" :value="scpi" :disabled="(ciscpi_1 != null && ciscpi_1 == scpi) || (ciscpi_2 != null && ciscpi_2 == scpi)">{{ scpi.name | unprefix_scpi }}</option>
							</select>
						</form>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn-mscpi" @click="closeModal">VALIDER</button>
				</div>
			</div>
		</div>
	</div>
</div>
</script>
<script>
