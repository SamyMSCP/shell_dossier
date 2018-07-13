<?php
/**
 * Created by PhpStorm.
 * User: vthomas
 * Date: 20/02/2018
 * Time: 17:14
 */
?>
<div class="container-fluid" style="padding: 0px;">
	<div class="row" style="padding: 0px;">
		<div class="col-xs-11" v-if="search_enabled">
			<div class="input-group">
				<input type="text" v-model="search" class="form-control" placeholder="rechercher dans la liste"/>
				<div class="input-group-btn">
					<div class="btn" @click="search_enabled = !search_enabled"
						 :class="search_enabled ? 'btn-default' : 'btn-default'">
						<i class="fa fa-times"></i>
					</div>
				</div>
			</div>
			<ul class="list list-group">
				<li v-if="search_result.length === 0" class="list-group-item">Aucun r&eacute;sultat</li>
				<li v-for="scpi in search_result" class="list-group-item cursor" @click="change(scpi.id)">
					<div class="" >{{scpi.name}}</div>
				</li>
				<li v-if="search_result.length !== 0 && more" class=" list-group-item text-center">
					...
				</li>
			</ul>
		</div>
		<div class="col-xs-11" v-if="!search_enabled">
			<div class="input-group">
				<select class="form-control" v-model="select" @input="update_data" @change="update_data">
					<option selected disabled value="-1">Choisir une SCPI</option>
					<option v-for="scpi in data" :value.number="scpi.id">{{ scpi.name }}</option>
				</select>
				<div class="input-group-btn">
					<div class="btn" @click="search_enabled = !search_enabled"
						 :class="search_enabled ? 'btn-success' : 'btn-default'">
						<i class="fa fa-search"></i>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-1">
			<img class="icon status" src="/assets/status/valid.png" v-if="is_valid"/>
			<img class="icon status" src="/assets/status/warning.ico" v-else/>
		</div>
	</div>
</div>
