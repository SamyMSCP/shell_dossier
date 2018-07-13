<div v-if="onglet == 1">
	<select v-model="$store.state.situationJuridique.selected"  class="selectBen">
		<option v-if="typeof $store.state.situationJuridique._new.id_situation != 'undefined' && $store.state.situationJuridique._new.id_situation == selectedBeneficiairePps[0].id_situation" :value="$store.state.situationJuridique._new">Nouvelle situation</option>
		<option v-for="situation in $store.getters.getSituationJuridiqueForPp(selectedBeneficiairePps[0])" :value="situation">{{ situation.date_situation | tsDate }}</option>
	</select>
	<br />
	<div class="SimpleFormulaire" v-if="typeof selectedSituationJuridique.date_situation != 'undefined'" :class="{form_disabled: selectedSituationJuridique.id != 0}">
	<?php
	/*
		<div>
			<div class="label">
				id
			</div>
			<div>
				{{ selectedSituationJuridique.id }}
			</div>
		</div>
		*/
		?>


		<div >
			<div class="label">
				Créateur
			</div>
			<div>
				{{ selectedSituationJuridique.creatorShortName }}
			</div>
		</div>

		<div >
			<div class="label">
				Date de la situation :
			</div>
			<div>
				<my-datepicker  id="sit_jur_date" v-model="selectedSituationJuridique.date_situation" disabled></my-datepicker>
			</div>
		</div>

		<div >
			<div class="label">
				Date d'expiration
			</div>
			<div>
				<my-datepicker id="sit_jur_date_fin" v-model="selectedSituationJuridique.date_fin_situation" disabled></my-datepicker>
			</div>
		</div>

		<div >
			<div class="label">
				Régime matrimonial
			</div>
			<div :class="{tablehaveError: selectedSituationJuridique.regime_mat.length <= 0}" >
				<select class="form-control" :disabled="selectedSituationJuridique.id != 0" v-model="selectedSituationJuridique.regime_mat">
					<option value="">-</option>
					<option v-for="(regime, key) in $store.state.situationJuridique.regime_mat" :value="key">{{ regime}}</option>
				</select>
			</div>
		</div>

		<div >
			<div class="label">
				Le bénéficiaire {{ selectedBeneficiaire.shortName }} a des enfants :
			</div>
			<div
				:class="{tablehaveError: selectedSituationJuridique.haveChild.length <= 0}"
			>
				<label class="radio" for="child_1">
					<input type="radio" id="child_1" value="1" v-model="selectedSituationJuridique.haveChild" :disabled="selectedSituationJuridique.id != 0" />
					<span></span>
					oui
				</label>
				<label class="radio" for="child_0">
					<input type="radio" id="child_0" value="0" v-model="selectedSituationJuridique.haveChild" :disabled="selectedSituationJuridique.id != 0" />
					<span></span>
					non
				</label>
			</div>
		</div>

		<div v-show="selectedSituationJuridique.haveChild == 1">
			<div class="label">
				Combien d'enfants à charge :
			</div>
			<div :class="{tablehaveError: selectedSituationJuridique.nbr_enfant_charge.length <= 0}">
				<input class="form-control" type="number" min="0" v-model="selectedSituationJuridique.nbr_enfant_charge" :disabled="selectedSituationJuridique.id != 0"/>
			</div>
		</div>

		<div >
			<div class="label">
				Combien de personnes à charge :
			</div>
			<div :class="{tablehaveError: selectedSituationJuridique.nbr_pers_charge.length <= 0}">
				<input class="form-control" type="number" min="0" v-model="selectedSituationJuridique.nbr_pers_charge" :disabled="selectedSituationJuridique.id != 0"/>
			</div>
		</div>
		<br />
		<button @click="$store.commit('NEW_SITUATION_JURIDIQUE', $store.state.situationJuridique.selected);" class="btn-mscpi"  v-if="typeof selectedSituationJuridique.date_situation != 'undefined' && selectedSituationJuridique.id != 0 && typeof $store.state.situationJuridique._new.id_situation == 'undefined'">Créer une nouvelle situation basée sur la situation sélectionnée</button>
		<button @click="$store.dispatch('SAVE_NEW_SITUATION_JURIDIQUE')" class="btn-mscpi btn-orange" :class="{'btn-not-check': !$store.getters.getSituationJuridiqueSelectedIsValid, 'btn-not-allowed': !$store.getters.getSituationJuridiqueSelectedIsValid}" v-if="$store.state.situationJuridique._new == $store.state.situationJuridique.selected">Enregistrer</button>
	</div>
</div>
