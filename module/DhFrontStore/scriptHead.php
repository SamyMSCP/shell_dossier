</script>
<script type="text/javascript" charset="utf-8">
	store.registerModule('dh', {
		state: {
			Dh: <?= json_encode($this->dhStore)?>,
			Beneficiaires: <?= json_encode($this->Beneficiaires) ?>,
			precalcul: <?= json_encode($this->precalcul); ?>,
			actual: {},
			errorAdress: {},
			token: "<?=$_SESSION['csrf'][0]?>"
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
				console.log(state.actual);
			$('#modal_centreinteret').modal('show');
			},
			DH_RELOAD_PRECALCUL: function(state, data) {
				state.precalcul = data.precalcul;
			},
			UPDATE_TOKEN: function (state, token) {
				state.token = token;
			},
			PP_UPDATE_ADRESSE: function(state, data) {
				state.Dh.Pp.codePostal = data.code;
				state.Dh.Pp.ville = data.ville;
			},
			PP_SET_ADDRESS_ERROR: function(state, data) {
				state.errorAdress = data;
			},
			SET_ALL_CISCPI: function(state, data) {
				data.map(function(elm) {
					state.actual.ciscpi[elm.id_scpi] =  true;
				})
			},
			UNSET_ALL_CISCPI: function(state, data) {
				data.map(function(elm) {
					state.actual.ciscpi[elm.id_scpi] = false;
				})
			},
		},
		actions: {
 			TOGGLE_ALL_CISCPI: function(context)
			{
				if (context.getters.allCiIsChecked)
					context.commit("UNSET_ALL_CISCPI", context.getters.getCISCPI);
				else
					context.commit("SET_ALL_CISCPI", context.getters.getCISCPI);
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
			},
			DH_RELOAD_PRECALCUL: function(context, data) {
				return (new Promise(function(resolve, reject){
					Vue.http.post('ajax_request_client.php',
					{
						req: 'DhFrontStore',
						action: 'precalcul',
						data: data,
						token: "<?=$_SESSION['csrf'][0]?>"
					},
					{emulateJSON: true})
					.then(
						function (res) {
							context.commit("DH_RELOAD_PRECALCUL", res.body);
							resolve(res.body);
						},
						function (res) {
							reject();
						}
					)
				}))
			},
			PP_SAVE_ADRESSE_POSTALE: function(context, data) {
				return (new Promise(function(resolve, reject) {
					Vue.http.post(
						'ajax_request_client.php',
						{
							req: 'AjaxPp',
							action: 'saveAdressePostale',
							data: data,
							token: "<?=$_SESSION['csrf'][0]?>"
						},
						{emulateJSON: true}
					) .then(
						function (res) {
							// context.commit("DH_RELOAD_PRECALCUL", res.body);
							resolve(res.body);
						},
						function (res) {
							if (typeof res.body != "undefined" && typeof res.body.err != 'undefined')
							{
								context.commit("PP_SET_ADDRESS_ERROR", res.body.err);
							}
							else 
								msgBox.show("Une erreur est survenue !");
							reject();
						}
					)
				}))
			}
		},
		getters: {
			getCISCPI: function(state, getters)
			{
				return(
					state.Dh.scpi.filter(function(elm) {
						if (typeof getters.getScpi(elm.id_scpi) == "undefined")
							return false;
						return (true);
					})
				);
			},
			allCiIsChecked: function(state, getters)
			{
				return (
					getters.getCISCPI.every(function(elm) {
						return (getters.getActualCISCPI[elm.id_scpi]);
					})
				);
			},
			Token: function(state, getters) {
				return (state.token);
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
			getBeneficiaires: function(state, getters) {
				return state.Beneficiaires;
			},
			getPrecalculSCPIType: function(state, getters) {
				return (function(nom_scpi, type_pro) {
					if (typeof state.precalcul == 'undefined' || typeof type_pro == 'undefined' || typeof state.precalcul[nom_scpi] == 'undefined')
						return [];
					if (type_pro.substr(0,1).toLowerCase() == "p"
						&& typeof state.precalcul[nom_scpi]['Pleine'] != 'undefined')
							return state.precalcul[nom_scpi]['Pleine'];
					if (type_pro.substr(0,1).toLowerCase() == "u"
						&& typeof state.precalcul[nom_scpi]['Usu'] != 'undefined')
							return state.precalcul[nom_scpi]['Usu'];
					if (type_pro.substr(0,1).toLowerCase() == "n"
						&& typeof state.precalcul[nom_scpi]['Nue'] != 'undefined')
							return state.precalcul[nom_scpi]['Nue'];
					return [];
				})
			},
			getPersonnePhysique2: function(state, getters) {
				return (state.Dh.Pp);
			},
			getPersonnePhysiqueAdressError: function(state, getters) {
				return (state.errorAdress);
			}

		}
	})
