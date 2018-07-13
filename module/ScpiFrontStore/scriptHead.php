</script>
<script type="text/javascript" charset="utf-8">
	store.registerModule('scpi', {
		state: {
			lst: <?=json_encode(Scpi::getForFrontStore())?>,
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
			getScpiOpportunite: function(state, getters) {
				return (state.lst.filter(function(elm) {
					return (elm.showOpportunite == 1)
				}));
			},
		}
	})
