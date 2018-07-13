</script>
<script type="text/x-template" id="editAdequationTable">
	<div>
		<h1>Edit Adequation</h1>
		<table class="tableMscpi">
			<thead>
				<tr>
					<th style="width:420px;">SCPI</th>
					<th>Adequation</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="scpi in $store.getters.getAllScpi">
					<td>{{ scpi.name }}</td>
					<td>
						<textarea style="width:100%;min-height:100px;" v-model="scpi.adequation"></textarea>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</script>
<script type="text/javascript" charset="utf-8">
	Vue.component(
		'editAdequationTable',
		{
			template: "#editAdequationTable"
		}
	);
