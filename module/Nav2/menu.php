<li style="cursor: pointer;"><a href="?p=TableauDeBord"><img src="module/Nav2/img/DiagCircu-Bleu-MS.svg" alt="" />Tableau de bord</a></li>
<li style="cursor: pointer;"><a href="?p=Portefeuille"><img src="module/Nav2/img/Portefeuille-Bleu-MS.svg" alt="" />Mon portefeuille</a></li>
<?php if ($this->dh->phoneOk()) { ?>
	<li style="cursor: pointer;"><a href="?p=Opportunity"><img src="module/Nav2/img/opportunites-Bleu-MS.svg" alt="" />March&eacute; des opportunit&eacute;s</a></li>
<?php } else { ?>
	<li style="cursor: pointer;"><span onclick="msgBox.show('Cette page est accessible uniquement aux clients ayant validé leur numéro de téléphone par sms.')"><img style= "height: 20px; margin-right: 10px; padding-left: 0px;" src="module/Nav2/img/opportunites-Bleu-MS.svg" alt="" />March&eacute; des opportunit&eacute;s</span></li>
	<?php } ?>
<li style="cursor: pointer;"><a href="?p=Bibliotheque"><img src="module/Nav2/img/Guide-Bleu-MS.svg" alt="" />Bibliothèque</a></li>
<li style="cursor: pointer;"><a href="?p=Actu"><img src="module/Nav2/img/Actus-Bleu-MS.svg" alt="" />Actualités</a></li>
<li class="divider"><hr /></li>
<li style="cursor: pointer;"><span data-toggle="modal" data-target=".modal_set">Modifier mon profil</span></li>
<li style="cursor: pointer;"><span onclick="
	<?php if ($this->dh->confirmation == "3"): ?>
				store.commit('INIT_CI')
	<?php else: ?>
				$('#modal_restrict').modal('show')
	<?php endif; ?>">Préférences de communication</span></li>
<li style="cursor: pointer;"><a href="?p=<?=$GLOBALS['GET']['p']?>&help=<?=$_SESSION['anticsrf']?>">Être contacté par mon conseiller</a></li>
<li class="divider"><hr /></li>
<li><a <?php echo 'href="index.php?logout=' . ft_decrypt_crypt_information($_COOKIE['token']) . '"'; ?>> DÉCONNEXION</a></li>

