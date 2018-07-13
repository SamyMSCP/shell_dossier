<div class="modalViewProjectBlockInfos">
	<div class="modalViewProjectBlockOngletInner">
		<div class="modalViewProjectBlockOngletInner2">
			<div>
				<table class="tableSimulation tableProposition">
					<thead>
						<tr>
							<th>Nom</th>
							<th style="min-width: 150px;">Société de gestion</th>
							<th>Type de propriété</th>
							<th>Nombre de parts</th>
							<th style="min-width: 170px;">Prix par parts en pleine propriété</th>
							<th style="min-width: 190px;">Clé de repartition si démembrement</th>
							<th>Durée de démembrement</th>
							<th>Montant d'investissement</th>
							<th style="min-width: 230px;">% part sur le montant d'investissement</th>
						</tr>
					</thead>
					<tbody>
						<template v-for="trans in $store.state.transactions.selectedProjectTransactions">
							<tr :class="{isModify: trans.isModify}">
								<td>
									<select v-model="trans.id_scpi" @change="setModifyChangeScpi(trans)" @keyup.enter="$store.dispatch('TRANSACTIONS_UPDATE', trans)">
										<option v-for="scpi in $store.getters.getAllScpiSorted" :value="scpi.id">
											{{ scpi.name.replace("SCPI ", "") }}
											({{ (scpi.TypeCapital == 'fixe') ? 'CF' : 'CV' }})
										</option>
									</select>
								</td>
								<td>{{ $store.getters.getScpi(trans.id_scpi).societeDeGestionName }} </td>
								<td>
									<select v-model="trans.type_pro" @change="setModify(trans)" @keyup.enter="$store.dispatch('TRANSACTIONS_UPDATE', trans)">
										<option value="Pleine propriété">PP</option>
										<option value="Nue propriété">NP</option>
										<option value="Usufruit">US</option>
									</select>
								</td>
								<td>
									<input min="1" type="number" v-model="trans.nbr_part" @keyup="setModify(trans)" @change="setModify(trans)" @keyup.enter="$store.dispatch('TRANSACTIONS_UPDATE', trans)"/>
						
								</td>
								<td>
									<input min="1" type="number" v-model="trans.prix_part" step="any" @keyup="setModify(trans)" @change="setModify(trans)" @keyup.enter="$store.dispatch('TRANSACTIONS_UPDATE', trans)"/>
								</td>
								<td>
									<input type="number" min="1" max="99" v-model="trans.cle_repartition" @keyup="setModify(trans)" v-if="trans.type_pro != 'Pleine propriété'" @change="setModify(trans)" @keyup.enter="$store.dispatch('TRANSACTIONS_UPDATE', trans)"/>
									<span v-else>-</span>
								</td>
								<td>
									<input type="number" min="0" max="20" v-model="trans.dt" @keyup="setModify(trans)" v-if="trans.type_pro != 'Pleine propriété'" @change="setModify(trans)" @keyup.enter="$store.dispatch('TRANSACTIONS_UPDATE', trans)"/>
									<span v-else>-</span>
								</td>
								<td>
									{{ getTransactionInvestissement(trans) | euros }}
								</td>
								<td style="color: #1781e0;">
									{{ getTransactionPourcentage(trans) | pourcent }}
									<div class="outRight">
										<div class="outContent" v-if="trans.isModify" @click="$store.dispatch('TRANSACTIONS_UPDATE', trans)">
											<i class="fa fa-floppy-o" aria-hidden="true"></i>
										</div>
										<div class="outContent outContent-orange" @click="setDelete(trans)">
											<i class="fa fa-times" aria-hidden="true"></i>
										</div>
									</div>
								</td>
							</tr>
							<tr class="tablePropositionComm"  :class="{isModify: trans.isModify}">
								<td colspan="9">
									<input type="text" v-model="trans.commentaire_projet"  @keyup="setModify(trans)"  @change="setModify(trans)" @keyup.enter.stop="$store.dispatch('TRANSACTIONS_UPDATE', trans)"/>
								</td>
							</tr>
						</template>
						<tr>
							<td colspan="9" style="border: none;">
								<img src="<?=$this->getPath()?>img/Plus-bleuclair-01.png" alt="" style="height:32px;cursor:pointer;" @click="createTransaction()"/>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="modalViewProjectBlockInfos">

	<div class="modalViewProjectBlockOngletInner" style="display: flex;flex-direction: column;">
		<div class="modalViewProjectBlockOngletInner2 Inner2Title">
			<img src="<?=$this->getPath()?>img/DiagCircu-Blanc.svg" alt="" />
			<span>RÉPARTITION PAR SCPI</span>
			<img class="_tooltip_r" src="<?=$this->getPath()?>img/i-Blanc.svg" onmouseover="display_tooltip('Tooltip repartition', 'Tooltip Repartition Content', event)" onmouseout="disable_msg(event)" style="height: 26px;">
		</div>
		<div class="modalViewProjectBlockOngletInner2 Inner2Content">
			<chart-repartition-scpi :value="$store.state.transactions.selectedProjectTransactions" name="chartRepartitionScpiProject"></chart-repartition-scpi>
		</div>
	</div>
	
	<div class="modalViewProjectBlockOngletInner" style="display: flex;flex-direction: column;">
		<div class="modalViewProjectBlockOngletInner2 Inner2Title">
			<img src="<?=$this->getPath()?>img/DiagCircu-Blanc.svg" alt="" />
			<span>RÉPARTITION GÉOGRAPHIQUE</span>
			<img class="_tooltip_r" src="<?=$this->getPath()?>img/i-Blanc.svg" onmouseover="display_tooltip('Tooltip repartition geo', 'Tooltip Repartition Geo Content', event)" onmouseout="disable_msg(event)" style="height: 26px;">
		</div>
		<div class="modalViewProjectBlockOngletInner2 Inner2Content">
			<chart-repartition-geo :value="$store.state.transactions.selectedProjectTransactions" name="chartRepartitionGeoProject"></chart-repartition-geo>
		</div>
	</div>

	<div class="modalViewProjectBlockOngletInner" style="display: flex;flex-direction: column;">
		<div class="modalViewProjectBlockOngletInner2 Inner2Title">
			<img src="<?=$this->getPath()?>img/DiagCircu-Blanc.svg" alt="" />
			<span>RÉPARTITION PAR TYPE</span>
			<img class="_tooltip_r" src="<?=$this->getPath()?>img/i-Blanc.svg" onmouseover="display_tooltip('Tooltip repartition par type', 'Tooltip Repartition par type', event)" onmouseout="disable_msg(event)" style="height: 26px;">
		</div>
		<div class="modalViewProjectBlockOngletInner2 Inner2Content" style="display:flex;align-items:center;">
			<repartition-type :value="$store.state.transactions.selectedProjectTransactions" ></repartition-type>
		</div>
	</div>
</div>
