</script>
<script type="text/javascript" charset="utf-8">
/*
Vue.filter('uc_first', function(value)
{
	var rt = '' + String(value.charAt(0)).toUpperCase()  + String(value.substr(1)).toLowerCase();
	return (rt);
});

Vue.filter(
	'upper',
	function(str) {
		return (String(str).toUpperCase());
	}
);

Vue.filter(
	'lower',
	function(str) {
		return (String(str).toLowerCase());
	}
);


Vue.filter(
	'time',
	function(n) {
		var  hour = parseInt((n - 1) / 4);
		if ((hour + '').length < 2)
			hour = '0' + hour;
		var minutes = (((n - 1) * 15) % 60);
		if ((minutes+ '').length < 2)
			minutes = '0' + minutes;
		return hour + ":" + minutes;
	}
);

Vue.filter(
	'tsDate',
	function(n) {
		if (n == 0)
			return ("-");
		return moment(n, "X").format("DD/MM/YYYY HH:mm:ss");
	}
);

Vue.filter(
	'tsDateStr',
	function(n) {
		if (n == 0 || n == null)
			return ("-");
		return moment(n, "X").format("ll");
	}
);
*/
Vue.filter('years', function(value)
{
	var val = Number(value);
	if (isNaN(val))
		return ('-');
	if (val > 1)
		return (val + " ans");
	else
		return (val + " an");
});
/*
Vue.filter('euros', function(value)
{
	var val = Number(value);
	if (isNaN(val))
		return ('-');
	return new Intl.NumberFormat("fr-FR", {style: "currency", currency: "EUR"}).format(val);
});

Vue.filter('pourcent', function(value)
{
	var val = Number(value);
	if (isNaN(val))
		return ('-');
	return Intl.NumberFormat("fr-FR", {style: "percent"}).format(val) + " %";
});

Vue.filter('date', function(value)
{
	if (value == 0)
		return ('-');
	return new Date(value * 1000).toLocaleDateString('fr-FR');
});
*/
moment.locale('fr');
