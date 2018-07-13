</script>
<script type="text/javascript" charset="utf-8">
	store.registerModule('pp', {
		state: {
			Pp: <?= json_encode($this->ppStore)?>,
			selectedPp: null,
			listQuestions: <?=json_encode($this->listQuestions)?>,
			listReponses: <?=json_encode($this->listReponses)?>
		},
		mutations : {
			SHOW_PROFIL: function(state, data) {
				state.selectedPp = data;
				$('#seeProfilModal').modal('show');
			}
		},
		getters: {
			getListQuestions: function(state, getters) {
				return (state.listQuestions);
			},
			getListReponses: function(state, getters) {
				return (state.listReponses);
			},
			getSelectedPersonnePhysique: function (state, getters) {
				return (state.selectedPp);
			},
			getAllPersonnePhysique: function(state, getters)
			{
				return state.Pp;
			},
			getPersonnePhysique: function(state, getters) {
				return(function(id_pp) {
					return (state.Pp.find(function(Pp){
						return (Pp.id == id_pp);
					}));
				});
			},
		}
	})
