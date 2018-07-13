</script>
<script type="text/x-template" id="coucou">
	<div>
		<div style="background-color:red;width:200px;height:200px;">
			
		</div>
		<input type="text" @change="emitData"/>
	</div>
</script>

<script type="text/x-template" id="componentTest">
	<div>
		<coucou @emmiter="showK"></coucou>
		coucou {{ dataTest }}
		<input type="text" v-model="dataTest" v-if="tmp==1"/>
		<select v-model="tmp">
			<option value="0">0</option>
			<option value="1">1</option>
			<option value="2">2</option>
		</select>
		<div v-for="elm in arr">
			{{ elm.id }} : {{ elm.name }}
		</div>
	</div>
</script>

<script type="text/javascript" charset="utf-8">
	Vue.component(
		'coucou',
		{
			data: function() {
				return ({
					dataTest: 'Hello !',
					tmp: 1
					}
				);
			},
			methods: {
				emitData: function(data) {
					if (data.target.value == "Mathieu")
						this.$emit('emmiter', "C'est okay");
				}
			},
			template: '#coucou'
		}
	);

</script>

<script type="text/javascript" charset="utf-8">
	Vue.component(
		'componentTest',
		{
			data: function() {
				return ({
					arr: [
						{
							id: 1,
							name: "Mathieu"
						},
						{
							id: 2,
							name: "Sébastien"
						}
					],
					dataTest: 'Hello !',
					tmp: 1
					}
				);
			},
			methods: {
				showK: function(data) {
					console.log("okay", data);
				}
			},
			template: '#componentTest'
		}
	);
