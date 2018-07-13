<div class="module">
	<div class="moduleContent">
		<div>
			<h4>Nombre total d'opportunit&eacute; : <kbd>{{$store.getters.getActiveCount}}</kbd></h4>
			<div class="progress">
				<div class="progress-bar color-nue" role="progressbar" v-bind:style="'width:' + ($store.getters.getActiveNue.length / $store.getters.getActive.length * 100) + '%;'" aria-valuenow="30" aria-valuemin="30" aria-valuemax="70"><kbd>{{$store.getters.getActiveNue.length}}</kbd></div>
				<div class="progress-bar color-usu" role="progressbar" v-bind:style="'width:' + ($store.getters.getActiveUsu.length / $store.getters.getActive.length * 100)  + '%;'" aria-valuenow="15" aria-valuemin="30" aria-valuemax="70"><kbd>{{$store.getters.getActiveUsu.length}}</kbd></div>
			</div>
			<h4>Volume total: <kbd>{{parseFloat($store.getters.getVolumeTotal).toLocaleString("fr", {style: "currency", currency: "EUR"})}}</kbd></h4>
			<div class="progress">
				<div class="progress-bar color-nue" role="progressbar" v-bind:style="'width:' + (($store.getters.getVolumeNue / $store.getters.getVolumeTotal) * 100)  + '%;'" aria-valuenow="30" aria-valuemin="30" aria-valuemax="70"><kbd>{{parseFloat($store.getters.getVolumeNue).toLocaleString("fr", {style: "currency", currency: "EUR"})}}</kbd></div>
				<div class="progress-bar color-usu" role="progressbar" v-bind:style="'width:' + (($store.getters.getVolumeUsu / $store.getters.getVolumeTotal) * 100)  + '%;'" aria-valuenow="15" aria-valuemin="30" aria-valuemax="70"><kbd>{{parseFloat($store.getters.getVolumeUsu).toLocaleString("fr", {style: "currency", currency: "EUR"})}}</kbd></div>
			</div>
			<div class="legend">
				<ul class="list-unstyled">
					<li><span class="color-nue" style="border-radius: 50%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> - Nue Propriet&eacute;</li>
					<li><span class="color-usu" style="border-radius: 50%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> - Usufruit</li>
				</ul>
			</div>
			<div class="row">
				<hr>
			</div>
			<div class="row">
				<table class="table table-bordered table-responsive">
					<tr class="border-less">
						<td></td>
						<th>Nue Propriet&eacute;</th>
						<th>Usufruit</th>
						<th>Total</th>
					</tr>
					<tr>
						<th>Volume Finalis&eacute;:</th>
						<td v-bind:class="($store.getters.getVolumeNueFinal >= $store.getters.getVolumeUsuFinal) ? 'bg-info' : ''">{{parseFloat($store.getters.getVolumeNueFinal).toLocaleString("fr", {style: "currency", currency: "EUR"})}}</td>
						<td v-bind:class="($store.getters.getVolumeUsuFinal >= $store.getters.getVolumeNueFinal) ? 'bg-info' : ''">{{parseFloat($store.getters.getVolumeUsuFinal).toLocaleString("fr", {style: "currency", currency: "EUR"})}}</td>
						<td>{{parseFloat($store.getters.getVolumeFinal).toLocaleString("fr", {style: "currency", currency: "EUR"})}}</td>
					</tr>
					<tr>
						<th>Volume Non-Finalis&eacute;:</th>
						<td v-bind:class="($store.getters.getVolumeNueUnfinal >= $store.getters.getVolumeUsuUnfinal) ? 'bg-info' : ''">{{parseFloat($store.getters.getVolumeNueUnfinal).toLocaleString("fr", {style: "currency", currency: "EUR"})}}</td>
						<td v-bind:class="($store.getters.getVolumeUsuUnfinal >= $store.getters.getVolumeNueUnfinal) ? 'bg-info' : ''">{{parseFloat($store.getters.getVolumeUsuUnfinal).toLocaleString("fr", {style: "currency", currency: "EUR"})}}</td>
						<td>{{parseFloat($store.getters.getVolumeUnfinal).toLocaleString("fr", {style: "currency", currency: "EUR"})}}</td>
					</tr>
				</table>
			</div>
			<div class="row">
				<hr>
			</div>
			<?php
				$data = Opportunity::getInterest();
				$type_stat = Opportunity::getInterestType();
			?>
			<div class="row">
				<div class="col-lg-5 ">
					<table class="table table-bordered table-responsive">
						<tr>
							<th colspan="3">Panth&eacute;on des opportunit&eacute;s</th>
						</tr>
						<tr>
							<th>Classement</th>
							<th>Identifiant</th>
							<th>Nombre de clic</th>
						</tr>
						<tr v-for="(op, index) in $store.getters.getOpSortInt">
							<td v-bind:class="(index < 3) ? 'bg-info' : ''">{{index + 1}}</td>
							<td v-bind:class="(index < 3) ? 'bg-info' : ''">{{op.id}}</td>
							<td v-bind:class="(index < 3) ? 'bg-info' : ''">{{op.inter}}</td>
						</tr>
					</table>
				</div>
				<div class="col-lg-5 col-lg-offset-2">
					<table class="table table-bordered table-responsive">
						<tr>
							<th colspan="3">Podium des Types d'opportunit&eacute;</th>
						</tr>
						<tr>
							<th>Classement</th>
							<th>Identifiant</th>
							<th>Nombre de clic</th>
						</tr>
						<tr v-for="(line, index) in $store.getters.getInterOrder">
							<td v-bind:class="(index == 0) ? 'bg-info' : ''">{{index + 1}}</td>
							<td v-bind:class="(index == 0) ? 'bg-info' : ''">{{line.name}}</td>
							<td v-bind:class="(index == 0) ? 'bg-info' : ''">{{line.count}}</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
