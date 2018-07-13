<?php
	if (!empty($GLOBALS['GET']['client'])){
    $id = intval($GLOBALS['GET']['client']);
    if (get_my_dh(1)['type'] === "visiteur") echo '<div class="alert alert-info"><strong>Information : </strong> Vous pouvez uniquement consulter les documents/informations. Les droit de modifications/ajouts sont bloqués.</div>';
    else{
        if (!empty($GLOBALS['GET']['id']) && $crm = intval($GLOBALS['GET']['id'])){
                if (set_finish_crm($id, $crm))
              echo "<div class=\"alert alert-warning\"><strong>I AM VERY ANGRY !</strong> ARE YOU A HACKER ?!.</div>";
            else
              echo "<div class=\"alert alert-success\"><strong>Success !</strong> Les infos on été ajouté à la base de donnée.</div>";
        }
        else if (!empty($_POST) && empty(check_missing_info($_POST, array("action", "date", "radios", "commentaire", "action_r", "date_r", "radios1", "commentaire_r", "singlebutton")))){
          if (insert_crm($id)){ ?>
            <div class="alert alert-warning">
              <strong>I AM VERY ANGRY !</strong> ARE YOU A HACKER ?!.
           </div>
          <?php
          }
          else{
            ?> <div class="alert alert-success">
              <strong>Success !</strong> Les infos on était ajouter à la base de données.
          </div>
          <?php
          }
        }
      }
		$this->dh = Dh::getById($GLOBALS['GET']["client"]);
		$this->loadModuleAdmin("Nav", "Nav", array("id" => $this->dh->id_dh));
		$this->loadModuleAdmin("Suivi_crm", "Suivi_crm", array());
    $this->tab = $this->dh->getPersonnePhysique();
	}
