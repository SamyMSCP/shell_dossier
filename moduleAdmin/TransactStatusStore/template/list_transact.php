<?php
/**
 * Created by PhpStorm.
 * User: vthomas
 * Date: 14/12/2017
 * Time: 12:00
 */
?>
<div class="container-fluid">
	<table class="t-visu">
		<thead>
			<tr>
				<th class="text-center">id</th>
				<th class="text-center">Nom de la SCPI</th>
				<th class="text-center">Societe de Gestion</th>
				<th class="text-center">Date d'enregistrement
					<span class="btn" @click="$store.commit('sort_date_enr')">
						<span class="fa-stack fa-lg">
							<i class="fa fa-square-o fa-stack-2x"></i>
							<i class="fa fa-sort fa-stack-1x" v-if="sort.date_enr_num === 0"></i>
							<i class="fa fa-sort-numeric-desc fa-stack-1x" v-if="sort.date_enr_num === 1"></i>
							<i class="fa fa-sort-numeric-asc fa-stack-1x" v-if="sort.date_enr_num === 2"></i>
						</span>
					</span>
				</th>
				<th class="text-center">Date de modification
					<span class="btn" @click="$store.commit('sort_date')">
						<span class="fa-stack fa-lg">
							<i class="fa fa-square-o fa-stack-2x"></i>
							<i class="fa fa-sort fa-stack-1x" v-if="sort.date_num === 0"></i>
							<i class="fa fa-sort-numeric-desc fa-stack-1x" v-if="sort.date_num === 1"></i>
							<i class="fa fa-sort-numeric-asc fa-stack-1x" v-if="sort.date_num === 2"></i>
						</span>
					</span>
				</th>
				<th class="text-center">Status</th>
				<th class="text-center">Nombre de parts
					<span class="btn" @click="$store.commit('sort_part')">
						<span class="fa-stack fa-lg">
							<i class="fa fa-square-o fa-stack-2x"></i>
							<i class="fa fa-sort fa-stack-1x" v-if="sort.part_num === 0"></i>
							<i class="fa fa-sort-numeric-desc fa-stack-1x" v-if="sort.part_num === 1"></i>
							<i class="fa fa-sort-numeric-asc fa-stack-1x" v-if="sort.part_num === 2"></i>
						</span>
					</span>
				</th>
				<th class="text-center">Volume
					<span class="btn" @click="$store.commit('sort_volume')">
						<span class="fa-stack fa-lg">
							<i class="fa fa-square-o fa-stack-2x"></i>
							<i class="fa fa-sort fa-stack-1x" v-if="sort.vol_num === 0"></i>
							<i class="fa fa-sort-numeric-desc fa-stack-1x" v-if="sort.vol_num === 1"></i>
							<i class="fa fa-sort-numeric-asc fa-stack-1x" v-if="sort.vol_num === 2"></i>
						</span>
					</span>
				</th>
				<th class="text-center" >
					Donneur D'Ordres
					<span class="btn" @click="$store.commit('sort_alpha')">
						<span class="fa-stack fa-lg">
							<i class="fa fa-square-o fa-stack-2x"></i>
							<i class="fa fa-sort fa-stack-1x" v-if="sort.name_alpha === 0"></i>
							<i class="fa fa-sort-alpha-desc fa-stack-1x" v-if="sort.name_alpha === 1"></i>
							<i class="fa fa-sort-alpha-asc fa-stack-1x" v-if="sort.name_alpha === 2"></i>
						</span>
					</span>
				</th>
				<th class="text-center">Options</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="el in list" v-if="">
				<td> {{ el.id }} </td>
				<td> {{ $store.getters.getScpi(parseInt(el.id_scpi)).name }} </td>
				<td>
					{{ $store.getters.getScpi(el.id_scpi).societeDeGestion.name }}
				</td>
				<td class="text-center"> {{ el.enr_date | moment }}<br>({{ el.enr_date | to_now }})</td>
				<td class="text-center"> {{ el.date_edit_trans | moment }}<br>({{ el.date_edit_trans | to_now }})</td>
				<td class="text-center"> Status {{ el.status_sup }}-{{ el.status_sub }} </td>
				<td class="text-center"> {{el.nbr_part}} </td>
				<td class="text-center"> {{(el.nbr_part * el.prix_part).toLocaleString("fr", {style: "currency", currency: "EUR"})}} </td>
				<td>
					<a v-bind:href="'?p=EditionClient&client=' + el.id_donneur_ordre">{{el.civilite}} {{el.prenom}} {{el.nom}}</a>
				</td>
				<td class="text-center">
					<a class="btn btn-warning" target="_blank" :href="'/admin_lkje5sjwjpzkhdl42mscpi.php?p=EditionClient&client=' + el.id_donneur_ordre + '&transac=' + el.id" >
						<i class="fa fa-pencil"></i>
					</a>
				</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="6">Total:</td>
				<td class="text-center">{{ getParts }}</td>
				<td class="text-center">{{ getVolume }}</td>
				<td colspan="2" class="text-right">{{ list.length }} Transactions</td>
			</tr>
		</tfoot>

	</table>

</div>
