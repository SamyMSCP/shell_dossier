<div v-if="onglet == 4">
	<select v-model="$store.state.situationPatrimoniale.selected"  class="selectBen">
		<option v-if="typeof $store.state.situationPatrimoniale._new.id_situation != 'undefined' && $store.state.situationPatrimoniale._new.id_situation == selectedBeneficiairePps[0].id_situation" :value="$store.state.situationPatrimoniale._new">Nouvelle situation</option>
		<option v-for="situation in $store.getters.getSituationPatrimonialeForPp(selectedBeneficiairePps[0])" :value="situation">{{ situation.date_situation | tsDate }}</option>
	</select>

	<div class="SimpleFormulaire" v-if="typeof selectedSituationPatrimoniale.date_situation != 'undefined'" :class="{form_disabled: selectedSituationPatrimoniale.id != 0}">

		<div >
			<div class="label">
				Créateur
			</div>
			<div>
				{{ selectedSituationPatrimoniale.creatorShortName }}
			</div>
		</div>

		<div >
			<div class="label">
				Date de la situation :
			</div>
			<div>
				<my-datepicker  id="sit_pat_date" v-model="selectedSituationPatrimoniale.date_situation" disabled></my-datepicker>
			</div>
		</div>

		<div >
			<div class="label">
				Date d'expiration
			</div>
			<div>
				<my-datepicker id="sit_pat_date_fin" v-model="selectedSituationPatrimoniale.date_fin_situation" disabled></my-datepicker>
			</div>
		</div>

		<div class="subtitle">
			<div>
				SITUATION PATRIMONIALE DE {{ selectedBeneficiaire.shortName | upper }}
			</div>
			<div></div>
		</div>

		<div>
			Une estimation de la valeur du patrimoine global.
		</div>

		<div :class="{tablehaveError: selectedSituationPatrimoniale.fourchette_montant_patrimoine.length < 1}" style="flex-direction: column;width: 300px;margin-left: auto;margin-right: auto;">
			<div >
				<div class="label">
					moins de 50 000 €
				</div>
				<div>
					<label class="radio" for="fourchette_montant_patrimoine-1">
						<input v-model="selectedSituationPatrimoniale.fourchette_montant_patrimoine" type="radio" id="fourchette_montant_patrimoine-1" value="1"  :disabled="selectedSituationPatrimoniale.id != 0" />
						<span></span>
					</label>
				</div>
			</div>

			<div >
				<div class="label">
					entre 50 000 € et 100 000 €
				</div>
				<div>
					<label class="radio" for="fourchette_montant_patrimoine-2">
						<input v-model="selectedSituationPatrimoniale.fourchette_montant_patrimoine" type="radio" id="fourchette_montant_patrimoine-2" value="2"  :disabled="selectedSituationPatrimoniale.id != 0" />
						<span></span>
					</label>
				</div>
			</div>

			<div >
				<div class="label">
					entre 100 000 € et 500 000 €
				</div>
				<div>
					<label class="radio" for="fourchette_montant_patrimoine-3">
						<input v-model="selectedSituationPatrimoniale.fourchette_montant_patrimoine" type="radio" id="fourchette_montant_patrimoine-3" value="3"  :disabled="selectedSituationPatrimoniale.id != 0" />
						<span></span>
					</label>
				</div>
			</div>

			<div >
				<div class="label">
					entre 500 000 € et 1 300 000 €
				</div>
				<div>
					<label class="radio" for="fourchette_montant_patrimoine-4">
						<input v-model="selectedSituationPatrimoniale.fourchette_montant_patrimoine" type="radio" id="fourchette_montant_patrimoine-4" value="4"  :disabled="selectedSituationPatrimoniale.id != 0" />
						<span></span>
					</label>
				</div>
			</div>

			<div >
				<div class="label">
					plus de 1 300 000 €
				</div>
				<div>
					<label class="radio" for="fourchette_montant_patrimoine-5">
						<input v-model="selectedSituationPatrimoniale.fourchette_montant_patrimoine" type="radio" id="fourchette_montant_patrimoine-5" value="5"  :disabled="selectedSituationPatrimoniale.id != 0" />
						<span></span>
					</label>
				</div>
			</div>
		</div>

		<div class="subtitle">
			<div>
				RÉPARTITION DU PATRIMOINE DE {{ selectedBeneficiaire.shortName | upper }}
			</div>
			<div></div>
		</div>
		<table class="tableInput">
			<thead>
				<tr>
					<th>Type de patrimoine</th>
					<th>Répartition en €</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Résidence principale</td>
					<td>
						<input :class="{tablehaveError: selectedSituationPatrimoniale.repartition_residence_principale.length <= 0}" v-model.number="selectedSituationPatrimoniale.repartition_residence_principale" :disabled="selectedSituationPatrimoniale.id != 0" type="number" min="0" placeholder="-"/> €
					</td>
				</tr>
				<tr>
					<td>Assurance-vie</td>
					<td>
						<input :class="{tablehaveError: selectedSituationPatrimoniale.repartition_assurance_vie.length <= 0}" v-model.number="selectedSituationPatrimoniale.repartition_assurance_vie" :disabled="selectedSituationPatrimoniale.id != 0" type="number" min="0" placeholder="-"/> €
					</td>
				</tr>
				<tr>
					<td>PEA / Compte titre</td>
					<td>
						<input :class="{tablehaveError: selectedSituationPatrimoniale.repartition_PEA.length <= 0}" v-model.number="selectedSituationPatrimoniale.repartition_PEA" :disabled="selectedSituationPatrimoniale.id != 0" type="number" min="0" placeholder="-"/> €
					</td>
				</tr>
				<tr>
					<td>PEL / CEL / CODEVI / Livret</td>
					<td>
						<input :class="{tablehaveError: selectedSituationPatrimoniale.repartition_PEL.length <= 0}" v-model.number="selectedSituationPatrimoniale.repartition_PEL" :disabled="selectedSituationPatrimoniale.id != 0" type="number" min="0" placeholder="-"/> €
					</td>
				</tr>
				<tr>
					<td>Résidence secondaire</td>
					<td>
						<input :class="{tablehaveError: selectedSituationPatrimoniale.repartition_residence_secondaire.length <= 0}" v-model.number="selectedSituationPatrimoniale.repartition_residence_secondaire" :disabled="selectedSituationPatrimoniale.id != 0" type="number" min="0" placeholder="-"/> €
					</td>
				</tr>
				<tr>
					<td>Immobilier locatif</td>
					<td>
						<input :class="{tablehaveError: selectedSituationPatrimoniale.repartition_immobilier_locatif.length <= 0}" v-model.number="selectedSituationPatrimoniale.repartition_immobilier_locatif" :disabled="selectedSituationPatrimoniale.id != 0" type="number" min="0" placeholder="-"/> €
					</td>
				</tr>
				<tr>
					<td>SCPI</td>
					<td>
						<input :class="{tablehaveError: selectedSituationPatrimoniale.repartition_scpi.length <= 0}" v-model.number="selectedSituationPatrimoniale.repartition_scpi" :disabled="selectedSituationPatrimoniale.id != 0" type="number" min="0" placeholder="-"/> €
					</td>
				</tr>
				<tr>
					<td>Autres</td>
					<td>
						<input :class="{tablehaveError: selectedSituationPatrimoniale.repartition_autres.length <= 0}" v-model.number="selectedSituationPatrimoniale.repartition_autres" :disabled="selectedSituationPatrimoniale.id != 0" type="number" min="0" placeholder="-"/> €
					</td>
				</tr>
				<tr>
					
				</tr>
			</tbody>
		</table>

		<div class="subtitle">
			<div>
				QUELLE SERA LA PART DE CE FUTUR PLACEMENT ?
			</div>
			<div></div>
		</div>

		<div >
			<div class="label">
			</div>
			<div :class="{tablehaveError: selectedSituationPatrimoniale.fourchette_montant_patrimoine.length < 1}">
				<label class="radio" for="futur_placement-1">
					<input v-model="selectedSituationPatrimoniale.futur_placement" type="radio" id="futur_placement-1" value="1"  :disabled="selectedSituationPatrimoniale.id != 0" /> <span></span>
					Faible (inférieure à 10 %)
				</label>
				<label class="radio" for="futur_placement-2">
					<input v-model="selectedSituationPatrimoniale.futur_placement" type="radio" id="futur_placement-2" value="2"  :disabled="selectedSituationPatrimoniale.id != 0" />
					<span></span>
					Moyenne (10 à 30 %)
				</label>
				<label class="radio" for="futur_placement-3">
					<input v-model="selectedSituationPatrimoniale.futur_placement" type="radio" id="futur_placement-3" value="3"  :disabled="selectedSituationPatrimoniale.id != 0" />
					<span></span>
					Importante (supérieure à 30 %)
				</label>
			</div>
		</div>

		<br />
		<button @click="$store.commit('NEW_SITUATION_PATRIMONIALE', $store.state.situationPatrimoniale.selected);" class="btn-mscpi"  v-if="typeof selectedSituationPatrimoniale.date_situation != 'undefined' && selectedSituationPatrimoniale.id != 0 && typeof $store.state.situationPatrimoniale._new.id_situation == 'undefined'">Créer une nouvelle situation basée sur la situation sélectionnée</button>
		<button @click="$store.dispatch('SAVE_NEW_SITUATION_PATRIMONIALE')" class="btn-mscpi btn-orange" :class="{'btn-not-check': !$store.getters.getSituationPatrimonialeSelectedIsValid, 'btn-not-allowed': !$store.getters.getSituationPatrimonialeSelectedIsValid}" v-if="$store.state.situationPatrimoniale._new == $store.state.situationPatrimoniale.selected">Enregistrer</button>
	</div>

	<?php
	/*
	<simple-formulaire :datas="$store.state.situationPatrimoniale.selected"></simple-formulaire>

	fourchette_montant_patrimoine
	repartition_residence_secondaire
	repartition_immobilier_locatif
	repartition_scpi
	repartition_autres
	futur_placement
	repartition_residence_principale
	repartition_assurance_vie
	repartition_PEA
	repartition_PEL
	*/
	?>

</div>

