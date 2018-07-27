</script>
<script type="text/x-template" id="inputEurosTemplate">
	<input type='text' :value='getData' @input='setData'  @change='sendChange'/>
</script>

<script type="text/x-template" id="inputPourcentTemplate">
	<input type='text' :value='getData' @input='setData'  @change='sendChange'/>
</script>

<script type="text/javascript" charset="utf-8">

var naiveReverse = function(string) {
	return ('' + string).split('').reverse().join('');
}
function unformatThousand(value) {
	value = String(value).replace(/€/g, '');
	value = String(value).replace(/,/g, '.');
	value = String(value).replace(/ */g, '');
	value = parseFloat(value);
	if (isNaN(value))
		return (null);
	return (value);
}

function unformatThousandPourcent(value) {
	value = String(value).replace(/%/g, '');
	value = String(value).replace(/,/g, '.');
	value = String(value).replace(/ */g, '');
	value = parseFloat(value);
	if (isNaN(value))
		return (null);
	return (value);
}

function formatThousand(valueIn, caracter) {
	if (typeof caracter == "undefined")
		caracter = '€';
	var value2 = String(valueIn).replace('.', ',');
	var value = unformatThousand(valueIn);

	if (value === null)
		return (' ' + caracter);

	value = parseFloat(value);
	value = Math.trunc(value * 100) / 100;

	var rt = '';
	var ent = Math.trunc(value);
	var decimal = Math.round((value - ent) * 100);

	if (isNaN(ent))
		ent = 0;
	if (isNaN(decimal))
		decimal = 0;

	ent = ('' + ent).split('').reverse();
	var nEnt = [];

	for (key in ent) {
		if (key != 0 && (key % 3) == 0)
			nEnt.push(' ');
		nEnt.push(ent[key]);
	}
	ent = nEnt.reverse().join('');
	rt = ent;

	if (('' + value2).search(', ') != -1)
		rt += ',';
	else if (('' + value2).search(',') != -1)
		rt += ',';

	if ((decimal / 10) != 0) {
		rt += ' ' + Math.trunc(decimal / 10);
		if ((decimal % 10) != 0) {
			rt += decimal % 10;
		}
	}
	return (rt + ' ' + caracter);
}

Vue.component(
	'input-euros',
	{
		data: function() {
			return ({ innerData: null, evt: null, startPos: 0, endPos: 0 });
		},
		props: [ 'value'],
		methods: {
			sendChange: function(elm) {
				this.$emit('change', unformatThousand(elm.target.value));
				this.$emit('input', unformatThousand(elm.target.value));
			},
			setData: function(evt) {
				var that = this;

				if (this.evt == null)
					this.evt = evt;
				this.startPos	= (this.evt.target.value.length - this.evt.target.selectionStart);
				if (this.startPos < 2)
					this.startPos = 2;

				var val = formatThousand(that.evt.target.value, '€');
				var tmp = ('' + val).split(',');
				if (typeof tmp[1] != 'undefined') {
					var str = '' + tmp[1];
					if (this.startPos < str.length && this.startPos != 0 && str.length > 0) {
						this.startPos--;
					}
				}
				var value = unformatThousand(formatThousand(that.evt.target.value))
				that.evt.target.value = formatThousand(this.evt.target.value,'€');

				setTimeout(function() {
					that.$emit('change', value);
					that.$emit('input', value);
				}, 50);
			}
		},
		computed: {
			getValue: function() {
				return (this.value);
			},
			getData: function() {
				var that = this;
				if (this.evt != null) {
					setTimeout(function() {
						var val = ('' + formatThousand(that.value, '€')).length;
						that.evt.target.setSelectionRange(
							val - that.startPos,
							val - that.startPos
						);
					}, 10);
				}
				return formatThousand(this.value, '€');
			}
		},
		template: "#inputEurosTemplate",
	}
);

Vue.component(
	'input-pourcent',
	{
		data: function() {
			return ({ innerData: null, evt: null, startPos: 0, endPos: 0 });
		},
		props: [ 'value'],
		methods: {
			sendChange: function(elm) {
				this.$emit('change', unformatThousand(elm.target.value));
				this.$emit('input', unformatThousand(elm.target.value));
			},
			setData: function(evt) {
				var that = this;

				if (this.evt == null)
					this.evt = evt;
				this.startPos	= (this.evt.target.value.length - this.evt.target.selectionStart);
				if (this.startPos < 2)
					this.startPos = 2;

				var val = formatThousand(that.evt.target.value, '%');
				var tmp = ('' + val).split(',');
				if (typeof tmp[1] != 'undefined') {
					var str = '' + tmp[1];
					if (this.startPos < str.length && this.startPos != 0 && str.length > 0) {
						this.startPos--;
					}
				}
				var value = unformatThousand(formatThousand(that.evt.target.value))
				that.evt.target.value = formatThousand(this.evt.target.value, '%');

				setTimeout(function() {
					that.$emit('change', value);
					that.$emit('input', value);
				}, 50);
			}
		},
		computed: {
			getValue: function() {
				return (this.value);
			},
			getData: function() {
				var that = this;
				if (this.evt != null) {
					setTimeout(function() {
						var val = ('' + formatThousand(that.value, '%')).length;
						that.evt.target.setSelectionRange(
							val - that.startPos,
							val - that.startPos
						);
					}, 10);
				}
				return formatThousand(this.value, '%');
			}
		},
		template: "#inputEurosTemplate",
	}
);
