<div v-if="onglet == 2">
	<select v-model="$store.state.situationFinanciere.selected" class="selectBen">
		<option v-if="typeof $store.state.situationFinanciere._new.id_situation != 'undefined' && $store.state.situationFinanciere._new.id_situation == selectedBeneficiairePps[0].id_situation" :value="$store.state.situationFinanciere._new">Nouvelle situation</option>
		<option v-for="situation in $store.getters.getSituationFinanciereForPp(selectedBeneficiairePps[0])" :value="situation">{{ situation.date_situation | tsDate }}</option>
	</select>
	<br />
	<div class="SimpleFormulaire" v-if="typeof selectedSituationFinanciere.date_situation != 'undefined'" :class="{form_disabled: selectedSituationFinanciere.id != 0}">

		<div >
			<div class="label">
				Créateur
			</div>
			<div>
				{{ selectedSituationFinanciere.creatorShortName }}
			</div>
		</div>
		<div >
			<div class="label">
				Date de la situation :
			</div>
			<div>
				<my-datepicker  id="sit_fin_date" v-model="selectedSituationFinanciere.date_situation" disabled></my-datepicker>
			</div>
		</div>

		<div >
			<div class="label">
				Date d'expiration
			</div>
			<div>
				<my-datepicker id="sit_fin_date_fin" v-model="selectedSituationFinanciere.date_fin_situation" disabled></my-datepicker>
			</div>
		</div>

		<div class="subtitle">
			<div>
				REVENUS DE {{ selectedBeneficiaire.shortName | upper }}
			</div>
			<div></div>
		</div>
		<table class="tableInput">
			<thead>
				<tr>
					<th style="width: 350px;">Type de revenus</th>
					<th colspan="2">Montant des revenus</th>
				</tr>
				<tr>
					<th></th>
					<th>par mois</th>
					<th>soit par an</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Revenus (Salaires, retraites, pensions...)</td>
					<td>
						<input :class="{tablehaveError: selectedSituationFinanciere.revenu_professionnels.length <= 0}" v-model.number="selectedSituationFinanciere.revenu_professionnels" :disabled="selectedSituationFinanciere.id != 0" type="number" min="0" placeholder="-"/> €
					</td>
					<td>
						{{ selectedSituationFinanciere.revenu_professionnels * 12  | euros }}
					</td>
				</tr>
				<tr>
					<td>Revenus immobiliers</td>
					<td>
						<input :class="{tablehaveError: selectedSituationFinanciere.revenu_immobiliers.length <= 0}" v-model.number="selectedSituationFinanciere.revenu_immobiliers" :disabled="selectedSituationFinanciere.id != 0"  type="number" min="0" placeholder="-"/> €

					</td>
					<td>
						{{ selectedSituationFinanciere.revenu_immobiliers * 12  | euros }}
					</td>
				</tr>
				<tr>
					<td>Revenus mobiliers</td>
					<td>
						<input :class="{tablehaveError: selectedSituationFinanciere.revenu_mobiliers.length <= 0}" v-model.number="selectedSituationFinanciere.revenu_mobiliers" :disabled="selectedSituationFinanciere.id != 0"  type="number" min="0" placeholder="-"/> €
					</td>
					<td>
						{{ selectedSituationFinanciere.revenu_mobiliers * 12  | euros }}
					</td>
				</tr>
				<tr>
					<td>Autres</td>
					<td>
						<input  :class="{tablehaveError: selectedSituationFinanciere.revenu_autres.length <= 0}" v-model.number="selectedSituationFinanciere.revenu_autres" :disabled="selectedSituationFinanciere.id != 0"  type="number" min="0" placeholder="-"/> €
					</td>
					<td>
						{{ selectedSituationFinanciere.revenu_autres * 12  | euros }}
					</td>
				</tr>
				<tr v-if="selectedSituationFinanciere.revenu_autres > 0">
					<td>Précisez la nature</td>
					<td>
						<input :class="{tablehaveError: selectedSituationFinanciere.nature_revenu_autres.length < 2 && selectedSituationFinanciere.revenu_autres > 0}"
						v-model="selectedSituationFinanciere.nature_revenu_autres" :disabled="selectedSituationFinanciere.id != 0"  pattern=".{3,}" type="text"  placeholder="-"/>
					</td>
					<td>
					</td>
				</tr>
				<tr style="border-top: 1px solid #1781e0;color: #1781e0;">
					<td>Total</td>
					<td>
						{{ (1 * selectedSituationFinanciere.revenu_professionnels + 1 * selectedSituationFinanciere.revenu_immobiliers + 1 * selectedSituationFinanciere.revenu_mobiliers + 1 * selectedSituationFinanciere.revenu_autres ) | euros }}
					</td>
					<td>
						{{ (1 * selectedSituationFinanciere.revenu_professionnels + 1 * selectedSituationFinanciere.revenu_immobiliers + 1 * selectedSituationFinanciere.revenu_mobiliers + 1 * selectedSituationFinanciere.revenu_autres ) * 12  | euros }}
					</td>
				</tr>
			</tbody>
			
		</table>
		<div class="subtitle">
			<div>
				CHARGES  DE {{ selectedBeneficiaire.shortName | upper }}
			</div>
			<div></div>
		</div>
		<div class="radioCol" :class="{tablehaveError: selectedSituationFinanciere.habitation.length <= 0}" >
			<label class="radio" for="habitation-0">
				<input type="radio" v-model="selectedSituationFinanciere.habitation" :disabled="selectedSituationFinanciere.id != 0"  id="habitation-0" value="1">
				<span></span>
				Propriétaire de votre résidence principale
			</label> 
			<label class="radio" for="habitation-1">
				<input type="radio" v-model="selectedSituationFinanciere.habitation" :disabled="selectedSituationFinanciere.id != 0"  id="habitation-1" value="2">
				<span></span>
				Locataire
			</label> 
			<label class="radio" for="habitation-2">
				<input type="radio" v-model="selectedSituationFinanciere.habitation" :disabled="selectedSituationFinanciere.id != 0"  id="habitation-2" value="3">
				<span></span>
				Hébergé à titre gratuit
			</label> 
		</div>
		<table class="tableInput">
			<thead>
				<tr>
					<th style="width: 350px;">Charges</th>
					<th colspan="2">Montant des charges mensuelles</th>
					<th>Durée restante en mois</th>
				</tr>
				<tr>
					<th></th>
					<th>par mois</th>
					<th>soit par an</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr v-if="selectedSituationFinanciere.habitation == 1">
					<td>Crédit résidence principale</td>
					<td>
						<input 
							:class="{tablehaveError: selectedSituationFinanciere.remboursement_mensuel.length <= 0 || (selectedSituationFinanciere.duree_remboursement_restante != 0 && selectedSituationFinanciere.remboursement_mensuel == 0)}" 
							v-model.number="selectedSituationFinanciere.remboursement_mensuel" :disabled="selectedSituationFinanciere.id != 0"  type="number" min="0" placeholder="-"/> €
					</td>
					<td>
						{{ selectedSituationFinanciere.remboursement_mensuel * 12  | euros }}
					</td>
					<td>
						<input 
							:class="{tablehaveError: selectedSituationFinanciere.duree_remboursement_restante.length <= 0 || (selectedSituationFinanciere.duree_remboursement_restante == 0 && selectedSituationFinanciere.remboursement_mensuel != 0)}" 
							v-model.number="selectedSituationFinanciere.duree_remboursement_restante" :disabled="selectedSituationFinanciere.id != 0"  type="number" min="0" placeholder="-"/>
					</td>
				</tr>

				<tr v-if="selectedSituationFinanciere.habitation == 2">
					<td>Loyer résidence principale</td>
					<td>
						<input 
							:class="{tablehaveError: selectedSituationFinanciere.loyer_montant.length <= 0 || (selectedSituationFinanciere.loyer_montant  == 0)}"
							v-model.number="selectedSituationFinanciere.loyer_montant" :disabled="selectedSituationFinanciere.id != 0"  type="number" min="0" placeholder="-"/> €
					</td>
					<td>
						{{ selectedSituationFinanciere.loyer_montant * 12  | euros }}
					</td>
					<td>
					</td>
				</tr>

				<tr>
					<td>Crédit résidence secondaire</td>
					<td>
						<input 
							:class="{tablehaveError: selectedSituationFinanciere.residance_montant.length <= 0 || (selectedSituationFinanciere.residance_duree != 0 && selectedSituationFinanciere.residance_montant == 0)}" 
							v-model.number="selectedSituationFinanciere.residance_montant" :disabled="selectedSituationFinanciere.id != 0"  type="number" min="0" placeholder="-"/> €
					</td>
					<td>
						{{ selectedSituationFinanciere.residance_montant * 12  | euros }}
					</td>
					<td>
						<input 
							:class="{tablehaveError: selectedSituationFinanciere.residance_duree.length <= 0 || (selectedSituationFinanciere.residance_duree == 0 && selectedSituationFinanciere.residance_montant != 0)}" 
							v-model.number="selectedSituationFinanciere.residance_duree" :disabled="selectedSituationFinanciere.id != 0"  type="number" min="0" placeholder="-"/>
					</td>
				</tr>

				<tr>
					<td>crédit immobilier locatif</td>
					<td>
						<input 
							:class="{tablehaveError: selectedSituationFinanciere.locatif_montant.length <= 0 || (selectedSituationFinanciere.locatif_duree != 0 && selectedSituationFinanciere.locatif_montant == 0)}" 
							v-model.number="selectedSituationFinanciere.locatif_montant" :disabled="selectedSituationFinanciere.id != 0"  type="number" min="0" placeholder="-"/> €
					</td>
					<td>
						{{ selectedSituationFinanciere.locatif_montant * 12  | euros }}
					</td>
					<td>
						<input 
							:class="{tablehaveError: selectedSituationFinanciere.locatif_duree.length <= 0 || (selectedSituationFinanciere.locatif_duree == 0 && selectedSituationFinanciere.locatif_montant != 0)}" 
							v-model.number="selectedSituationFinanciere.locatif_duree" :disabled="selectedSituationFinanciere.id != 0"  type="number" min="0" placeholder="-"/>
					</td>
				</tr>

				<tr>
					<td>Crédit SCPI</td>
					<td>
						<input 
							:class="{tablehaveError: selectedSituationFinanciere.scpi_montant.length <= 0 || (selectedSituationFinanciere.scpi_duree != 0 && selectedSituationFinanciere.scpi_montant == 0)}" 
							v-model.number="selectedSituationFinanciere.scpi_montant" :disabled="selectedSituationFinanciere.id != 0"  type="number" min="0" placeholder="-"/> €
					</td>
					<td>
						{{ selectedSituationFinanciere.scpi_montant * 12  | euros }}
					</td>
					<td>
						<input 
							:class="{tablehaveError: selectedSituationFinanciere.scpi_duree.length <= 0 || (selectedSituationFinanciere.scpi_duree == 0 && selectedSituationFinanciere.scpi_montant != 0)}" 
							v-model.number="selectedSituationFinanciere.scpi_duree" :disabled="selectedSituationFinanciere.id != 0"  type="number" min="0" placeholder="-"/>
					</td>
				</tr>

				<tr>
					<td>Crédit à la consommation</td>
					<td>
						<input 
							:class="{tablehaveError: selectedSituationFinanciere.consommation_montant.length <= 0 || (selectedSituationFinanciere.consommation_duree != 0 && selectedSituationFinanciere.consommation_montant == 0)}" 
							v-model.number="selectedSituationFinanciere.consommation_montant" :disabled="selectedSituationFinanciere.id != 0"  type="number" min="0" placeholder="-"/> €
					</td>
					<td>
						{{ selectedSituationFinanciere.consommation_montant* 12  | euros }}
					</td>
					<td>
						<input 
							:class="{tablehaveError: selectedSituationFinanciere.consommation_duree.length <= 0 || (selectedSituationFinanciere.consommation_duree == 0 && selectedSituationFinanciere.consommation_montant != 0)}" 
							v-model.number="selectedSituationFinanciere.consommation_duree" :disabled="selectedSituationFinanciere.id != 0"  type="number" min="0" placeholder="-"/>
					</td>
				</tr>

				<tr>
					<td>Autres credits</td>
					<td>
						<input 
							:class="{tablehaveError: selectedSituationFinanciere.autres_remboursement_montant.length <= 0 || (selectedSituationFinanciere.autres_remboursement_duree != 0 && selectedSituationFinanciere.autres_remboursement_montant == 0)}" 
							v-model.number="selectedSituationFinanciere.autres_remboursement_montant" :disabled="selectedSituationFinanciere.id != 0"  type="number" min="0" placeholder="-"/> €
					</td>
					<td>
						{{ selectedSituationFinanciere.autres_remboursement_montant * 12  | euros }}
					</td>
					<td>
						<input 
							:class="{tablehaveError: selectedSituationFinanciere.autres_remboursement_duree.length <= 0 || (selectedSituationFinanciere.autres_remboursement_duree == 0 && selectedSituationFinanciere.autres_remboursement_montant != 0)}" 
							v-model.number="selectedSituationFinanciere.autres_remboursement_duree" :disabled="selectedSituationFinanciere.id != 0"  type="number" min="0" placeholder="-"/>
					</td>
				</tr>

				<tr>
					<td>Autres charges</td>
					<td>
						<input :class="{tablehaveError: selectedSituationFinanciere.autres_charges.length <= 0}" v-model.number="selectedSituationFinanciere.autres_charges" :disabled="selectedSituationFinanciere.id != 0"  type="number" min="0" placeholder="-"/> €
					</td>
					<td>
						{{ selectedSituationFinanciere.autres_charges * 12  | euros }}
					</td>
					<td>
					</td>
				</tr>

				<tr style="border-top: 1px solid #1781e0;color: #1781e0;">
					<td >Total</td>
					<td>
						{{ (1 * ((selectedSituationFinanciere.habitation == 1) ? selectedSituationFinanciere.remboursement_mensuel : 0) +
						 1 * ((selectedSituationFinanciere.habitation == 2) ? selectedSituationFinanciere.loyer_montant : 0) +
						 1 * selectedSituationFinanciere.residance_montant +
						 1 * selectedSituationFinanciere.locatif_montant +
						 1 * selectedSituationFinanciere.scpi_montant +
						 1 * selectedSituationFinanciere.consommation_montant +
						 1 * selectedSituationFinanciere.autres_remboursement_montant +
						 1 * selectedSituationFinanciere.autres_charges)  | euros }}
					</td>
					<td>
						{{ (12 * selectedSituationFinanciere.remboursement_mensuel +
						 12 * selectedSituationFinanciere.loyer_montant +
						 12 * selectedSituationFinanciere.residance_montant +
						 12 * selectedSituationFinanciere.locatif_montant +
						 12 * selectedSituationFinanciere.scpi_montant +
						 12 * selectedSituationFinanciere.consommation_montant +
						 12 * selectedSituationFinanciere.autres_remboursement_montant +
						 12 * selectedSituationFinanciere.autres_charges)  | euros }}
					</td>
					<td></td>
				</tr>

			</tbody>
		</table>
		<br />
		<button @click="$store.commit('NEW_SITUATION_FINANCIERE', $store.state.situationFinanciere.selected);" class="btn-mscpi"  v-if="typeof selectedSituationFinanciere.date_situation != 'undefined' && selectedSituationFinanciere.id != 0 && typeof $store.state.situationFinanciere._new.id_situation == 'undefined'">Créer une nouvelle situation basée sur la situation sélectionnée</button>
		<button @click="$store.dispatch('SAVE_NEW_SITUATION_FINANCIERE')" class="btn-mscpi btn-orange" :class="{'btn-not-check': !$store.getters.getSituationFinanciereSelectedIsValid, 'btn-not-allowed': !$store.getters.getSituationFinanciereSelectedIsValid}" v-if="$store.state.situationFinanciere._new == $store.state.situationFinanciere.selected">Enregistrer</button>
	</div>
	<?php
	//<simple-formulaire :datas="$store.state.situationFinanciere.selected"></simple-formulaire>
	?>
</div>
