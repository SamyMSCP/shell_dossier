          <div class="col-lg-6">
        <?php
            //$tab1 = get_dh_id();
          //  if (empty($tab1)){
              //header("Location: lddd.php");
              //exit();
            //}
            $tab = get_info_perso_phy($this->dh->lien_phy);
          ?>
            <label>Civilité :</label>
            <?php
            $select = 0;
            if (ft_decrypt_crypt_information($tab['civilite']) === "Monsieur")
                $select = 1; ?>
                <select id="selectbasic" name="civil" class="form-control">
                    <option value="Monsieur" <?php if ($select) echo "selected"; ?>>Monsieur</option>
                    <option value="Madame" <?php if (!$select) echo "selected"; ?>>Madame</option>
                </select>
            <label>Prénom :</label><input class="form-control input-md" type="text" <?php echo 'value="' . htmlspecialchars(ft_decrypt_crypt_information($tab['prenom'])) . '"'; ?>></input>
            <label>E-mail :</label><input class="form-control input-md" type="text" <?php echo 'value="' . htmlspecialchars(ft_decrypt_crypt_information($tab['mail'])) . '"'; ?>></input>
            <label>Portable :</label><input class="form-control input-md" type="text" <?php echo 'value="' . htmlspecialchars(ft_decrypt_crypt_information($tab['telephone'])) . '"'; ?>></input>
            <label>Tel :</label><label class="form-control input-md" type="text">Je le trouve ou ?</label>
            <label>Adresse :</label><label class="form-control input-md" type="text">Je le trouve ou ?</label>
            <label>Code Postal :</label><label class="form-control input-md" type="text">Je le trouve ou ?</label>
            <label>Ville :</label><label class="form-control input-md" type="text">Je le trouve ou ?</label>
            <label>Pays :</label><label class="form-control input-md" type="text">Je le trouve ou ?</label>
            <br>
            <p>Date de création du compte : <?php echo "<span style=\"font-weight: bold;\">" . date_fr(strftime("%A %d %B %Y", strtotime($this->dh->day))) . "</span></p> ";?>
            <p>Date de fermeture du compte : Non cloturé.</p>
         </div>
        <div class="col-lg-6">
            <label>Date de naissance :</label><label class="form-control input-md" type="text">Je le trouve ou ?</label>
            <label>Lieu de naissance :</label><label class="form-control input-md" type="text">Je le trouve ou ?</label>
            <label>Pays de naissance :</label><label class="form-control input-md" type="text">Je le trouve ou ?</label>
            <label>Us Person</label><label class="form-control input-md" type="text">Je le trouve ou ?</label>
            <label>PPE</label><label class="form-control input-md" type="text">Je le trouve ou ?</label>
        </div>
            <br><br><br><br><br><br><br><br><br><br><br>
            <br><br><br><br><br><br><br><br><br><br><br>
            <br><br><br><br><br><br><br><br><br><br>
            <a class="btn btn-default" data-toggle="modal" data-target=".bs-example-modal-lg" style="float: right;"><img src="img/modify.ico" style="width: 30px;"> Ajouter une tache ?</a>
          </div>
    </div>
