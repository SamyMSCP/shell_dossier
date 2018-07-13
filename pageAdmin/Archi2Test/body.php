<div class="containerPerso vueApp">
	Page : {{ $store.getters.get_selected_page }}
	<h1>Archi2</h1>

	<?= ComponentListTable2Table::getHtmlTag(
		"DonneurDOrdre",
		[':data' => '$store.state.mscpi.datas.DonneurDOrdre.lst'])
	?>

	<?= ComponentTable2EditUlli::getHtmlTag(
		"DonneurDOrdre",
		[':data' => '$store.state.mscpi.datas.DonneurDOrdre'])
	?>

	<?= ComponentListTable2Table::getHtmlTag(
		"PersonnePhysique",
		[':data' => '$store.getters.getPersonnesPhysiquesForDonneurDOrdre'])
	?>

	<?= ComponentTable2EditUlli::getHtmlTag(
		"PersonnePhysique",
		[':data' => '$store.state.mscpi.datas.PersonnePhysique'])
	?>

	<?= ComponentListTable2Table::getHtmlTag(
		"Beneficiaire2",
		[':data' => '$store.getters.getBeneficiaire2ForDonneurDOrdre'])
	?>

	<?= ComponentTable2EditUlli::getHtmlTag(
		"Beneficiaire2",
		[':data' => '$store.state.mscpi.datas.Beneficiaire2'])
	?>

	<?= ComponentListTable2Table::getHtmlTag(
		"Projet2",
		[':data' => '$store.getters.getProjet2ForBeneficiaire2'])
	?>

	<?= ComponentTable2EditUlli::getHtmlTag(
		"Projet2",
		[':data' => '$store.state.mscpi.datas.Projet2'])
	?>

</div>
<?= $this->ModuleComponentManager ?>
