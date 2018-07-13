</script>
<script type="text/javascript" charset="utf-8">
	store.registerModule('opportunite', {
		state: {
			lst: <?= json_encode($this->lstOpportunite) ?>,
			<?php
			/*
			currentPage: 0,
			scpiFilter: 0,
			dureeFilter: 0,
			typeFilter: 0,
			nbrPages: 0,
			*/
			?>
			validatedFilter: 1,
			idFilter: 0,
			partFilter: 0,
			scpiFilter: 0,
			volNuFilter: 0,
			volUsuFilter: 0,
			validatedFilter: 0,
			ouvertFilter: true,
			saisirFilter: true,
			closeOkFilter: false,
			closeNotOkFilter: false,
			demFilter: 0,
			stateFilter: 0,
			selected: {},
			token: "<?=$_SESSION['csrf'][0]?>"
		},
		mutations: {
			SET_OPPORTUNITE_STATE: function(state, data) {
				state.stateFilter = data;
			},
			SET_OPPORTUNITE: function(state, data) {
				state.selected = JSON.parse(JSON.stringify(data));
				//state.selected = data;
			},
			NEW_OPPORTUNITE: function(state, data) {
				state.selected = {
					id: 0,
					type: 0,
					id_scpi: 0,
					time_demembrement: 3,
					price_per_part: 0,
					key_nue: 99,
					nb_part: 1,
					date: Math.round(new Date().getTime()/1000),
					state: 0,
					partial_subscrib: 1,
					id_author: data.id_dh,
					validated: 1,
					notif_client: 0
				}
			},
			UPDATE_OPPORTUNITY: function(state, data) {
				state.lst = data.lst;
			},
			OPPORTUNITY_SORT_BY_ID(state, payload) {
				var list = (state.lst);
				if (payload.type == 0)
					list.sort(function (a, b) { return (parseInt(a.id) > parseInt(b.id)); });
				else
					list.sort(function (a, b) { return (parseInt(a.id) < parseInt(b.id)); });
				state.lst = list;
				state.idFilter = payload.type;
			},
			OPPORTUNITY_SORT_BY_NBPART(state, payload) {
				var list = (state.lst);
				if (payload.type == 0)
					list.sort(function (a, b) { return (parseInt(a.nb_part) > parseInt(b.nb_part)); });
				else
					list.sort(function (a, b) { return (parseInt(a.nb_part) < parseInt(b.nb_part)); });
				state.lst = list;
				state.partFilter = payload.type;
			},
			OPPORTUNITY_SORT_BY_SCPI(state, payload) {
				var list = (state.lst);
				//$store.getters.getScpi(line.id_scpi).name
				if (payload.type == 0)
					list.sort(function (a, b) { return (store.getters.getScpi(a.id_scpi).name > store.getters.getScpi(b.id_scpi).name); });
				else
					list.sort(function (a, b) { return (store.getters.getScpi(a.id_scpi).name < store.getters.getScpi(b.id_scpi).name); });
				state.lst = list;
				state.scpiFilter = payload.type;
			},

			OPPORTUNITY_SORT_BY_VOLNU(state, payload) {
				var list = (state.lst);
				if (payload.type == 0)
					list.sort(function (a, b) { return (parseFloat(((a.nb_part * a.price_per_part * (a.key_nue / 100.0)).toFixed(2))) > parseFloat(((b.nb_part * b.price_per_part * (b.key_nue / 100.0)).toFixed(2)))); });
				else
					list.sort(function (a, b) { return (parseFloat(((a.nb_part * a.price_per_part * (a.key_nue / 100.0)).toFixed(2))) < parseFloat(((b.nb_part * b.price_per_part * (b.key_nue / 100.0)).toFixed(2)))); });
				state.lst = list;
				state.volNuFilter = payload.type;
			},
			OPPORTUNITY_SORT_BY_VOLUSU(state, payload) {
				var list = (state.lst);
				if (payload.type == 0)
					list.sort(function (a, b) { return (parseFloat((a.nb_part * a.price_per_part * ((100.0 - a.key_nue) / 100.0)).toFixed(2)) > parseFloat((b.nb_part * b.price_per_part * ((100.0 - b.key_nue) / 100.0)).toFixed(2))); });
				else
					list.sort(function (a, b) { return (parseFloat((a.nb_part * a.price_per_part * ((100.0 - a.key_nue) / 100.0)).toFixed(2)) < parseFloat((b.nb_part * b.price_per_part * ((100.0 - b.key_nue) / 100.0)).toFixed(2))); });
				state.lst = list;
				state.volUsuFilter = payload.type;
			},
			OPPORTUNITY_SORT_BY_VALIDE(state, payload) {
				var list = (state.lst);
				if (payload.type == 0)
					list.sort(function (a, b) { return (parseInt(a.validated) > parseInt(b.validated)); });
				else
					list.sort(function (a, b) { return (parseInt(a.validated) < parseInt(b.validated)); });
				state.lst = list;
				state.validatedFilter = payload.type;
			},
			OPPORTUNITY_SORT_BY_DEM(state, payload) {
				var list = (state.lst);
				if (payload.type == 0)
					list.sort(function (a, b) { return (parseInt(a.time_demembrement) > parseInt(b.time_demembrement)); });
				else
					list.sort(function (a, b) { return (parseInt(a.time_demembrement) < parseInt(b.time_demembrement)); });
				state.lst = list;
				state.demFilter = payload.type;
			},
			OPPORTUNITY_SORT_BY_STATE(state, payload) {
				switch (payload.type){
					case 1:
						state.ouvertFilter = !state.ouvertFilter;
						break;
					case 2:
						state.saisirFilter = !state.saisirFilter;
						break;
					case 3:
						state.closeOkFilter = !state.closeOkFilter;
						break;
					case 4:return (new Promise(function(resolve, reject) {
                        Vue.http.post('ajax_request.php',{
                                req: "OpportunitySet",
                                action: "reload",
                                data: data,
                                token: context.state.token
                            },
                            {emulateJSON: true}
                        ).then(
                            function (res){
                                //console.log(res.body);
                                context.commit("UPDATE_OPPORTUNITY", res.body);
                                //context.opportunite.lst = res.body.lst;
                                resolve();
                            },
                            function (res) {
                                context.token = res.body.token;
                                if (typeof res.body.err != 'undefined')
                                    msgBox.show(res.body.err);
                                else
                                    msgBox.show("Une erreur s'est produite pendant le rechargement de la page. Essayer de rafraichir la page et de réessayer");
                                reject();
                            }
                        );
                    }))
						state.closeNotOkFilter = !state.closeNotOkFilter;
						break;
				}
			}
		},
		actions: {
			RELOAD_OPPORTUNITY: function(context, data) {
				return (new Promise(function(resolve, reject) {
					Vue.http.post('ajax_request.php',{
							req: "OpportunitySet",
							action: "reload",
							data: data,
							token: context.state.token
						},
						{emulateJSON: true}
					).then(
						function (res){
							//console.log(res.body);
							context.commit("UPDATE_OPPORTUNITY", res.body);
							//context.opportunite.lst = res.body.lst;
							resolve();
						},
						function (res) {
							context.token = res.body.token;
							if (typeof res.body.err != 'undefined')
								msgBox.show(res.body.err);
							else
								msgBox.show("Une erreur s'est produite pendant le rechargement de la page. Essayer de rafraichir la page et de réessayer");
							reject();
						}
					);
				}))
			},
			OPPORTUNITY_SAVE: function(context, data) {
				return (new Promise(function(resolve, reject) {
					if (data['id_author'] == undefined)
						data['id_author'] = <?=isset($GLOBALS['GET']['client']) ? $GLOBALS['GET']['client'] : Dh::getCurrent()->id_dh?>;
					Vue.http.post('ajax_request.php',{
							req: "OpportunitySet",
							action: "save",
							data: data,
							token: context.state.token
						},
						{emulateJSON: true}
					).then(
						function (res){
							context.dispatch('RELOAD_OPPORTUNITY');
							resolve();
						},
						function (res) {
							context.token = res.body.token;
							if (typeof res.body.err != 'undefined')
								msgBox.show(res.body.err);
							else
								msgBox.show("Une erreur s'est produite. Essayer de rafraichir la page et de réessayer");
								reject();
						}
					);
				}))
			}
		},
		getters: {
			getFilteredOpportunite: function(state, getters) {
				return (state.lst.filter(function(elm) {
					<?php if (isset($GLOBALS['GET']['client'])) { ?>
						if (getters.getDh.id != elm.id_author)
							return (false);
					<?php } ?>
					if (state.stateFilter == 0 && elm.state >= 2)
						return (false);
					if (state.stateFilter == 1 && elm.state < 2)
						return (false);
					return (true);
				}));
			},
			getActive: function (state, getters) {
				return (state.lst.filter(function (elm) {
					return (elm.validated == 1 && elm.state <= 1);
				}));
			},
			getFinal: function (state, getters) {
				return (state.lst.filter(function (elm) {
					return (elm.validated == 1 && elm.state == 2);
				}));
			},
			getUnfinal: function (state, getters) {
				return (state.lst.filter(function (elm) {
					return (elm.validated == 1 && elm.state == 3);
				}));
			},
			getActiveCount: function (state, getters) {
				return (getters.getActive.length);
			},
			getActiveNue: function (state, getters) {
				return (state.lst.filter(function (elm) {
					return (elm.validated == 1 && elm.state <= 1 && elm.type == 0);
				}));
			},
			getActiveUsu: function (state, getters) {
				return (state.lst.filter(function (elm) {
					return (elm.validated == 1 && elm.state <= 1 && elm.type == 1);
				}));
			},
			getVolumeTotal: function (state, getters) {
				var op = getters.getActive;
				var vol = 0.0;
				for (var i = 0; i < op.length; i++)
				{
					if (op[i].type == 0)
						vol += op[i].nb_part * op[i].price_per_part * (op[i].key_nue / 100);
					else
						vol += op[i].nb_part * op[i].price_per_part * ((100.0 - op[i].key_nue) / 100);
				}
				return (vol.toFixed(2));
			},
			getVolumeUsu: function (state, getters) {
				var op = getters.getActiveUsu;
				var vol = 0.0;
				for (var i = 0; i < op.length; i++)
				{
					vol += op[i].nb_part * op[i].price_per_part * ((100.0 - op[i].key_nue) / 100);
				}
				return (vol.toFixed(2));
			},
			getVolumeNue: function (state, getters) {
				var op = getters.getActiveNue;
				var vol = 0.0;
				for (var i = 0; i < op.length; i++)
				{
					vol += op[i].nb_part * op[i].price_per_part * (op[i].key_nue / 100);
				}
				return (vol.toFixed(2));
			},
			getVolumeFinal: function (state, getters) {
				var op = getters.getFinal;
				var vol = 0.0;
				for (var i = 0; i < op.length; i++)
				{
					if (op[i].type == 0)
						vol += op[i].nb_part * op[i].price_per_part * (op[i].key_nue / 100);
					else
						vol += op[i].nb_part * op[i].price_per_part * ((100.0 - op[i].key_nue) / 100);
				}
				return (vol.toFixed(2));
			},
			getVolumeNueFinal: function (state, getters) {
				var op = getters.getFinal;
				var vol = 0.0;
				for (var i = 0; i < op.length; i++)
				{
					if (op[i].type == 0)
						vol += op[i].nb_part * op[i].price_per_part * (op[i].key_nue / 100);
				}
				return (vol.toFixed(2));
			},
			getVolumeUsuFinal: function (state, getters) {
				var op = getters.getFinal;
				var vol = 0.0;
				for (var i = 0; i < op.length; i++)
				{
					if (op[i].type == 1)
						vol += op[i].nb_part * op[i].price_per_part * ((100.0 - op[i].key_nue) / 100);
				}
				return (vol.toFixed(2));
			},
			getVolumeUnfinal: function (state, getters) {
				var op = getters.getUnfinal;
				var vol = 0.0;
				for (var i = 0; i < op.length; i++)
				{
					if (op[i].type == 0)
						vol += op[i].nb_part * op[i].price_per_part * (op[i].key_nue / 100);
					else
						vol += op[i].nb_part * op[i].price_per_part * ((100.0 - op[i].key_nue) / 100);
				}
				return (vol.toFixed(2));
			},
			getVolumeNueUnfinal: function (state, getters) {
				var op = getters.getUnfinal;
				var vol = 0.0;
				for (var i = 0; i < op.length; i++)
				{
					if (op[i].type == 1)
						vol += op[i].nb_part * op[i].price_per_part * (op[i].key_nue / 100);
				}
				return (vol.toFixed(2));
			},
			getVolumeUsuUnfinal: function (state, getters) {
				var op = getters.getUnfinal;
				var vol = 0.0;
				for (var i = 0; i < op.length; i++)
				{
					if (op[i].type == 0)
						vol += op[i].nb_part * op[i].price_per_part * ((100.0 - op[i].key_nue) / 100);
				}
				return (vol.toFixed(2));
			},
			getOpSortInt: function (state, getters) {
				var list = (state.lst.filter(function (elm) { return (elm.inter > 0); } ));
				list.sort(function (b, a) {
					return (a.inter - b.inter);
				});
				list = list.slice(0, 10);
				return (list);
			},
			getInterOrder: function (state, getters) {
				var list = getters.getOpSortInt;
				var inter_usu = 0;
				var inter_nue = 0;
				for (var i = 0; i < list.length; i++)
				{
					if (list[i].type == 0)
						inter_nue += parseInt(list[i].inter);
					else
						inter_usu += parseInt(list[i].inter);
				}
				return ([{
					name: "Nue Propriété",
					count: inter_nue
				},{
					name: "Usufruit",
					count: inter_usu
				}].sort(function (b, a) {return (a.count - b.count);}));
			},
			getListWithStateFilter: function (state, getters) {
				return (state.lst.filter(function(elm) {
					if (state.ouvertFilter && parseInt(elm.state) == 0)
						return (true);
					else if (state.saisirFilter && parseInt(elm.state) == 1)
						return (true);
					else if (state.closeOkFilter && parseInt(elm.state) == 2)
						return (true);
					else if (state.closeNotOkFilter && parseInt(elm.state) == 3)
						return (true);
					return (false);
				}));
			}
		}
	});
