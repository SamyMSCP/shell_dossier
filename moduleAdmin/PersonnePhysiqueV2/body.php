<div class='vueOngletPersonnePhysique'>
	<?=ComponentListPersonnesPhysiques::getHtmlTag('noname', [':data' => 'this.$store.getters.getPersonnesPhysiquesForDonneurDOrdre'])?>
	<?=ComponentListPersonnesMorale::getHtmlTag('noname', [':data' => 'this.$store.getters.getPersonnesMoraleForDonneurDOrdre'])?>
</div>
