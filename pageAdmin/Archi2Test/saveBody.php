<div class="container">
	<?=$this->Nav?>
</div>
    <div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
        <center>
            <div class="page-header">
                <h1>LISTE DES DONNEURS D'ORDRE</h1>
            </div>
            <h2>Bonjour <?php if (($data = get_info_perso_phy(get_my_dh())) != -1)
                                    echo "<span class=\"policeimp\">" . htmlspecialchars(ft_decrypt_crypt_information($data['prenom'])) . " " . htmlspecialchars(ft_decrypt_crypt_information($data['nom'])) . "</span>";
                                    else
                                        echo "<span class=\"policeimp\">Kernel panic Call</span>";
            ?></h2>
            <?php if ($ok) { ?> <div class="alert alert-success" role="alert"></div><?php }?>
        </center>
        </div>
    </div>
    <br><br>
    <div class="row">
        <div class="col-lg-offset-4 col-lg-4">
            <input type="search" id="search" value="" class="form-control" placeholder="Entrée le nom d'un client">
        </div>
        <div class="col-lg-offset-1 col-lg-2">
            <a href="" class="btn btn-default" data-toggle="modal" data-target="#myModal" data-target=".bs-example-modal-lg" style="position: absolute; right: -6px; bottom: -69px;"><img src="img/add.ico" style="width: 30px;"> Ajouter un Client</a>
        </div>
        <br><br><br><br>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <table class="table" id="table">
                <thead style="background-color: #01528A;">
                    <tr>
                        <th style="cursor:pointer">Client</th>
                        <th style="cursor:pointer">Type</th>
                        <th style="cursor:pointer">Dernier contact</th>
                        <th style="cursor:pointer">Prochain contact</th>
                        <th style="cursor:pointer">Action à réaliser</th>
                        <th style="cursor:pointer">Valeur du portefeuille</th>
                        <th style="cursor:pointer">dernière souscription</th>
                    </tr>
                </thead>
                <?php
					$access = Dh::getCurrent();
					if ($access->getType() === "conseiller")
						$tabg = Dh::getCurrent()->getMyClients();
                    else
						$tabg = Dh::getClients();
					$key = 0;
                    $len = 0;
                    if (is_array($tabg))
                        $len = count($tabg);
					//while ($key < $len) {
                    foreach($tabg as $tabval)
                    {
						$tabcrm = get_crm(intval($tabval->id_dh));
                        $c = count($tabcrm);
                        $c--;
                     $tab = get_info_perso_phy($tabval->lien_phy);
					 if ($tabval->type)
						echo "<tr style=\"cursor:pointer;\" onclick=\"location.href='admin_lkje5sjwjpzkhdl42mscpi.php?p=Synthese&client=" . htmlspecialchars($tabval->id_dh) . "'\" class=\"success\">";
					else 
						echo "<tr style=\"cursor:pointer; background-color: #FECC92;\" onclick=\"location.href='admin_lkje5sjwjpzkhdl42mscpi.php?p=Synthese&client=" . htmlspecialchars($tabval->id_dh) . "'\">";
                    echo "<td>" . (htmlspecialchars(ft_decrypt_crypt_information($tab['civilite'])) == "Monsieur" ? "M. " : "Mme. ") . htmlspecialchars(ft_decrypt_crypt_information($tab['prenom'] ? $tab['prenom'] : "")) . " " . htmlspecialchars(ft_decrypt_crypt_information($tab['nom'] ? $tab['nom'] : "")) . "</td>";
                    echo "<td>" . htmlspecialchars($tabval->type ? strtoupper(substr($tabval->type, 0, 1)) . strtolower(substr($tabval->type, 1)) : "Prospect") . "</td>";
                    echo "<td>" . htmlspecialchars($c >= 0 ? $tabcrm[$c]['date_r'] : "Inconnue") . "</td>";
                    echo "<td>" . htmlspecialchars($c >= 0 ? $tabcrm[$c]['DATE_f'] : "Inconnue") . "</td>";
                    echo "<td>" . htmlspecialchars($c >= 0 ? ft_decrypt_crypt_information($tabcrm[$c]['action_f']) : "Rien") . "</td>";
                    echo "<td>" . number_format($tabval->getCacheArrayTable()["precalcul"]["ventePotentielle"], 2, ',', ' ') . " €</td>";
                    echo "<td><button type=\"button\" class=\"btn btn-info\" href=\"info.php?client=" . htmlspecialchars($tabval->id_dh) . "\">Info</button></td>";
                    echo "</tr>";
                    }
                ?>
            </table>
            <hr>
        </div>
    </div>
