<?php
/**
 * Created by PhpStorm.
 * User: vthomas
 * Date: 20/02/2018
 * Time: 17:14
 */
?>
<div class="list-transaction container-fluid" v-if="true">
	<div class="list-title text-uppercase">
		{{ type }}
		<div class="right">
			SOUS-TOTAL: {{ transactionTotal | formatMoney }}
		</div>
	</div>
	<table class="table-transaction text-center table-responsive">
		<thead>
		<tr class="text-center">
			<th class="text-center">Nom de la SCPI</th>
			<th class="text-center">Date d'acquisition</th>
			<th class="text-center">Marché</th>
			<th class="text-center">Nombre de parts</th>
			<th class="text-center">Montant de la transaction</th>
			<th class="text-center">Action</th>
		</tr>
		</thead>
		<tbody>
		<tr v-for="trans in transactionFiltered">
			<td>{{ trans.scpi }} <i class="fa fa-star" v-if='trans.type_pro === "Nue propriété" && type === "Pleine propriété"' data-toggle="tooltip" title="Votre transaction Nue propriété est arrivée au terme de son démembrement."></i></td>
			<td>{{ trans.enr_date | moment }}</td>
			<td>{{ ((trans.marcher === "") ? "-" : trans.marcher) }}</td>
			<td>{{ trans.nbr_part }}</td>
			<td>{{ transactionCalcul(trans) | formatMoney }}</td>
			<td v-if="action === 0">
				<div class="container-fluid" v-if="trans.doByMscpi === 0">
					<div class="col-xs-6">
						<div class="btn btn-warning" @click="openModification(trans)"style="float: left;" data-toggle="tooltip" title="Acceder à la page de modification"><i class="fa fa-pencil"></i></div>
					</div>
					<div class="col-xs-6">
						<div class="btn btn-danger" @click="openDel(trans)" data-toggle="tooltip" title="Suppression de la SCPI du portefeuille"><i class="fa fa-lg fa-trash-o"></i></div>
					</div>
				</div>
				<div class="" v-else data-toggle="tooltip" title="Impossible d'effectuer une action Contactez votre conseiller"><img src="/assets/mscpi_icon/ms-logo-miniature.svg"/></div>
			</td>
			<td v-else-if="action === 1">
				<div class="btn btn-warning" @click="openVente(trans)"><img class="button-icon" src="/assets/Portefeuille/white.svg"/></div>
			</td>
			<td v-else-if="action === 2">
				<div class="btn btn-primary" @click="openReinvest(trans)"><i class="fa fa-credit-card"></i></div>
			</td>
		</tr>
		</tbody>
	</table>
</div>
