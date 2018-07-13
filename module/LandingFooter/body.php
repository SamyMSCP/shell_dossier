<div class="container-fluid container-footer">
	<div class="row">
		<div class="col-xs-12 col-sm-6 info-leg-all">
			<ul class="list-unstyled list-inline hidden-xs">
				<li><a href="Download.php?idDocument=<?=$this->linkFIL[0]->id?>" target="_blank">Informations légales</a></li>
				<li class="dot-separator"><i class="fa fa-xs fa-circle"></i></li>
				<a><a href="Download.php?idDocument=<?=$this->linkCGU[0]->id?>" target="_blank">CGU</a></li>
			</ul>

			<div class="dropup info-leg">
				<button type="button" class="dropdown-toggle visible-xs " data-toggle="dropdown">
					<span class="d-open">Légal <i class="fa fa-caret-up"></i></span>
					<span class="d-close">Légal <i class="fa fa-caret-right"></i></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li><a href="Download.php?idDocument=<?=$this->linkFIL[0]->id?>" target="_blank">Informations légales</a></li>
					<li><a href="Download.php?idDocument=<?=$this->linkCGU[0]->id?>" target="_blank">CGU</a></li>
					<li>© MeilleureSCPI.com 2011-2017</li>
					<li>Tous droits réservés</li>
				</ul>
			</div>
		</div>
		<div class="hidden-xs col-xs-10 col-sm-6 text-right">© MeilleureSCPI.com 2011-<?= date('Y')?>  — Tous droits réservés</div>
	</div>
</div>