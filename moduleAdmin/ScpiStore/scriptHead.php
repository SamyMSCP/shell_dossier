</script>
<script type="text/javascript" charset="utf-8">
	store.registerModule('scpi', {
		state: {
			lst: <?=json_encode(Scpi::getForStore())?>,
		},
		mutations : {
			SCPI_TEST: function(state, data) {
				console.log(state);
			}
		},
		actions: {
			SCPI_GET: function(context, data) {
				// Lancer une requete pour mettre recuperer l'element
				// commit le changement
			}
		},
		getters: {
			getAllScpi: function(state, getters) {
				return (state.lst);
			},
			getAllScpiSorted: function(state, getters) {
				return (state.lst.sort(function(a, b) {
					return (String(a.name).localeCompare(String(b.name)));
				}));
			},
			getScpi: function(state, getters) {
				return (function (id) {
					return (state.lst.find(function(elm) {
						return (elm.id == id)
					}));
				})
			},
			getScpiValue: function(state, getters) {
				return (function (id) {
					return (state.lst.find(function(elm) {
						return (elm.id == id)
					}));
				})
			},
			getScpiForSocieteGestion: function(state, getters) {
				return (function (id_societe) {
					return (state.lst.filter(function(elm) {
						return (elm.company_id == id_societe);
					}));
				})
			},
			getScpiOpportunite: function(state, getters) {
				return (state.lst.filter(function(elm) {
					return (elm.showOpportunite == 1)
				}));
			},
		}
	})
