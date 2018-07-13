<?= $this->Nav ?>
<div class="containerPerso vueApp">
	<div class="row">
		<div class="col-lg-6 col-lg-offset-3">
			<h3>Gestionnaire de Carnet D'ordre</h3>
		</div>
	</div>
	<div class="row">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#second-stats" data-toggle="tab"><i class="fa fa-area-chart"></i>
					Statistiques</a></li>
			<li><a href="#gest" data-toggle="tab"><i class="fa fa-wrench"></i> Gestionnaire</a></li>
			<li><a href="/admin_lkje5sjwjpzkhdl42mscpi.php?p=Ordres"><i class="fa fa-search" aria-hidden="true"></i>
					Visualisation</a></li>
			<li><a href="#csv-control" data-toggle="tab"><i class="fa fa-lg fa-check-square-o"></i> CSV de controle</a>
			</li>
			<?php /*<li><a href="#ajout-scpi" data-toggle="tab"><i class="fa fa-rocket"></i> Ajout de SCPI</a></li>*/ ?>
		</ul>
	</div>
	<?= $this->OrderList ?>
	<?= $this->OrderStats ?>
	<div class="tab-content">
		<div class="tab-pane fade active in" id="second-stats">
			<div class="row">
				<div class="col-lg-6">
					<div class="chart-container">
						<canvas id="chartVolAchat"></canvas>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="chart-container">
						<canvas id="chartVolDiff"></canvas>
					</div>
				</div>
			</div>
			<order-stats></order-stats>
		</div>
		<div class="tab-pane fade" id="gest">
			<order-list></order-list>
		</div>
		<div class="tab-pane fade" id="csv-control">
			<div class="row">
				<h4>CSV de Controle</h4>
			</div>
			<div class="row">
				<div class="col-xs-2"><div class="well well-sm text-center">SCPI</div></div>
				<div class="col-xs-2"><div class="well well-sm text-center">ID</div></div>
				<div class="col-xs-2"><div class="well well-sm text-center">Prix par part</div></div>
				<div class="col-xs-2"><div class="well well-sm text-center">nombre de parts</div></div>
				<div class="col-xs-2"><div class="well well-sm text-center">Date</div></div>
				<div class="col-xs-2"><div class="well well-sm text-center">0 = achat : 1 = vente</div></div>
			</div>
			<div class="row" id="csv_parser">
				<pre>{{ getCsv }}</pre>
			</div>
		</div>
	</div>
</div>
