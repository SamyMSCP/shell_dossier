<div style="position: fixed; left: 0px; bottom: 0px;">
	<div class="well" style="background-color: #75787B;">
		<img src="img/user.ico" style="width: 30px;">
		<span style="color: #FFFFFF;">Client :
			<?php echo htmlspecialchars(ft_decrypt_crypt_information($this->tab['nom'])) . " " . htmlspecialchars(ft_decrypt_crypt_information($this->tab['prenom'])); ?>
	   </span>
	 </div>
</div>
