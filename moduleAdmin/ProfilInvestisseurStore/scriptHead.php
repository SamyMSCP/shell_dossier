</script>
<script type="text/javascript" charset="utf-8">

	store.registerModule('profilInvestisseur', {
		state: {
			typeProfil: <?=json_encode(ProfilInvestisseur::$_typeProfil)?>
		},
		mutations : {
		},
		actions: {
		},
		getters: {
			getGradeFromProfilNote: function (state, getters) {
				//return (function (note) {
					
				//});
			}
		}
	})
