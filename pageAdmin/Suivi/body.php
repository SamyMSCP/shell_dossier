<div class="container">
<?=$this->Nav?>
      <div class="well row">
          <div class="col-lg-6">
            <label>Civilité :</label><label class="form-control input-md" type="text"><?php echo htmlspecialchars(ft_decrypt_crypt_information($this->tab->civilite)); ?></label><br>
            <label>Nom :</label><label class="form-control input-md" type="text"><?php echo htmlspecialchars(ft_decrypt_crypt_information($this->tab->nom)); ?></label><br>
            <label>Prénom :</label><label class="form-control input-md" type="text"><?php echo htmlspecialchars(ft_decrypt_crypt_information($this->tab->prenom)); ?></label><br>
          </div>
          <div class="col-lg-6">
            <label>E-mail :</label><label class="form-control input-md" type="text"><?php echo htmlspecialchars(ft_decrypt_crypt_information($this->tab->mail)); ?></label><br>
            <label>Portable :</label><label class="form-control input-md" type="text"><?php echo htmlspecialchars(ft_decrypt_crypt_information($this->tab->telephone)); ?></label><br>
          </div>
          <?=$this->Suivi_crm?>
      </div>
</div>
