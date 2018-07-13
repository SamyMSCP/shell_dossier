<div class="blockSituation block2">
	<div class="titleBlockSituation">
		SIGNATURE DE LA LETTRE DE MISSION
	</div>
	<div class="contentBlockSituation">
		<div class="contenuOut">
			<div class="contenu" style="text-align:center;">
				<p class="txtLm">
				<?php
				/*
					La lettre de mission et le questionnaire client sont des documents légaux imposés par l’Autorité des Marchés Financiers avant tout conseil, qui n’engagent pas nos clients. <br />
					Vous pouvez donc arrêter notre mission de conseil à tout moment. <br /><br />
					L’objectif de ce questionnaire client est de détenir des informations précises sur votre situation juridique, fiscale, patrimoniale ainsi que vos connaissances client et votre profil d’investisseur, afin de vous fournir une suggestion de SCPI.
					*/
					?>
					Avant de vous formuler nos conseils, Meilleurscpi.com vous soumet une lettre de mission vous permettant de comprendre :
				</p>
				<ul>
					<li>
						Qui nous sommes,
					</li>
					<li>
						la nature et les modalités de notre prestation,
					</li>
					<li>
						les conditions de notre rémunération.
					</li>
				</ul>
				<p style="margin-top: 20px;margin-bottom: 30px;">
					Vous allez être redirigé(e) vers le site Universign pour signer votre lettre de mission !
				</p>
				<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
				<input type="hidden" name="action" id="action" value="wantSign"/>
				<button id="BtnSignLm" type="submit">Signer le document</button>
			</div>
		</div>
	</div>
</div>
