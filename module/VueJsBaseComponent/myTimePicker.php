</script>

<script type="text/x-template" id="myTimePickerTemplate">
	<my-select
		:value="value"
		@input="sendData($event)"
	>
		<option v-for="time in getList" :value="time.value" :selected="time.value == value">{{time.name}}</option>
	</my-select>
</script>

<script type="text/javascript" charset="utf-8">

Vue.component(
	'myTimePicker',
	{
		props: {
			value: {
				type: String,
				default: 0
			},
		},
		template: "#myTimePickerTemplate",
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

