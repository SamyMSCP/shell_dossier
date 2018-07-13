</script>
<script type="text/x-template" id="SimpleFormulaire">
	<div class="SimpleFormulaire">
		<div v-for="(data, key) in datas">
			<div>
				{{ key }}
			</div>
			<div>
				<input type="text" v-model="datas[key]" />
			</div>
		</div>
	</div>
</script>

<script type="text/javascript" charset="utf-8">
	Vue.component(
		'SimpleFormulaire',
		{
			props: {
				datas: {
					default: {}
				}
			},
			template: "#SimpleFormulaire"
		}
	);
