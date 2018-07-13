<?= $this->Nav ?>
<?//= $this->Validate ?>
<?= $this->TransactionsStore ?>
<?= $this->ConseillerStore ?>
<?//= $this->TransactionsComponent ?>
<!--<transaction></transaction>-->
<div class="containerPerso">
	<div class="vueApp">
		<div class="row">
			<div class="col-lg-2">
				<div class="input-group">
					<span class="input-group-addon">Soci&eacute;t&eacute; de Gestion</span>
					<select class="form-control" v-model="socgest_tmp">
						<option value="">Tout</option>
						<option v-for="value in $store.state.societeGestion.lst" :value="value.name">{{value.name}}
						</option>
					</select>
				</div>
			</div>
			<div class="col-lg-2">
				<div class="input-group">
					<span class="input-group-addon">Nom</span>
					<input class="form-control" v-model="namesearch_tmp" placeholder="Nom - Prenom"/>
				</div>
			</div>
			<div class="col-lg-2">
				<div class="well well-sm" v-if="!select_tmp.edit" @click="select_tmp.edit = true">
					<span v-if="select_tmp.data.indexOf('enr') != -1 || (select_tmp.data.indexOf('enr') == -1 && select_tmp.data.indexOf('mod') == -1)">Date d'enregistrement</span>
					<span v-if="(select_tmp.data.indexOf('enr') != -1 && select_tmp.data.indexOf('mod') != -1) || (select_tmp.data.indexOf('enr') == -1 && select_tmp.data.indexOf('mod') == -1)">, </span>
					<span v-if="select_tmp.data.indexOf('mod') != -1 || (select_tmp.data.indexOf('enr') == -1 && select_tmp.data.indexOf('mod') == -1)">Date de modification</span>
				</div>
				<div class="container-fluid">
					<div class="row">
						<div v-if="select_tmp.edit" class="col-lg-10">
							<select v-model:value="select_tmp.data" class="form-control" multiple="multiple">
								<option value="enr">Date d'enregistrement</option>
								<option value="mod">Date de modification</option>
							</select>
						</div>
						<div class="col-lg-2" v-if="select_tmp.edit">
							<div class="btn btn-success" @click="select_tmp.edit = false">
								<i class="fa fa-check"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-2">
				<div class="input-group">
					<span class="input-group-addon">Filtre MSCPI</span>
					<select class="form-control" v-model.number="mscpi">
						<option value="0">Tout</option>
						<option value="1">MeilleureSCPI</option>
						<option value="2">Non MeilleureSCPI</option>
					</select>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="input-group">
					<input class="form-control" type="text" v-model="date_tmp.start" id="datepicker-start"
						   placeholder="dd/mm/yyyy"/>
					<span class="input-group-addon">&agrave;</span>
					<input class="form-control" type="text" v-model="date_tmp.end" id="datepicker-stop"
						   placeholder="dd/mm/yyyy"/>
				</div>
			</div>
			<div class="col-lg-1">
				<div class="btn btn-success btn-block" @click="applyFilters()">
					Appliquer
				</div>
			</div>
		</div>
		<ul class="nav nav-tabs nav-justified">
			<li class="active"><a href="#per-conseillers" data-toggle="tab">Par conseillers</a></li>
			<li><a href="#st-all" data-toggle="tab">Tous</a></li>
			<li v-for="(value, index) in $store.state.transactstatestore.lstStatusTransaction">
				<a v-bind:href="'#status-' + index + '-0'" data-toggle="tab"><span data-toggle="tooltip"
																				   data-placement="bottom"
																				   :title="getLegend(index)">Status {{index}}-0</span></a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane fade in active" id="per-conseillers">
				<h3>Par conseillers</h3>
				<div class="">
					<table class="table table-responsive table-bordered">
						<thead>
							<tr>
								<th></th>
								<th class="text-uppercase text-center t-head-content">en attente</th>
								<th class="text-uppercase text-center t-head-content">Confirmées</th>
								<th class="text-uppercase text-center t-head-content">Total</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="c in $store.getters.getAllFromConseillers()" class="t-light" v-if="typeof c.conseiller !== 'undefined'">
								<td class="text-right">{{c.conseiller.login}}</td>
								<td class="text-center">{{ c.volume_incomplete | euros }}</td>
								<td class="text-center">{{ c.volume_complete | euros }}</td>
								<td class="text-center">{{ c.volume_complete + c.volume_incomplete | euros }}</td>
							</tr>
						</tbody>
						<tfoot>
							<tr class="t-head-content">
								<td class="text-right">Total</td>
								<td class="text-center">{{ $store.getters.calculateTotauxConseillers.waiting | euros}}</td>
								<td class="text-center">{{ $store.getters.calculateTotauxConseillers.finished | euros}}</td>
								<td class="text-center">{{ $store.getters.calculateTotauxConseillers.waiting + $store.getters.calculateTotauxConseillers.finished | euros }}</td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
			<div class="tab-pane fade" id="st-all">
				<h3>Response of life, universe and anythings else</h3>
				<transact-viewer-element :sort="$store.state.transactstatestore.sort" :namesearch="namesearch"
										 :date="date" :socgest="socgest"
										 :list="$store.state.transactstatestore.lstTransaction"
										 :date_selector="select.data"></transact-viewer-element>
			</div>
			<div v-for="(value, index) in $store.state.transactstatestore.lstStatusTransaction"
				 v-bind:id="'status-' + index + '-0'" class="tab-pane fade">
				<ul class="nav nav-pills nav-justified">
					<li v-if="value.length > 1" class="in active">
						<a v-bind:href="'#content-' + index + '-all'" data-toggle="pill">Tout</a></li>
					<li v-for="(el, i) in value" v-bind:class="((i == 0 && value.length == 1) ? 'in active' : '')"><a
								v-bind:href="'#content-'+index+'-'+i" data-toggle="pill">{{el.title}}</a></li>
				</ul>
				<div class="tab-content">
					<div v-if="value.length > 1" class="tab-pane fade in active"
						 v-bind:id="'content-' + index + '-all'">
						<h3>Tout</h3>
						<transact-viewer-element :sort="$store.state.transactstatestore.sort" :namesearch="namesearch"
												 :date="date" :socgest="socgest"
												 :list="$store.getters.getFromStatus('x-0')"
												 :date_selector="select.data"></transact-viewer-element>
					</div>
					<div class="tab-pane fade" v-for="(el, i) in value"
						 v-bind:class="((i == 0 && value.length == 1) ? 'in active' : '')"
						 v-bind:id="'content-'+index+'-'+i">
						<h3>{{el.title}}</h3>
						<transact-viewer-element :sort="$store.state.transactstatestore.sort" :namesearch="namesearch"
												 :date="date" :socgest="socgest"
												 :list="$store.getters.getFromStatus(index + '-' + i)"
												 :date_selector="select.data"></transact-viewer-element>
					</div>
				</div>
			</div>
		</div>
<!--		<transaction></transaction>-->
<!--		<portefeuilleTable></portefeuilleTable>-->
	</div>
</div>
</div>

