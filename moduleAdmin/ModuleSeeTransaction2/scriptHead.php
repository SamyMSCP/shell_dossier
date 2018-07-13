</script>
<script type="text/template" id="seeTransaction">
	<div>
		<ul class="nav nav-tabs">
			<template v-for="(tab, key) in statustabs">
				<li v-if="tab.length == 1"><a href="#" @click="filterLst.filterStatus = key + ''">{{ key }}</a></li>
				<li v-else class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">{{ key }}
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li v-for="(subtab, subkey) in tab" ><a href="#" @click="filterLst.filterStatus = key + '-' + subkey">{{ subkey }} - {{ subtab.title }}</a></li>
				    </ul>
				</li>
			</template>
		</ul>
		<table class="tableDh">
			<caption> {{ filteredTr.length }} / {{ transactions.length }}</caption>
			<thead>
				<tr>
					<th>Type de bénéficiaire</th>
					<th style="cursor: pointer" @click="orderBy = (orderBy == 'orderByNameASC') ? 'orderByNameDESC' : 'orderByNameASC'">Civilité Prénom Nom<br />Dénomination sociale</th>
					<th>État transaction</th>
					<th style="cursor: pointer" @click="orderBy = (orderBy == 'orderByDateASC') ? 'orderByDateDESC' : 'orderByDateASC'">Date d'enregistrement</th>
					<th>Conseiller</th>
					<th>Commentaire</th>
					<th style="cursor: pointer" @click="orderBy = (orderBy == 'orderBySCPIASC') ? 'orderBySCPIDESC' : 'orderBySCPIASC'">SCPI</th>
					<th style="cursor: pointer" @click="orderBy = (orderBy == 'orderByPartASC') ? 'orderByPartDESC' : 'orderByPartASC'">Nombre de parts</th>
					<th style="cursor: pointer" @click="orderBy = (orderBy == 'orderByPrixASC') ? 'orderByPrixDESC' : 'orderByPrixASC'">Prix Achat / Vente</th>
					<th>Type de propriété</th>
					<th>Durée si DT</th>
					<th>Clé répartition</th>
					<th>Montant Transaction</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<select class="form-control" v-model="filterLst.filterPP">
							<option value="">--</option>
							<option value="PP">PP</option>
							<option value="PM">PM</option>
						</select>
					</td>
					<td>
						<input class="form-control" type="text" v-model.lazy="filterLst.filterName" />
					</td>
					<td>
						<!--<select v-model="filterLst.filterStatus">
							<option value="">--</option>
							<option v-for="(status, key) in statustransactions" :value="key">{{ status }}</option>
						</select>-->&nbsp;
					</td>
					<td>
						<select class="form-control pull-left" style="width: 40px;padding: 6px 8px;" v-model="date_mm" @change="filterLst.filterDate = Number(filterLst.filterDate)">
							<option value="">--</option>
							<option v-for="i in 12" :value="(i - 1)">{{ i }}</option>
						</select>
						<input type="text" maxlength="4" class="form-control pull-left" style="width: 60px" v-model.lazy="filterLst.filterDate" />
					</td>
					<td>
						<select class="form-control" v-model="filterLst.filterCons">
							<option value="">--</option>
							<option v-for="(name, id) in conseillers" :value="id">{{ name }}</option>
						</select>
					</td>
					<td>&nbsp;</td>
					<td>
						<select class="form-control" v-model="filterLst.filterScpi">
							<option value="">--</option>
							<option v-for="scpi in $store.getters.getAllScpiSorted" :value="scpi.id">{{ scpi.name | unprefix_scpi }}</option>
						</select>
					</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>
						<select class="form-control" v-model="filterLst.filterPro">
							<option value="">--</option>
							<option v-for="typepro in typespropriete" :value="typepro">{{ typepro }}</option>
						</select>
					</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			</tbody>
			<tbody>
				<tr v-for="tr in filteredTr" @click="viewDhTr( tr.id_dh, tr.id)">
					<td>{{ getPersonneStr(tr.is_pp) }}</td>
					<td v-if="tr.is_pm">{{ tr.ds }}</td>
					<td v-else>{{ tr.shortname }}</td>
					<td>{{ statustransactions[tr.status] }}</td>
					<td v-if="tr.status.substr(0,1) == '7'">{{ tr.status_date | date }}</td>
					<td v-else>{{ tr.enr | date }}</td>
					<td>{{ conseillers[tr.id_cons] }}</td>
					<td>{{ tr.com }}</td>
					<td>{{ $store.getters.getScpi(tr.id_scpi).name | unprefix_scpi }}</td>
					<td>{{ tr.part | shares }}</td>
					<td>{{ tr.prix | shares_price_eur }}</td>
					<td>{{ tr.pro }}</td>
					<td v-if="tr.pro == 'Pleine propriété'">SO</td>
					<td v-else-if="tr.is_viager">Viager</td>
					<td v-else>{{ tr.dt | years }}</td>
					<td>{{ tr.cle | distribution_key }}</td>
					<td>{{ tr.montant | euros }}</td>
				</tr>
			</tbody>
		</table>
	</div>
