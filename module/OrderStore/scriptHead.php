</script>
<script type="text/javascript" charser="utf-8">
    store.registerModule('order', {
        state: {
            lst: <?= json_encode($this->orderlist) ?>
        },
        getters: {
            shortUrl: function (getters, state) {
                return (function (url){
                    var max = 48;
                    if (url.length > max){
                        url = url.substr(0, max - max / 4);
                        url += "...";
                    }
                    return (url);
                });

            },
            getBgError: function (getters, state) {
                return (function (errorNb, dis) {
                    errorNb = parseInt(errorNb);
                    dis = parseInt(dis);
                    if (dis == 1)
                        return("bg-danger");
                    if (errorNb >= 1 && errorNb < 2)
                        return ('bg-warning');
                    else if (errorNb != 0)
                        return ('bg-danger');

                });
            },
            getVolumeAchatFromScpiId: function (state, getters) {
                return (function (id) {
                    var ret = state.lst.filter(function (elm){
                        return (parseInt(elm.id_scpi) == parseInt(id))
                    });
                    var vol = 0.0;
                    for (i = 0; i < ret.length; i++)
                    {
                        if (parseInt(ret[i]['is_sell']) == 0)
                        vol += parseFloat(ret[i]['nb_part']) * parseFloat(ret[i]['price']);
                    }
                    return (parseFloat(vol));
                });
            },
            getVolumeVenteFromScpiId: function (state, getters) {
                return (function (id) {
                    var ret = state.lst.filter(function (elm){
                        return (parseInt(elm.id_scpi) == parseInt(id))
                    });
                    var vol = 0.0;
                    for (i = 0; i < ret.length; i++)
                    {
                        if (parseInt(ret[i]['is_sell']) == 1)
                        vol += parseFloat(ret[i]['nb_part']) * parseFloat(ret[i]['price']);
                    }
                    return (parseFloat(vol))
                });
            },
            getVolumeAchat: function (state, getters) {
                return (function () {
                    var ret = state.lst
                    var vol = 0.0;
                    for (i = 0; i < ret.length; i++)
                    {
                        if (parseInt(ret[i]['is_sell']) == 0)
                            vol += parseFloat(ret[i]['nb_part']) * parseFloat(ret[i]['price']);
                    }
                    //TODO: Add me here
                    var tmp = vol;
                    var tot = [];
                    var ret;
                    for (i = 1; i < state.lst.length; i++)
                    {
                        try
                        {
                            ret = getters.getHistFromId(i).achat;
                            vol = 0.0;
                            for (j = 0; j < ret.length - 1; j++)
                            {
                                vol += parseFloat(ret[j]['price']);
                            }
                            tot.push(parseFloat(parseFloat(vol).toFixed(2)));
                        }
                        catch (err)
                        {
                            ;
                        }
                    }
                    tot.push(tmp);
                    return (tot)
                });
            },
            getVolumeVente: function (state, getters) {
                return (function () {
                    var ret = state.lst
                    var vol = 0.0;
                    for (i = 0; i < ret.length; i++)
                    {
                        if (parseInt(ret[i]['is_sell']) == 1)
                            vol += parseFloat(ret[i]['nb_part']) * parseFloat(ret[i]['price']);
                    }
                    //TODO: Add me here
                    var tmp = vol;
                    var tot = [];
                    var ret;
                    for (i = 1; i < state.lst.length; i++)
                    {
                        try
                        {
                            ret = getters.getHistFromId(i).vente;
                            vol = 0.0;
                            for (j = 0; j < ret.length - 1; j++)
                            {
                                vol += parseFloat(ret[j]['price']);
                            }
                            tot.push(parseFloat(parseFloat(vol).toFixed(2)));
                        }
                        catch (err)
                        {
                            ;
                        }
                    }
                    tot.push(tmp);
                    return (tot)
                });
            },
			getHistoriqueFromId: function (state, getters) {
            	return (function(id) {
            		data = [];
            		var i = 0;
            		while (store.getters.getHistFromId(i) !== 0)
					{
						data.push(store.getters.getHistFromId(i));
						i++;
					}
            		console.log("Hey ! Please ! Don't punch me ! That hurt ! I'm a poor line of code !");
					return (data);
				});
			}
        }
    });

