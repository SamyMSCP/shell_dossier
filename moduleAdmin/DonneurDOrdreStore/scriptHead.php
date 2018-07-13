</script>
<script type="text/javascript" charset="utf-8">

	store.registerModule('dh', {
		state: {
			lstConseillers: <?=json_encode($this->lstConseillers)?>,
			lst: [],
			lstTypeDocument: <?=json_encode($this->RequiredDocumentDh)?>,
			selectedDh: {
				id: <?=$this->dh->id_dh?>
			},
			Dh: <?= json_encode($this->dhStore)?>,
			actual: {}
		},
		mutations : {
 			TOGGLE_ACTUAL_CI: function(state, [data, disable])
 			{
 				state.actual.ci[data] = (state.actual.ci[data]) ? false : true;
 				if (typeof disable !== "undefined")
 				{
 					for (i = 0; i < disable.length; i++)
 					{
 						state.actual.ci[disable[i]] = state.actual.ci[data]; 
 					}
 				}
 			},
 			TOGGLE_ACTUAL_CISCPI: function(state, [data])
 			{
 				state.actual.ciscpi[data] = (state.actual.ciscpi[data]) ? false : true;
 			},
			DH_UPDATE_CI: function(state, data) {
				state.Dh.ci = data.ci;
			},
			DH_UPDATE_CISCPI: function(state, data) {
				state.Dh.ciscpi = data.ciscpi;
			},
			DH_UPDATE_CIS: function(state, data) {
				state.Dh = {'ci': data.ci, 'ciscpi': data.scpi}
			},
			INIT_CI: function(state, data) {
				var tmpActual = {'ci': JSON.parse(JSON.stringify(state.Dh.ci)),
					'ciscpi': JSON.parse(JSON.stringify(state.Dh.ciscpi))};
				state.actual = tmpActual;
			},
			DH_UPDATE_PARRAIN: function(state, data) {
				state.Dh = data;
			},
			DH_TOGGLE_ADRESSE_VALIDE: function(state, data) {
				state.Dh = data;
			}
		},
		actions: {
			DH_TOOGLE_ADRESSE_VALIDE: function(context, data) {
				return (new Promise(function(resolve, reject) {

					Vue.http.post('ajax_request.php',
					{
						req: 'AjaxDhAdmin',
						action: 'toggleAdresseValide',
						data: data,
						token: "<?=$_SESSION['csrf'][0]?>"
					},
					{emulateJSON: true})
					.then(
						function (res) {
							context.commit("DH_TOGGLE_ADRESSE_VALIDE", res.body.data);
							resolve(res.body.data);
						},
						function (res) {
							if (typeof res.body != "undefined" && typeof res.body.err != 'undefined')
									msgBox.show(res.body.err);
								else 
									msgBox.show("Une erreur est survenue !");
							reject();
						}
					)
				}));

			},
			DH_SET_PARRAIN: function(context, data) {
				return (new Promise(function(resolve, reject) {
					Vue.http.post('ajax_request.php',
					{
						req: 'AjaxDhAdmin',
						action: 'setParrain',
						data: data,
						token: "<?=$_SESSION['csrf'][0]?>"
					},
					{emulateJSON: true})
					.then(
						function (res) {
							context.commit("DH_UPDATE_PARRAIN", res.body.data);
							resolve(res.body.data);
						},
						function (res) {
							if (typeof res.body != "undefined" && typeof res.body.err != 'undefined')
									msgBox.show(res.body.err);
								else 
									msgBox.show("Une erreur est survenue !");
							reject();
						}
					)
				}));
				
			},
			DH_UPDATE_CI: function (context, data) {
				return (new Promise(function(resolve, reject) {
					Vue.http.post('ajax_request_client.php',
					{
						req: 'DhFrontStore',
						action: 'update_ci',
						data: data,
						token: "<?=$_SESSION['csrf'][0]?>"
					},
					{emulateJSON: true})
					.then(
						function (res) {
							context.commit("DH_UPDATE_CI", res.body);
							resolve(res.body);
						},
						function (res) {
							/*if (typeof res.body != "undefined" && typeof res.body.err != 'undefined')
									msgBox.show(res.body.err);
								else 
									msgBox.show("Une erreur est survenue !");*/
							reject();
						}
					)
				}));
			},
			DH_UPDATE_CISCPI: function (context, data) {
				return (new Promise(function(resolve, reject) {
					Vue.http.post('ajax_request_client.php',
					{
						req: 'DhFrontStore',
						action: 'update_ciscpi',
						data: data,
						token: "<?=$_SESSION['csrf'][0]?>"
					},
					{emulateJSON: true})
					.then(
						function (res) {
							context.commit("DH_UPDATE_CISCPI", res.body);
							resolve(res.body);
						},
						function (res) {
							/*if (typeof res.body != "undefined" && typeof res.body.err != 'undefined')
									msgBox.show(res.body.err);
								else 
									msgBox.show("Une erreur est survenue !");*/
							reject();
						}
					)
				}));
			}
		},
		getters: {
			getSelectedDh: function(state, getters) {
				return (state.selectedDh);
			},
			getConseillers: function (state, getters) {
				return (state.lstConseillers);
			},
			getDh: function(state, getters) {
				return state.Dh;
			},
			getActualCI: function(state, getters) {
				return state.actual.ci;
			},
			getActualCISCPI: function(state, getters) {
				return state.actual.ciscpi;
			},
		}
	});
