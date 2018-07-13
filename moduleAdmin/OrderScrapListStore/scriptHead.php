</script>
<script type="text/javascript" charser="utf-8">
    store.registerModule('order_society', {
        state: {
            token: "<?=$_SESSION['csrf'][0]?>",
            lst: <?= json_encode($this->orderlist) ?>
        },
        mutations: {
            RESETERROR: function(state, el) {
                if (state.lst[el].error == 0)
                    return ;
                state.lst[el].error = 0;
                state.lst[el].changed = true;
            },
            SETCHANGED: function (state, el) {
                state.lst[el].disabled = !state.lst[el].disabled;
                state.lst[el].changed = true;
            },
            RESETBUTTON: function (state, el) {
                console.log("Going to update");
                state.lst[el].changed = false;
            }
        },
        actions : {
            UPDATELINE: function(context, data) {
                return (new Promise(function(resolve, reject) {
                var d = JSON.parse(JSON.stringify(context.state.lst[data]));
                    d['disabled'] = (d['disabled']) ? "0" : "1";
                    Vue.http.post('ajax_request.php',{
                            req: "OrderSet",
                            action: "update",
                            data: d,
                            token: context.state.token
                        },
                        {emulateJSON: true}
                    ).then(
                        function (res){
                            context.commit('RESETBUTTON', data);
                            d['disabled'] = (d['disabled'] === '0');
							swal(
								'Good Job!',
								'Les changements ont été effectué !',
								'success'
							);
                            resolve();
                        },
                        function (res) {
                            context.token = res.body.token;
							swal(
								'Oops...',
								'Une erreur s\'est produite !',
								'error'
							);
//                            if (typeof res.body.err !== 'undefined')
//                                msgBox.show(res.body.err);
//                            else
//                                msgBox.show("Une erreur s'est produite pendant le rechargement de la page. Essayer de rafraichir la page et de réessayer");
                            reject();
                        }
                    );
                }));
            }
        },
        getters: {
        	getUrlFromId: function (state, getters) {
        		return (function (id) {
					var url = "";
					for (var i = 0; i < state.lst.length; i++)
					{
						if (state.lst[i].id == id)
							url = state.lst[i].url;
					}
					return (url);
				});
			},
            getHistFromId: function(state, getters) {
                return (function (id) {
                    try {
                    	dbg(state.lst[parseInt(id)].hist);
                    	die();
                        return (state.lst[parseInt(id)].hist);
                    }
                    catch(err) {
                        return (0);
                    }
                });
            },
            getNameFromId: function(state, getters) {
                return (function (id) {
                    var name = "";
                    for (var i = 0; i < state.lst.length; i++)
                    {
                        if (state.lst[i].id == id)
                            name = state.lst[i].name;
                    }
                    return (name);
                });
            },
            getImgAchatFromId: function(state, getters) {
                return (function (id) {
                    var name = "";
                    for (var i = 0; i < state.lst.length; i++)
                    {
                        if (state.lst[i].id == id)
                            name = state.lst[i].img_a;
                    }
                    return ("data:image/png;base64," + name);
                });
            },
            getImgVenteFromId: function(state, getters) {
                return (function (id) {
                    var name = "";
                    for (var i = 0; i < state.lst.length; i++)
                    {
                        if (state.lst[i].id == id)
                            name = state.lst[i].img_v;
                    }
                    return ("data:image/png;base64," + name);
                });
            }
        }
    });