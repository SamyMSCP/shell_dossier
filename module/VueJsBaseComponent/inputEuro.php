</script>

<script type="text/x-template" id="inputEuroTemplate">
	<div class="inputEuroStyle" >
		<input type="number" min="0" placeholder="-" :value="value"  @input="updateValue($event.target.value)" /> €
	</div>
</script>

<style type="text/css" media="all">
	.inputEuroStyle {
		position: relative;
	}
	.inputEuroStyle > span  {
		color: red !important;
		width:100%;
		height:100%;
	}
	.inputEuroStyle > input {
		color: transparent !important;
		border:none;
		width:100%;
		height:100%;
		color: transparent !important;
		position: absolute;
	}
</style>

<script type="text/javascript" charset="utf-8">

Vue.component(
	'inputEuro',
	{
		props: {
			value: {
//				type: Number,
				default: 0
			}
		},
		methods: {
			updateValue: function(value) {
				this.value = value;
			}
		},
		template: "#inputEuroTemplate"
	}
);


