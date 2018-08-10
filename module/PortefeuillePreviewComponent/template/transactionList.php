<?php
/**
 * Created by PhpStorm.
 * User: vthomas
 * Date: 13/02/2018
 * Time: 16:16
 */
?>
<div class="list-transaction container-fluid" v-if="transactionFormating.length > 0 ">
	<div class="list-title text-uppercase">
		{{ type }}
		<div class="right">
			SOUS-TOTAL : {{ transactionTotal | formatMoney }}
		</div>
	</div>
	<table class="table-transaction text-center table-responsive">
		<thead>
			<tr class="text-center">
				<th v-for="el in getHeader" class="text-center" :class="el.class">{{el.value}}</th>
			</tr>
		</thead>


        <tbody>
        <tr v-for="(trans,ok) in transactionFormating">
            <td v-for="(el, index) in trans" :class="el.class" @click="openEdit(el.id)" >
					<span v-if="index === 0" >
                        <i class="text-warning fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" title="Il s'agit d'une transaction potentielle."></i>
						<i v-if="el.flag" class="text-warning fa fa-exclamation-triangle" aria-hidden="true" data-toggle="tooltip" title="Certaines informations manquent !"></i>
						<i v-if="el.is_nue_end" class="fa fa-star" aria-hidden="true" data-toggle="tooltip" title="Il s'agit ici d'une transaction Nue propriete arrivee a terme."></i>
						{{el.scpi}}
					</span>
                <span v-else>
                    {{el.value}}
                </span>
            </td>
        </tr>
        </tbody>
	</table>
</div>
