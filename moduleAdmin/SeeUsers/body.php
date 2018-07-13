<div class="SeeUsers">
	<h4 onclick="toggleSeeUsers();">Voir un autre compte</h4>
	<ul>
		<?php
		foreach ($this->data as $elm) {
		?>
			<li><a href="?p=<?=$GLOBALS['GET']['p']?>&client=<?=$elm->id_dh?>"><?=$elm->getPersonnePhysique()->getCivilite()?> <?=$elm->getPersonnePhysique()->getFirstName()?> <?=$elm->getPersonnePhysique()->getName()?> '<?=$elm->getLogin()?>'</a></li>
		<?php
		}
		?>
	</ul>
</div>
