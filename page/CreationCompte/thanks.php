<?php
include ("objRotation.php");
?>

<div class="paragraphe par1">

	<h2>Analyse de vos informations...</h2>

	<div class="traitOrange"></div>

	<br />
	<div class="row">
		<div class='uil-reload-css' style='-webkit-transform:scale(1); margin-left:auto; margin-right:auto;'>
			<div></div>
		</div>
	</div>

	<h4 >Avertissement lié à la durée de l'investissement : </h4>
	<p >Les parts de SCPI sont des supports de placement à long terme,
	minimum 8 années pour les SCPI de rendement et 15 ans pour les SCPI fiscales.</p>
	<h4 >Avertissement lié au marché immobilier : </h4>
	<p >comme tout investissement, l’immobilier présente des risques: risques de gestion discrétionnaire, de contrepartie (locataire,...), d’absence de rendement ou de perte de valeur, qui peuvent
	toutefois être atténués par la diversification immobilière et locative du portefeuille de la SCPI.</p>
	<h4>Avertissement lié à perte en capital : </h4>
	<p >la SCPI comporte un risque de perte en capital et le montant du capital investi
	n’est pas garanti.</p>
	<h4>Avertissement lié à la liquidité : </h4>
	<p >la SCPI n’étant pas un produit coté, elle présente une liquidité moindre comparée aux
	actifs financiers, et la revente des parts n’est pas garantie par la SCPI. Les conditions de cession (délais, prix) peuvent
	ainsi varier en fonction de l’évolution du marché de l’immobilier et du marché des parts de SCPI.
	Avertissement lié au crédit : l’attention du souscripteur est également attirée sur le fait que la SCPI peut recourir à
	l’endettement dans les conditions précisées dans sa note d’information.</p>

</div>

<div class="paragraphe par2" style="margin-bottom: 18px;">
	<div class="row">

		<div class="col-md-6">
			<h2 style="font-size: 60px;">
				MERCI !
			</h2>
			<p style="text-align:center; font-size:20px;">Votre compte a bien été créé.</p>
		</div>
		<div class="col-md-6">
			<p style="font-size:36px;">C'est ici que<br>commence votre<br>épargne immobilière.</>
		</div>

	</div>
	<br />
	<a href="?p=Portefeuille">
		<button
			class="btn-mscpi btn-orange"
			style="display:block;margin-left:auto;margin-right:auto;"
		>
			CONNEXION À MON COMPTE
		</button>
	</a>

</div>

<script type="text/javascript" charset="utf-8">
	ProgressBlockMove(1);

	$(document).ready(function(){
		$inter = setInterval(function(){
			$('.par1').fadeOut(1000,function() {
				$('.par2').fadeIn(1000);
				ProgressBlockMove(2.1);
			});
		/*
		if ($(".checkboxes-0").is(':checked') || $(".checkboxes-1").is(':checked')){
			$(".alert_info").css("visibility", "hidden");
			$(".line_red").css("border-right", "1px solid white");
		} else {
			$(".alert_info").css("visibility", "visible");
			$(".line_red").css("border-right", "1px solid #FF0000");
		}
		*/
		}, 1500);
	});
</script>
