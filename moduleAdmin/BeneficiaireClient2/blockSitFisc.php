<div v-if="onglet == 3">
	<select v-model="$store.state.situationFiscale.selected" class="selectBen">
		<option v-if="typeof $store.state.situationFiscale._new.id_situation != 'undefined' && $store.state.situationFiscale._new.id_situation == selectedBeneficiairePps[0].id_situation" :value="$store.state.situationFiscale._new">Nouvelle situation</option>
		<option v-for="situation in $store.getters.getSituationFiscaleForPp(selectedBeneficiairePps[0])" :value="situation">{{ situation.date_situation | tsDate }}</option>
	</select>
	<div class="SimpleFormulaire" v-if="typeof selectedSituationFiscale.date_situation != 'undefined'" :class="{form_disabled: selectedSituationFiscale.id != 0}">

		<div >
			<div class="label">
				Créateur
			</div>
			<div>
				{{ selectedSituationFiscale.creatorShortName }}
			</div>
		</div>
		<div >
			<div class="label">
				Date de la situation :
			</div>
			<div>
				<my-datepicker  id="sit_fisc_date" v-model="selectedSituationFiscale.date_situation" disabled></my-datepicker>
			</div>
		</div>

		<div >
			<div class="label">
				Date d'expiration
			</div>
			<div>
				<my-datepicker id="sit_fisc_date_fin" v-model="selectedSituationFiscale.date_fin_situation" disabled></my-datepicker>
			</div>
		</div>

		<div class="subtitle">
			<div>
				SITUATION FISCALE DE {{ selectedBeneficiaire.shortName | upper }}
			</div>
			<div></div>
		</div>

		<div >
			<div class="label">
				Résident fiscal en France ?
			</div>
			<div :class="{tablehaveError: selectedSituationFiscale.residence_france.length < 1}">
				<label class="radio" for="residence_principale-1">
					<input v-model="selectedSituationFiscale.residence_france" type="radio" id="residence_principale-1" value="0"  :disabled="selectedSituationFiscale.id != 0" />
					<span></span>
					oui
				</label>
				<label class="radio" for="residence_principale-0">
					<input  v-model="selectedSituationFiscale.residence_france" type="radio" id="residence_principale-0" value="1"  :disabled="selectedSituationFiscale.id != 0" />
					<span></span>
					non
				</label>
			</div>
		</div>

		<div v-if="selectedSituationFiscale.residence_france == 1">
			<div class="label">
				Précisez le pays
			</div>
			<div>
				<select :disabled="selectedSituationFiscale.id != 0" v-model="selectedSituationFiscale.pays" class="form-control">
					<?php
					foreach (Pays::getAll() as $key => $elm)
					{
						?>
						<option value="<?=$elm->nom_fr_fr?>"><?=$elm->nom_fr_fr?></option>
						<?php
					}
					?>
				</select>
			</div>
		</div>

		<div class="subtitle">
			<div>
				IMPÔTS SUR LE REVENU
			</div>
			<div></div>
		</div>

		<div >
			<div class="label">
				assujetti à l’impôt sur le revenu ?
			</div>
			<div :class="{tablehaveError: selectedSituationFiscale.haveImpot.length < 1}">
				<label class="radio" for="haveImpot-1">
					<input type="radio" id="haveImpot-1" value="1" :disabled="selectedSituationFiscale.id != 0" v-model="selectedSituationFiscale.haveImpot"/>
					<span></span>
					oui
				</label>
				<label class="radio" for="haveImpot-0">
					<input type="radio" id="haveImpot-0" value="0" :disabled="selectedSituationFiscale.id != 0" v-model="selectedSituationFiscale.haveImpot"/>
					<span></span>
					non
				</label>
			</div>
		</div>

		<div v-if="selectedSituationFiscale.haveImpot == 1">
			<div class="label">
				impôt au titre de l’année précédente (en €)
			</div>
			<div  :class="{tablehaveError: selectedSituationFiscale.impot_annee_precedente.length < 1}">
				<input class="form-control" type="number" min="0" :disabled="selectedSituationFiscale.id != 0" v-model="selectedSituationFiscale.impot_annee_precedente"/>
			</div>
		</div>

		<div v-if="selectedSituationFiscale.haveImpot == 1">
			<div class="label">
				Quelle est la tranche marginale d’imposition (%)
			</div>
			<div :class="{tablehaveError: selectedSituationFiscale.id_tranche_impot.length < 1}">
				<select :disabled="selectedSituationFiscale.id != 0" v-model="selectedSituationFiscale.id_tranche_impot"  class="form-control">
					<option v-for="(impot, key) in $store.getters.getImpot(selectedSituationFiscale.id_impot)" :value="key">{{impot.basse}} - {{impot.haute}} : {{ impot.taux | pourcent }}</option>
				</select>
			</div>
		</div>

		<div v-if="selectedSituationFiscale.haveImpot == 1">
			<div class="label">
				Nombre de parts fiscales
			</div>
			<div :class="{tablehaveError: selectedSituationFiscale.nbr_parts_fiscales.length < 1}">
				<input step="0.5" class="form-control" type="number" min="1" :disabled="selectedSituationFiscale.id != 0" v-model="selectedSituationFiscale.nbr_parts_fiscales"/>
			</div>
		</div>


		<div class="subtitle">
			<div>
				IMPÔTS SUR LA FORTUNE (ISF)
			</div>
			<div></div>
		</div>

		<div >
			<div class="label">
				Assujetti à l’impôt sur la fortune ?
			</div>
			<div :class="{tablehaveError: selectedSituationFiscale.haveImpotFortune.length < 1}">
				<label class="radio" for="haveImpotFortune-1">
					<input type="radio" id="haveImpotFortune-1" value="1"  :disabled="selectedSituationFiscale.id != 0" v-model="selectedSituationFiscale.haveImpotFortune"/>
					<span></span>
					oui
				</label>
				<label class="radio" for="haveImpotFortune-0">
					<input type="radio" id="haveImpotFortune-0" value="0"  :disabled="selectedSituationFiscale.id != 0" v-model="selectedSituationFiscale.haveImpotFortune"/>
					<span></span>
					non
				</label>
			</div>
		</div>

		<div v-if="selectedSituationFiscale.haveImpotFortune == 1">
			<div class="label">
				Quelle est la tranche d’imposition au titre de l’ISF
			</div>
			<div>
				<select :disabled="selectedSituationFiscale.id != 0" v-model="selectedSituationFiscale.id_tranche_impot_fortune"  class="form-control">
					<option v-for="(impot, key) in $store.getters.getImpotFortune(selectedSituationFiscale.id_impot_fortune)" :value="key" v-if="key != 0">{{impot.basse}} - {{impot.haute}} : {{ impot.taux | pourcent }}</option>
				</select>
			</div>
		</div>

		<br />
		<button @click="$store.commit('NEW_SITUATION_FISCALE', $store.state.situationFiscale.selected);" class="btn-mscpi"  v-if="typeof selectedSituationFiscale.date_situation != 'undefined' && selectedSituationFiscale.id != 0 && typeof $store.state.situationFiscale._new.id_situation == 'undefined'">Créer une nouvelle situation basée sur la situation sélectionnée</button>
		<button @click="$store.dispatch('SAVE_NEW_SITUATION_FISCALE')" class="btn-mscpi btn-orange" :class="{'btn-not-check': !$store.getters.getSituationFiscaleSelectedIsValid, 'btn-not-allowed': !$store.getters.getSituationFiscaleSelectedIsValid}" v-if="$store.state.situationFiscale._new == $store.state.situationFiscale.selected">Enregistrer</button>
	</div>
	<?php
	//<simple-formulaire :datas="$store.state.situationFiscale.selected"></simple-formulaire>
	?>
</div>
