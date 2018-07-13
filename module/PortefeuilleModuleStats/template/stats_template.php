<?php
/**
 * Created by PhpStorm.
 * User: vthomas
 * Date: 20/02/2018
 * Time: 17:14
 */
?>
<div class="module main-portefeuille stats-module">
	<div class="header">
		<div class="text-uppercase">
			<img class="icon" src="assets/PieChart/DiagCircu-Blanc.svg"/>
			<span class="stats-module-header">{{ textTitle }}</span>
			<div class="right">
				<img class="icon" src="assets/info/i-Blanc.svg"/>
			</div>
		</div>
	</div>
	<div class="content" style="">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-12">
					<canvas :id="canvasId" style="height: 100%; width: auto;" class="stats_center"></canvas>
				</div>
			</div>
		<div class="row">
			<div class="col-xs-12">
				<ul class="list list-unstyled legend">
					<li v-for="el in typeGraph.data" class="row data-legend">
						<div class="col-xs-1 col-sm-1">
							<div class="pill-color" :style="'background-color:' + el.color">&nbsp;</div>
						</div>
						<div class="col-xs-5 col-sm-5 legend text">
							{{ el.label }}
						</div>
						<div class="col-xs-5 col-sm-6 legend percent text-right" :style="'color:' + el.color">
							{{ el.value / 100.0 | percent}}
						</div>
					</li>

				</ul>
			</div>
		</div>
		</div>
	</div>
</div>