</script>
<script type="text/javascript">
Vue.component('seeTransaction',
{
 	data: function(){
 		return {
 			'transactions': <?= json_encode($this->TransactionsList, TRUE) ?>,
 			'conseillers': <?= json_encode(Dh::getConseillersForStoreMini()) ?>,
 			'statustransactions': <?= json_encode(StatusTransaction::getLstForStore()) ?>,
 			'statustabs': <?= json_encode(StatusTransaction::getLst()) ?>,
 			'typespropriete': <?= json_encode(Transaction::getTypeProLst()) ?>,
 			'filterLst': {
 				filterPP: "",
 				filterDate: "",
	 			filterName: "",
	 			filterStatus: "5",
	 			filterCons: "",
	 			filterScpi: "",
	 			filterPro: ""
	 		},
	 		'orderBy': '',
	 		'date_mm': '',
	 		'date_yyyy': ''
 		};
 	},
 	computed: {
		'filteredTr': function()
		{
			// va contenir les filtres activés sous la forme {fn : 'pointeur sur la fonction' , val: 'valeur de comparaison'}
			var filters = [];
			len = Object.keys(this.filterLst).length;
			for (var i = 0; i < len; i++)
 			{
 				if (typeof this.filterLst[Object.keys(this.filterLst)[i]] != 'undefined' && this.filterLst[Object.keys(this.filterLst)[i]] != "")
 					filters.push({fn : this[Object.keys(this.filterLst)[i]], val: this.filterLst[Object.keys(this.filterLst)[i]]});
 			}
// TODO : tri par insertion
			var tr = this.transactions.filter(function(elm)
 			{
 				for (var i = 0, len = filters.length; i < len; i++)
 				{
 					if (!filters[i].fn(elm, filters[i].val))
 						return false;
 				}
 				return true;
 			}, this);
 			if (this.orderBy != '')
 			{
 				/*var mapped = tr.map(function(elt, index){
 					return {i: index, e: elt};
 				});
 				var that = this;
 				mapped.sort(function(e) {
 					that[that.orderBy](e.e);
 				});
 				console.log(mapped);
 				return mapped.map(function(e){
 					return tr[e.i];
 				});*/
 				tr.sort(this[this.orderBy]());
 			}
 			return tr;
		}
	},
 	methods: {
 		getPersonneStr: function( is_pp )
 		{
 			return (is_pp) ? "PP" : "PM" ;
 		},
 		filterPP: function(elt, value )
 		{
 			if (value == 'PP' && elt.is_pp == 1)
 				return true;
 			if (value == 'PM' && elt.is_pm == 1)
 				return true;
 			return false;
 		},
 		filterDate: function(elt, value)
 		{
 			/*if (typeof value == 'undefined' || value == "")
 				return true;*/
 			if (elt.enr == "")
 				return false;
 			var d_e = new Date();
 			d_e.setTime(elt.enr * 1000);
 			if (value != d_e.getFullYear())
 				return false;
 			if (this.date_mm != '')
 				return (this.date_mm == d_e.getMonth());
 			return true;
 		},
 		filterName: function(elt, value)
 		{
 			if (elt.is_pp)
 			{
 				if (elt.shortname != null && elt.shortname.trim().toLowerCase().match(value.trim().toLowerCase()))
 					return true;
 				return false;
 			}
 			if (elt.ds != null)
 				return (elt.ds.trim().toLowerCase().match(value.trim().toLowerCase()));
 			return false;
 		},
 		filterStatus: function( elt, value )
 		{
 			return (elt.status.substr(0, value.length) == value);
 		},
 		filterCons: function( elt, value )
 		{
 			return (elt.id_cons == value);
 		},
 		filterScpi: function( elt, value )
 		{
 			return (elt.id_scpi == value);
 		},
 		filterPro: function( elt, value )
 		{
 			return (elt.pro == value);
 		},
 		viewDhTr: function( id_dh, id_tr)
 		{
 			window.open('admin_lkje5sjwjpzkhdl42mscpi.php?p=EditionClient&client=' + id_dh + '&open_transac=' + id_tr, '_blank');
 		},
 		orderByScpiASC: function( )
 		{
			var gettt = this.$store.getters.getScpi;
 			return function(a, b) {
 				return new Intl.Collator("fr").compare(gettt(a).name, gettt(b).name);
 			};
 		},
 		orderByScpiDESC: function( )
 		{
			var gettt = this.$store.getters.getScpi;
 			return function(a, b) {
 				return new Intl.Collator("fr").compare(gettt(b).name, gettt(a).name);
 			};
 		},
 		orderByPartASC: function( )
 		{
 			return function(a, b)
 			{
 				return (Number(a.part) < Number(b.part)) ? 1 : -1 ;
 			}
 		},
 		orderByPartDESC: function( )
 		{
 			return function(a, b)
 			{
 				return (Number(a.part) > Number(b.part)) ? 1 : -1 ;
 			}
 		},
 		orderByPrixASC: function( )
 		{
 			return function(a, b)
 			{
 				return (Number(a.prix) < Number(b.prix)) ? 1 : -1 ;
 			}
 		},
 		orderByPrixDESC: function( )
 		{	
 			return function(a, b)
 			{
 				return (Number(a.prix) > Number(b.prix)) ? 1 : -1 ;
 			}
 		},
 		orderByDateASC: function()
 		{
 			return function(a, b)
 			{
 				return (a.enr > b.enr) ? 1 : -1 ;
 			}
 		},
 		orderByDateDESC: function()
 		{
 			return function(a, b)
 			{
 				return (a.enr < b.enr) ? 1 : -1 ;
 			}
 		},
 		orderByNameASC: function( )
 		{
 			return function(a, b) {
	 				var _a;
	 				var _b;
	 				_a = (a.is_pp) ? a.name : a.ds ;
	 				_b = (b.is_pp) ? b.name : b.ds ;
	 			return _b.localeCompare(_a);
	 		}
	 	},
	 	orderByNameDESC: function( )
 		{
			return function(a, b) {
				var _a;
				var _b;
				_a = (a.is_pp) ? a.name : a.ds ;
				_b = (b.is_pp) ? b.name : b.ds ;
				return _a.localeCompare(_b);
			}
 		}
 	},
 	template: '#seeTransaction'
});