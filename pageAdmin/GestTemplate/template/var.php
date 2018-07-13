<div>
	<table class="table">
		<tr>
			<th>Nom</th>
			<th>Valeur</th>
			<th>Action</th>
		</tr>
		<tr v-for="(variable)in variables">
			<td>{{ variable.name }}</td>
			<td>{{ variable.content }}</td>
			<td></td>
		</tr>

	</table>
</div>