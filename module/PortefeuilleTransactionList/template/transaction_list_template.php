<?php
/**
 * Created by PhpStorm.
 * User: vthomas
 * Date: 20/02/2018
 * Time: 17:14
 */
?>
<div class="list-transaction container-fluid" v-if="transactionTotal !== 0.0">
	<div class="list-title text-uppercase">
		{{ type }}
		<div class="right">
			SOUS-TOTAL: {{ transactionTotal | formatMoney }}
		</div>
	</div>
	<table class="table-transaction text-center table-responsive">
		<thead>
		<tr class="text-center">
			<th v-for="el in getHeader" class="text-center">{{el}}</th>
		</tr>
		</thead>
		<tbody>
		<tr v-for="trans in transactionFormating">
			<!-- TODO: Add Star for transactions modification Ticket #215 -->
			<td v-for="el in trans">{{el}}</td>
		</tr>
		</tbody>
	</table>
</div>
