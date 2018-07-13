  <script type="text/javascript" charset="utf-8">

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
			//console.log(n);
			if (n == 0 || n == null)
				return ("-");
			return moment(n, "X").format("ll");
		}
	);

	Vue.filter('euros', function(value)
	{
		var val = Number(value);
		if (isNaN(val))
			return ('-');
		return new Intl.NumberFormat("fr-FR", {style: "currency", currency: "EUR"}).format(val);
	});

	Vue.filter('unprefix_scpi', function(value)
	{
		return value.substring(4);
	})

	Vue.filter('signed_euros', function(value)
	{
		var val = Number(value);
		if (isNaN(val))
			return ('-');
		if (val < 0)
			return Intl.NumberFormat("fr-FR", {style: "currency", currency: "EUR"}).format(val);
		return "+ " + Intl.NumberFormat("fr-FR", {style: "currency", currency: "EUR"}).format(val);
	});

	Vue.filter('signed_percent', function(value){
		var val = Number(value);
		if (isNaN(val))
			return "-";
		var is_negative = (val < 0) ? 1 : 0 ;
		val /= 100.0;
		if (is_negative)
			return Intl.NumberFormat("fr-FR", {style: "percent", minimumFractionDigits: 2, maximumFractionDigits: 2}).format(val);
		return "+ " + Intl.NumberFormat("fr-FR", {style: "percent", minimumFractionDigits: 2, maximumFractionDigits: 2}).format(val);
	})

Vue.filter('pourcent', function(value)
{
	var val = Number(value);
	if (isNaN(val))
		return ('-');
	val /= 100.0;
	return Intl.NumberFormat("fr-FR", {style: "percent", minimumFractionDigits: 2, maximumFractionDigits: 2}).format(val);
});

Vue.filter('shares', function(value)
{
	var val = Number(value);
	if (isNaN(val) || val == 0)
		return ('-');
	return Intl.NumberFormat("fr-FR", {maximumFractionDigits: 5}).format(val);
});

Vue.filter('shares_price_eur', function(value)
{
	var val = Number(value);
	if (isNaN(val) || val == 0)
		return ('-');
	return Intl.NumberFormat("fr-FR", {style: "currency", currency: "EUR", maximumFractionDigits: 5}).format(val);
});

Vue.filter('distribution_key', function(value)
{
	var val = Number(value);
	if (isNaN(val) || val == 0)
		return ('-');
	val /= 100.0;
	return Intl.NumberFormat("fr-FR", {style: 'percent', minimumFractionDigits: 2, maximumFractionDigits: 5}).format(val)
})
	Vue.filter('date', function(value)
	{
		if (isNaN(parseInt(value)) || parseInt(value) == 0)
			return ('-');
		return new Date(value * 1000).toLocaleDateString('fr-FR');
	});

	moment.locale('fr');
	Vue.component(
		'mySelect',
		{
			props: ['value', 'disabled'],
			template: `
				<div class="arrSelect">
					<select
						:value="value"
						@input="sendData($event)"
						:disabled="disabled"
					>
						<slot>
						</slot>
					</select>
				</div>
			`,
			methods: {
				sendData: function(e) {
					this.$emit('input', e.target.value);
				}
			},
		}
	);

	Vue.component(
		'myDatepicker',
	{
		props: {
				value: {
//					type: Number,
					default: 0
				},
				id : {
					type: String,
					default: "myDatePicker"
				}
			},
			template: `
				<input  :id="id" :value="getDateFormat" type="text" class="form-control" @change="$emit('change')" />
			`,
			computed: {
				getDateFormat:function () {
					if (this.value == 0)
						return ("-");
					return (moment(this.value, "X").format('DD/MM/YYYY'))
				}
			},
			mounted: function() {
				var that = this;
				$("#" + this.id).datepicker({
					onClose: function(e) {
						var newDate = moment(e, "DD/MM/YYYY")
						var rt = moment(that.value, "X");
						if (
							newDate.date() != rt.date() ||
							newDate.month() != rt.month() ||
							newDate.year() != rt.year()
						)
						{
							rt.set({
								date: newDate.date(),
								month: newDate.month(),
								year: newDate.year(),
								hour: 0,
								minute: 0,
								second: 0,
								millisecond: 0
							});
							that.$emit('change');
							that.$emit('input', parseInt(rt.clone().format("X")));
						}
					},
					dateFormat: 'dd/mm/yy',
					changeMonth: true,
					changeYear: true,
				})
			}
		}
	);

	Vue.component(
		'myTimePicker',
		{
			props: {
				value: {
//					type: Number,
					type: String,
					default: 0
				},
			},
			template: `
				<my-select
					:value="value"
					@input="sendData($event)"
				>
					<option v-for="time in getList" :value="time.value" :selected="time.value == value">{{time.name}}</option>
				</my-select>
			`,
			computed: {
				getList: function() {
					var tmp = moment(this.value, "X");
					tmp.set({
						hour: 0,
						minutes: 0,
						second: 0,
						millisecond: 0
					});
					var i = 0;
					var rt = [];
					while (i < 96)
					{
						rt.push({
							value: tmp.format("X"),
							name: tmp.format("HH:mm"),
						})
						tmp.add({minute: 15});
						i++;
					}
					return (rt);
				}
			},
			methods: {
				sendData: function(e) {
					this.$emit('input', e);
				},
			}
		}
	);

</script>
