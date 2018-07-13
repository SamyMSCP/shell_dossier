<div class="menu menu_first col-md-3">
	<a href="?p=FrontAccueil&client=<?=$GLOBALS['GET']['client']?>" class="w_btn_menu btn btn-primary<?php echo ($this->page == "Accueil") ?  "-reverse" : "" ?>" style="border-color: #01528A;">Accueil</a>
</div>
<div class="menu col-md-3">
	<a href="?p=FrontMonPorteFeuille&client=<?=$GLOBALS['GET']['client']?>" class="marg w_btn_menu btn btn-primary<?php echo ($this->page == "MonPorteFeuille") ?  "-reverse" : "" ?>" style="border-color: #01528A;">Mon portefeuille</a>
</div>
<div class="menu col-md-3">
	<a href="?p=FrontActusPublications&client=<?=$GLOBALS['GET']['client']?>" class="marg w_btn_menu btn btn-primary<?php echo ($this->page == "ActusPublications") ?  "-reverse" : "" ?>" style="border-color: #01528A;">Actualités</a>
</div>
<div class="menu menu_last col-md-3">
	<a href="" data-toggle="modal" data-target="#NotNow" class="marg w_btn_menu btn btn-primary<?php echo ($this->page == "MesProjets") ?  "-reverse" : "" ?>" style="cursor:not-allowed; border-color: #01528A;">Mes projets</a>
</div>
