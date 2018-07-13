<?php
/**
 * Created by PhpStorm.
 * User: vthomas
 * Date: 07/12/2017
 * Time: 13:29
 */

?>

<div class="var-list">
	<ul class="nav nav-pills nav-justified">
		<li class="active"><a data-toggle="tab" href=".v-glob">Globales</a></li>
		<li><a data-toggle="tab" href=".v-other">Autres</a></li>
	</ul>
	<div class="tab-content">
		<div class="v-glob tab-pane fade in active">
			<table class="table table-responsive table-border">
				<thead>
				<tr>
					<th>Nom de la variable</th>
					<th>Valeur de la variable</th>
					<th>Action</th>
				</tr>
				</thead>
				<tbody>
				<tr v-for="val in var_list">
					<td>
						<input class="form-control" placeholder="nom de la variable" v-model="val.nom" v-if="val.edit"/>
						<span v-if="!val.edit">#{{val.nom}}#</span>
					</td>
					<td>
						<input class="form-control" placeholder="valeur de la variable" v-model="val.valeur"
							   v-if="val.edit"/>
						<span v-if="!val.edit">{{val.valeur.slice(0, 30)}}</span>
					</td>
					<td>
						<div class="btn btn-success" @click="val.edit = !val.edit"><i class="fa fa-wrench"></i></div>
					</td>
				</tr>
				</tbody>
				<tfoot>
				<td>
					<input class="form-control" placeholder="nom de la variable" v-model="var_toadd.nom"/>
				</td>
				<td>
					<input class="form-control" placeholder="valeur de la variable" v-model="var_toadd.valeur"/>
				</td>
				<td>
					<div class="btn btn-info" @click="addVariable"><i class="fa fa-plus"></i></div>
				</td>
				</tfoot>
			</table>

		</div>
		<div class="v-other tab-pane fade">
			<table class="table table-responsive table-border">
				<thead>
				<tr>
					<th>Nom de la variable</th>
					<th>Valeur de la variable</th>
					<th>Action</th>
				</tr>
				</thead>
				<tbody>
				<tr v-for="val in var_supplement">
					<td>
						<input class="form-control" placeholder="nom de la variable" v-model="val.nom" v-if="val.edit"/>
						<span v-if="!val.edit">%{{val.nom}}%</span>
					</td>
					<td>
						<input class="form-control" placeholder="valeur de la variable" v-model="val.valeur"
							   v-if="val.edit"/>
						<span v-if="!val.edit">{{val.valeur.slice(0, 30)}}</span>
					</td>
					<td>
						<div class="btn btn-success" @click="val.edit = !val.edit"><i class="fa fa-wrench"></i></div>
					</td>
				</tr>
				</tbody>
				<tfoot>
				<td>
					<input class="form-control" placeholder="nom de la variable" v-model="var_toadd.nom"/>
				</td>
				<td>
					<input class="form-control" placeholder="valeur de la variable" v-model="var_toadd.valeur"/>
				</td>
				<td>
					<div class="btn btn-info" @click="addVariableOther"><i class="fa fa-plus"></i></div>
				</td>
				</tfoot>
			</table>
		</div>
	</div>
</div>
