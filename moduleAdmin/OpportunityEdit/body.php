<div class="module op-list">
	<div class="moduleContent container-fluid">
		<table class="table table-responsive table-bordered table-striped" style="width: 100%;">
			<thead>
				<tr>
					<th>id
						<i v-show="$store.state.opportunite.idFilter == 1" class="fa fa-caret-down btn btn-sm" @click="$store.commit('OPPORTUNITY_SORT_BY_ID', {type: 0})"></i>
						<i v-show="$store.state.opportunite.idFilter == 0" class="fa fa-caret-up btn btn-sm" @click="$store.commit('OPPORTUNITY_SORT_BY_ID', {type: 1})"></i>
					</th>
					<th>SCPI
						<i v-show="$store.state.opportunite.scpiFilter == 1" class="fa fa-caret-down btn btn-sm" @click="$store.commit('OPPORTUNITY_SORT_BY_SCPI', {type: 0})"></i>
						<i v-show="$store.state.opportunite.scpiFilter == 0" class="fa fa-caret-up btn btn-sm" @click="$store.commit('OPPORTUNITY_SORT_BY_SCPI', {type: 1})"></i>
					</th>
					<th>nb clics</th>
					<th>Type de demande</th>
					<th>Type de d'Opportunit&eacute;</th>
					<th>Nb_Parts
						<i v-show="$store.state.opportunite.partFilter == 1" class="fa fa-caret-down btn btn-sm" @click="$store.commit('OPPORTUNITY_SORT_BY_NBPART', {type: 0})"></i>
						<i v-show="$store.state.opportunite.partFilter == 0" class="fa fa-caret-up btn btn-sm" @click="$store.commit('OPPORTUNITY_SORT_BY_NBPART', {type: 1})"></i>
					</th>
					<th>Auteur</th>
					<th>Dur&eacute;e du d&eacute;membrement en ann&eacute;es
						<i v-show="$store.state.opportunite.demFilter == 1" class="fa fa-caret-down btn btn-sm" @click="$store.commit('OPPORTUNITY_SORT_BY_DEM', {type: 0})"></i>
						<i v-show="$store.state.opportunite.demFilter == 0" class="fa fa-caret-up btn btn-sm" @click="$store.commit('OPPORTUNITY_SORT_BY_DEM', {type: 1})"></i>
					</th>
					<th>Cl&eacute; de r&eacute;partition Nue Propriet&eacute;</th>
					<th>Cl&eacute; de r&eacute;partition Usufruit</th>
					<th>Souscription Partielle</th>
					<th>Volume D'investissement Nue Propriet&eacute;
						<i v-show="$store.state.opportunite.volNuFilter == 1" class="fa fa-caret-down btn btn-sm" @click="$store.commit('OPPORTUNITY_SORT_BY_VOLNU', {type: 0})"></i>
						<i v-show="$store.state.opportunite.volNuFilter == 0" class="fa fa-caret-up btn btn-sm" @click="$store.commit('OPPORTUNITY_SORT_BY_VOLNU', {type: 1})"></i>
					</th>
					<th>Volume D'investissement Usufruit
						<i v-show="$store.state.opportunite.volUsuFilter == 1" class="fa fa-caret-down btn btn-sm" @click="$store.commit('OPPORTUNITY_SORT_BY_VOLUSU', {type: 0})"></i>
						<i v-show="$store.state.opportunite.volUsuFilter == 0" class="fa fa-caret-up btn btn-sm" @click="$store.commit('OPPORTUNITY_SORT_BY_VOLUSU', {type: 1})"></i>
					</th>
					<th>
						<span class="dropdown">
							<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
								&Eacute;tat
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu">
								<li v-bind:class="($store.state.opportunite.ouvertFilter) ? 'active' : ''"><a @click="$store.commit('OPPORTUNITY_SORT_BY_STATE', {type: 1})" href="#">Ouverte</a></li>
								<li v-bind:class="($store.state.opportunite.saisirFilter) ? 'active' : ''"><a @click="$store.commit('OPPORTUNITY_SORT_BY_STATE', {type: 2})" href="#">A saisir</a></li>
								<li v-bind:class="($store.state.opportunite.closeOkFilter) ? 'active' : ''"><a @click="$store.commit('OPPORTUNITY_SORT_BY_STATE', {type: 3})" href="#">Fermer (Reussi)</a></li>
								<li v-bind:class="($store.state.opportunite.closeNotOkFilter) ? 'active' : ''"><a @click="$store.commit('OPPORTUNITY_SORT_BY_STATE', {type: 4})" href="#">Fermer (Abandon)</a></li>
							</ul>
						</span>
					</th>
					<th>Notif</th>
					<th>Valid&eacute;e
						<i v-show="$store.state.opportunite.validatedFilter == 1" class="fa fa-caret-down btn btn-sm" @click="$store.commit('OPPORTUNITY_SORT_BY_VALIDE', {type: 0})"></i>
						<i v-show="$store.state.opportunite.validatedFilter == 0" class="fa fa-caret-up btn btn-sm" @click="$store.commit('OPPORTUNITY_SORT_BY_VALIDE', {type: 1})"></i>
					</th>
					<th>Editer</th>
					<th>Consulter</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="(line, index) in $store.getters.getListWithStateFilter">
					<td>{{line.id}}</td>
					<td>{{$store.getters.getScpi(line.id_scpi).name}}</td>
					<td>{{line.inter}}</td>
					<td>{{(line.type == 0) ? "Nue Propriété" : "Usufruit"}}</td>
					<td>{{(line.type == 1) ? "Nue Propriété" : "Usufruit"}}</td>
					<td>{{line.nb_part}}</td>
					<td><a v-bind:href="'?p=EditionClient&client=' + line.id_author" target="_blank">{{line.author}}</a></td>
					<td>{{line.time_demembrement}} Ans</td>
					<td>{{parseFloat(line.key_nue).toLocaleString("fr", {style: "decimal", minimumFractionDigits: "2"})}} %</td>
					<td>{{parseFloat(100.0 - line.key_nue).toLocaleString("fr", {style: "decimal", minimumFractionDigits: "2"})}} %</td>
					<td>
						<span v-if="line.partial_subscrib == 1"><i class="fa fa-check text-success fa-2x"></i></span>
						<span v-if="line.partial_subscrib == 0"><i class="fa fa-times text-danger fa-2x"></i></span>
					</td>
					<td>{{(line.nb_part * line.price_per_part * (line.key_nue / 100.0)).toLocaleString("fr", {style: "currency", currency: "EUR"})}}</td>
					<td>{{(line.nb_part * line.price_per_part * ((100.0 - line.key_nue) / 100.0)).toLocaleString("fr", {style: "currency", currency: "EUR"})}}</td>
					<td>
						<span v-if="line.state == 0" class="text-sucess">Ouverte</span>
						<span v-if="line.state == 1" class="text-primary">Opportunit&eacute;e &agrave; saisir</span>
						<span v-if="line.state == 2" class="text-muted">Ferm&eacute;e (Reussi)</span>
						<span v-if="line.state == 3" class="text-danger">Ferm&eacute;e (Abandon)</span>
					</td>
					<td>
						<span v-if="line.notif_client == 1" class="text-success"><i class="fa fa-check fa-2x"></i></span>
						<span v-if="line.notif_client == 0" class="text-danger"><i class="fa fa-times fa-2x"></i></span>
					</td>
					<td>
						<span v-if="line.validated == 1" class="text-success"><i class="fa fa-check fa-2x"></i></span>
						<span v-if="line.validated == 0" class="text-danger"><i class="fa fa-times fa-2x"></i></span>
					</td>
					<td>
						<a class="btn btn-primary" data-toggle="modal" data-target="#editor" @click="setSelectedOpportunite(line);">
							<i class="fa fa-cog"></i>
						</a>
					</td>
					<td>
						<a class="btn btn-primary" v-bind:href="'?p=ConsultOpportunity&op=' + line.id" target="_blank">
							<i class="fa fa-search"></i>
						</a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
