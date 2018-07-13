<td>
	<div class="doMscpi" v-if="trans.doByMscpi">
		<div></div>
	</div>
	<div class="doOther" v-else></div>
</td>
<td>
	{{ getScpi(trans.id_scpi).name.substr(5) }}
</td>
<td>
	{{ trans.nbr_part }}
</td>
<td>
	{{ trans.enr_date | date }}
</td>
<td>
	{{ trans.date_entre_joui_calc | date }}
</td>
<td v-if="trans.type_pro != 'Pleine propriété'">
	{{ trans.dt }} ans
</td>
<td v-else>-</td>
<td v-if="trans.type_pro != 'Pleine propriété'">
	{{ trans.fin_demembrement | date }}
</td>
<td v-else>-</td>
<td>
	{{ trans.prix_part }}
</td>
<td>
	{{ trans.montantInvestissement | euros }}
	<?php
	/*
	{{ trans.montantInvestissement }} <br />
	<span v-if="trans.type_pro == 'Pleine propriété'">{{ trans.prix_part * trans.nbr_part | euros }}</span>
	<span v-else>{{ trans.prix_part * trans.nbr_part * trans.cle_repartition / 100 | euros }}</span>
	*/
	?>
</td>
<td>
	<?php //{{ trans.reventePotentielle | euros }} ?>
<!--	{{ getScpi(trans.id_scpi).value * trans.nbr_part| euros }}-->
	{{ getReventePotentielle(trans) | euros }}
	<?php
	/*
	<span v-if="trans.type_pro == 'Pleine propriété'">{{ getScpi(trans.id_scpi).value * trans.nbr_part | euros }}</span>
	<span v-else>{{ getScpi(trans.id_scpi).value * trans.nbr_part * trans.cle_repartition_dynamique / 100 | euros }}</span>
	<span></span>
	*/
	?>
</td>
<td>
	{{ getPlusMoinValue(trans) }}
</td>
