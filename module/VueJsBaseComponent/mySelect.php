</script>

<script type="text/x-template" id="mySelectTemplate">
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
</script>

<script type="text/javascript" charset="utf-8">

Vue.component(
	'mySelect',
	{
		props: ['value', 'disabled'],
		template: "#mySelectTemplate",
		methods: {
			sendData: function(e) {
				this.$emit('input', e.target.value);
			}
		},
	}
);
