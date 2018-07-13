<div class="opportuniteClientList">
	<div style="text-align:center;">
		<div class="BtnOpportunite">
			<button @click="setNewOpportunite()">AJOUTER UNE OPPORTUNITÉ</button>
		</div>
	</div>
	<div class="btnFilterCrm">
		<button class="btn-mscpi" :class="{'btn-not-check': $store.state.opportunite.stateFilter != 0}" @click="$store.commit('SET_OPPORTUNITE_STATE', 0)">Ouvert</button>
		<button class="btn-mscpi" :class="{'btn-not-check': $store.state.opportunite.stateFilter != 1}"  @click="$store.commit('SET_OPPORTUNITE_STATE', 1)">Fermé</button>
	</div>
	<table border="0">
		<thead>
			<tr>
				<th>Validé</th>
				<th>SCPI</th>
				<th>Type de propriété</th>
				<th>Durée du démembrement</th>
				<th>Clé de répartition Nue propriété</th>
				<th>Clé de répartition Usufruit</th>
				<th>Etat</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="op in $store.getters.getFilteredOpportunite" @click="setSelectedOpportunite(op);">
				<td>
					<i class="success fa fa-check fa-2x" v-if="op.validated == 1"></i>
					<i class="danger fa fa-times fa-2x" v-else-if="op.validated == 0"></i>
				</td>
				<td>{{$store.getters.getScpi(op.id_scpi).name}}</td>
				<td>{{ op.type == 1 ? "Usufruit" : "Nue propriété" }}</td>
				<td>{{ op.time_demembrement | years }}</td>
				<td>{{ op.key_nue | pourcent }}</td>
				<td>{{ (100 - op.key_nue) | pourcent }}</td>
				<td>
					<span v-if="op.state == 0">Ouverte</span>
					<span v-else-if="op.state == 1">À saisir</span>
					<span v-else-if="op.state == 2">Fermé (réussi)</span>
					<span v-else-if="op.state == 3">Fermé (abandon)</span>
				</td>
			</tr>
		</tbody>
	</table>
</div>
