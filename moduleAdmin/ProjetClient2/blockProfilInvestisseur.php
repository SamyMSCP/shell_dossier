<div v-if="onglet == 2">
	<table class="tableSimulation">
		<thead>
			<tr>
				<th>Date de création</th>
				<th>Nom du bénéficiaire</th>
				<th>Type de profil</th>
				<th>Résultats</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="pp in $store.getters.getPersonnePhysiqueForSelectedProjet" v-if="typeof pp.profilInvestisseur != 'undefined'" >
				<td>{{ pp.profilInvestisseur.date_creation | tsDateStr }}</td>
				<td>
					{{ (pp.civilite == "Monsieur") ? "M." : "Mme"}} {{ pp.prenom}} {{ pp.nom }}
				</td>
				<td>{{ pp.profilInvestisseur.details.niveau | uc_first }}</td>
				<td @click.stop="$store.commit('SHOW_PROFIL', pp)" class="toSeeProfil">Voir les réponses du profil investisseur</td>
				<td>METTRE À JOUR SON PROFIL</td>
			</tr>
		</tbody>
	</table>
</div>
