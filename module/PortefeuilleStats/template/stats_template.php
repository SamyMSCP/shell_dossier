<?php
/**
 * Created by PhpStorm.
 * User: vthomas
 * Date: 20/02/2018
 * Time: 17:14
 */
?>
<div class="container">
	<div class="row">
		<div class="col-md-4" style="padding: 0">
			<canvas id="stats-plein-pro" style="width: 100%; height:auto" class="stats_center"></canvas>
			<div class="center-legend">
				<span class="percent">{{ ((!!(chart)) ? chart.pleine.segments[0].value / 100 : 0.0) | percent }}</span><br>
				<span class="text-legend">{{ ((!!(chart)) ? chart.pleine.segments[0].label : "") }}</span><br>
			</div>
		</div>
		<div class="col-md-4" style="padding: 0">
			<canvas id="stats-nue-pro" style="width: 100%; height:auto" class="stats_center"></canvas>
			<div class="center-legend">
				<span class="percent">{{ ((!!(chart)) ? chart.nue.segments[0].value / 100 : 0.0) | percent }}</span><br>
				<span class="text-legend">{{ ((!!(chart)) ? chart.nue.segments[0].label : "") }}</span><br>
			</div>
		</div>
		<div class="col-md-4" style="padding: 0">
			<canvas id="stats-usu" style="width: 100%; height:auto" class="stats_center"></canvas>
			<div class="center-legend">
				<span class="percent">{{ ((!!(chart)) ? chart.usu.segments[0].value / 100 : 0.0) | percent }}</span><br>
				<span class="text-legend">{{ ((!!(chart)) ? chart.usu.segments[0].label : "") }}</span><br>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 text-center">
			<span v-if="get_flag_pleine || get_flag_nue || get_flag_usu">
				<i class="text-warning fa fa-warning"></i> Des informations sont manquantes pour une ou plusieurs transaction(s)
			</span>
		</div>
	</div>
</div>