</div>
<script src="//rawgithub.com/stidges/jquery-searchable/master/dist/jquery.searchable-1.0.0.min.js"></script>
    <script type="text/javascript">

    $(function () {
    $( '#table' ).searchable({
        striped: true,
        oddRow: { 'background-color': 'FECC92' },
        evenRow: { 'background-color': 'FECC92' },
        searchType: 'fuzzy'
    });
    
    $( '#searchable-container' ).searchable({
        searchField: '#container-search',
        selector: '.row',
        childSelector: '.col-xs-4',
        show: function( elem ) {
            elem.slideDown(100);
        },
        hide: function( elem ) {
            elem.slideUp( 100 );
        }
    })
});
    </script>


<script type="text/javascript">
    $(document).ready(function(){
        $("#exampleModal").modal('show');
    }
    );

    $(document).ready(function() 
    { 
        $("#table").tablesorter(); 
    } 
); 
    
</script>
<?php 
    if (($tabg = get_dh(1)) != -1){
?>
<div class="modal fade" id="exampleModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Demande d'être contacter</h4>
      </div>
       <div class="modal-body">
<form class="form-horizontal" method="post" action="lddd.php">
<fieldset>
    <div class="row">
        <div class="col-lg-12">
            <table class="table" id="table">
                <thead style="background-color: #01528A;">
                    <tr>
                        <th>Contact</th>
                        <th>tel : </th>
                        <th>CRM</th>
                        <th>finish</th>
                    </tr>
                </thead>
                <?php
                    $key = 0;
                    $len = count($tabg);
                    while ($key < $len) {
                     $tab = get_info_perso_phy($tabg[$key]['lien_phy']);
                    echo "<tr class=\"warning\">";
                        echo "<td>" . htmlspecialchars(ft_decrypt_crypt_information($tab['civilite'])) . " " . htmlspecialchars(ft_decrypt_crypt_information($tab['prenom'])) . " " . htmlspecialchars(ft_decrypt_crypt_information($tab['nom'] ? $tab['nom'] : "")) . "</td>";
                         echo "<td>" . htmlspecialchars(ft_decrypt_crypt_information($tab['telephone'] ? $tab['telephone'] : "")) . "</td>";
                          echo "<td><a type=\"button\" class=\"btn btn-info\" target=\"_blank\" href=\"admin_lkje5sjwjpzkhdl42mscpi.php?p=Suivi&client=" . htmlspecialchars($tabg[$key]['id_dh']) . "\">ALLER AU CRM</a></td>";
                         echo "<td><input type=\"checkbox\" name=\"" . $tab['lien_dh'] . "\"value=\"1\"></td>";
                    echo "</tr>";
                    $key++;
                    }
                ?>
            </table>
            <hr>
        </div>
    </div>
<div class="form-group">
  <label class="col-md-4 control-label" for="button1id"></label>
  <div class="col-md-8">
    <button id="button1id" name="cbox" class="btn btn-info" value="Envoi">Envoi</button>
    <button id="button2id" name="button2id" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Plus tard</button>
  </div>
</div>

</fieldset>
</form>


</div>
</div>
</div>
</div>

<?php } ?>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width: 800px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Ajouter un client manuellement</h4>
      </div>
       <div class="modal-body">


<form class="form-horizontal" method="post" action="">
<fieldset>

<!-- Form Name -->

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic">Civilité</label>
  <div class="col-md-4">
    <select id="selectbasic" name="civil" class="form-control">
      <option value="Madame">Madame</option>
      <option value="Monsieur">Monsieur</option>
    </select>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="Nom">Nom de famille</label>  
  <div class="col-md-4">
  <input id="Nom" name="Nom" type="text" placeholder="" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="prenom">Prénom</label>  
  <div class="col-md-4">
  <input id="prenom" name="prenom" type="text" placeholder="" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="tel">Téléphone</label>  
  <div class="col-md-4">
  <input id="tel" name="tel" type="text" placeholder="" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="mail">E-mail</label>  
  <div class="col-md-4">
  <input id="mail" name="mail" type="text" placeholder="" class="form-control input-md" required="">
  </div>
</div>

<!-- Button (Double) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="button1id"></label>
  <div class="col-md-8">
    <button id="button1id" name="button1id" class="btn btn-info" value="Envoi">Envoi</button>
    <button id="button2id" name="button2id" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Annuler</button>
  </div>
</div>

</fieldset>
</form>




</div>
</div>
</div>
</div>





