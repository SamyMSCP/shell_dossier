<?php
/**
 * Created by PhpStorm.
 * User: vthomas
 * Date: 15/02/2018
 * Time: 14:06
 */
?>
<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
	<div class="opportunite">
		<div class="header">
			<div class="title" v-bind:class="type">
				{{type}} de la SCPI<br>
				<span class="scpi-name">{{scpi}}</span>
			</div>
		</div>
		<div class="content text-center">
			<div class="row">
				<div class="col-lg-6">
					<span class="text-uppercase main-info-label">dur&eacute;e</span><br/>
					<span class="main-info">{{duree}} Ans</span>
				</div>
				<div class="col-lg-6">
					<span class="text-uppercase main-info-label">Cl&eacute; de partage</span><br/>
					<span class="main-info">{{keyNue}}%</span>
				</div>
			</div>
			<div class="main-content">
				<div class="row">
					<div class=" col-lg-12 separator"></div>
				</div>
				<div class="row">
					<div class="col-lg-6 text-right second-info">Montant de la nue propriet&eacute;</div>
					<div class="col-lg-6 text-center second-value">{{tot}} &euro;</div>
				</div>
				<div class="row">
					<div class=" col-lg-12 separator"></div>
				</div>
				<div class="row">
					<div class="col-lg-6 text-right second-info">Nombre de parts</div>
					<div class="col-lg-6 text-center second-value">{{parts}}</div>
				</div>
				<div class="row">
					<div class=" col-lg-12 separator"></div>
				</div>
				<div class="row">
					<div class="col-lg-6 text-right second-info">Prix de la part en nue propri&eacute;t&eacute;</div>
					<div class="col-lg-6 text-center second-value">{{pricePart}}</div>
				</div>
				<div class="row">
					<div class=" col-lg-12 separator"></div>
				</div>
				<div class="row">
					<div class="col-lg-6 text-right second-info">Souscription divisible</div>
					<div class="col-lg-6 text-center second-value">{{partiel}}</div>
				</div>
				<div class="row">
					<div class=" col-lg-12 separator"></div>
				</div>
			</div>
			<span class="btn text-uppercase btn-interest" @click="sendInterest(id)">cette opportunit&eacute; m'int&eacute;resse</span>
			<div class="row">

			</div>
		</div>
	</div>
</div>
