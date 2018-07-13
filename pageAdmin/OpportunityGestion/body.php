<?=$this->Nav?>
<div class="containerPerso vueApp">
	<div class="row" >
		<div class="col-lg-6 col-lg-offset-3">
			<h1>Gestionnaire d'Opportunit&eacute;</h1>
		</div>
	</div>
	<div class="container-fluid">
		<ul class="nav nav-tabs">
			<li class="active">
				<a data-toggle="tab" href="#stat-module">
					<i class="fa fa-pie-chart" aria-hidden="true"></i> Statistiques
				</a>
            </li>
            <li>
                <a data-toggle="tab" href="#editor-list">
                    <i class="fa fa-wrench" aria-hidden="true"></i> Gestionnaire
                </a>
            </li>
        </ul>
        <?=$this->OpportunityCreator?>
        <div class="tab-content">
            <div id="stat-module" class="tab-pane fade in active">
                <?=$this->OpportunityStats?>
            </div>
            <div id="editor-list" class="tab-pane fade container-fluid">
                <?=$this->OpportunityEdit?>
            </div>
        </div>
    </div>
    <opportunite-client-editor> </opportunite-client-editor>
</div>
