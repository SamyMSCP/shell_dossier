<div class="navBarOut">
	<div class="navBarBlueBar">
	</div>
	<div class="navBar">
		<a class="pull-left" href="admin_lkje5sjwjpzkhdl42mscpi.php?p=Accueil">
			<img class="navLogo" src="<?= $this->getpath() ?>img/logo-meilleurescpi.png" alt="logo">
		</a>
		<div class="row navMenu">
			<div class="col-lg-3">
				<a href="?p=Accueil">ACCUEIL</a>
			</div>
			<div class="col-lg-6" id="getSizeNotif" onclick="window.open('?p=NotificationsCrm', '_blank');">
				<a style="cursor: pointer;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">NOTIFICATIONS
					<div class="circleOrange"><?= $this->NbrNorification ?></div>
				</a>
				<ul class="dropdown-menu notification" style="left: inherit; right: 0px;" id="setSizeHiddenNotif">
					<?php
					foreach ($this->myNotifications as $key => $elm) {
						?>
						<li>
							<a href="?p=EditionClient&client=<?= $elm->id_client ?>&onglet=SUIVI&id_crm=<?= $elm->id ?>"
							   target="_blank">
								<h5 style="text-align: left;">
									 <?php if($elm->getClient() != null){
									echo	$elm->getClient()->getShortName();
										}
									 ?>
								</h5>
								<?= substr(strip_tags($elm->getCommentaire()), 0, 45) ?>...
								<br/>
								<div class="dateNotif" style="text-align:right">
									<?= $elm->getDateExecutionDateTime()->format("d/m/Y H:i") ?>
								</div>
							</a>
							<hr style="margin-top:0px; margin-bottom:0px;"/>
						</li>
						<?php
					}
					/*
						foreach($help as $val){
							$pp = Dh::getById($val->id_dh)->getPersonnePhysique();
							?><li style="cursor: pointer;">
							<?php echo '<a href="?p=EditionClient&client=' . $val->id_dh . '&onglet=SUIVI">';
									echo '<h5 style="text-align: left;"><i class="actionNotif">Demande de contact par </i>' . $pp->getCiviliteFormat() . " " . $pp->getFirstName() . " " . $pp->getName() . '</h5>';
						?>
							<div class="positionTraitNotif">
								<div class="traitNotif"></div>
							</div>
							</li>
							<?php
						}
						foreach ($this->myNotifications as $key => $elm) {
							?>
							<li>
								<a href="?p=NotifPage&notif_id=<?=$elm->id?>">
									<h5 style="text-align: left;">
											<?=$elm->getTitle()?>
									</h5>
									<?=substr(strip_tags($elm->getContent()), 0, 45)?>...
									<br />
									<div class="dateNotif" style="text-align:right">
										<?=$elm->getDateCreation()->format("d/m/Y H:i")?>
									</div>
								</a>
								<hr style="margin-top:0px; margin-bottom:0px;"/>
							</li>
							<?php
						}
						foreach ($this->myCompleteNotifications as $key => $elm) {
							?>
							<li style="background-color:#d4e3ec;">
								<a href="?p=NotifPage&notif_id=<?=$elm->id?>">
									<h5 style="text-align: left;">
											<?=$elm->getTitle()?>
									</h5>
									<?=substr(strip_tags($elm->getContent()), 0, 45)?>...
									<br />
									<div class="dateNotif" style="text-align:right">
										<?=$elm->getDateCreation()->format("d/m/Y H:i")?>
									</div>
								</a>
								<hr style="margin-top:0px; margin-bottom:0px;"/>
							</li>
							<?php
						}
						*/
					/*
					foreach($tab as $val){
						$pp = Dh::getById($val->id_dh)->getPersonnePhysique();
						?><li style="cursor: pointer;">
						<?php echo '<a href="?p=EditionClient&client=' . $val->id_dh . '&onglet=SUIVI">';
								echo '<h5 style="text-align: left;"><i class="actionNotif">' . htmlspecialchars(ft_decrypt_crypt_information($val->action_r)) . ' à </i>' . $pp->getCiviliteFormat() . " " . $pp->getFirstName() .  " " . $pp->getName() . '</h5>';
								echo "<span class=\"dateNotif\">Le " . date("d M Y à H:i", $val->DATE_f) . '</span></a>';?>
						<div class="positionTraitNotif">
							<div class="traitNotif"></div>
						</div>
						</li>
						<?php
					}
					*/
					?>
					<?php
					/*
					<li><hr /></li>
					<li style="cursor: pointer;"><a href="?p=AbsorptionPage"><h4>List des Scpi Absorbees<br>non completees </h4><br /><?php
					foreach ($this->AbsorptionNotif as $key => $elm)
					{
						?>
						<?=Scpi::getFromId($elm->id_scpi_absorbed)->name?><br />
						<?php
					}
					?></a></li>
					*/
					?>
				</ul>
			</div>
			<?php

			if (in_array("AbsorptionPage", $GLOBALS['accesCollaborateurs']) || in_array("AbsorptionPage", $GLOBALS["acces" . UcFirst($this->collaborateur->getType())])) {
				?>
				<div class="col-lg-3">
					<a href="?p=StatGeneral">STATS</a>
				</div>
				<?php
			}

			?>
		</div>
		<div class="navSearch">
			<input class="navSearchInput dropdown-toggle" data-toggle="dropdown" aria-expanded="true" type="text"
				   name="searchBar" id="searchBar" value="" placeholder="RECHERCHER LE NOM D'UN CLIENT"/>
			<ul class="dropdown-menu notification" id="setSizeHiddenSearch" style="left: inherit; left: 0px;">
				<li style="cursor: pointer;"><a href="?p=Accueil">None</a></li>
			</ul>
			<img class="navLoupe" src="<?= $this->getPath() ?>img/Loupe-bleu.png"
				 alt="Loupe bleu de la barre de recherche"/>
		</div>
		<div class="navCollaborateur" id="getSizeName">
			<span class="dropdown-toggle text-uppercase" data-toggle="dropdown"
				  aria-expanded="true"><?= $this->collaborateur->getPersonnePhysique()->getShortName() ?></span>
			<img class="navFlechBas dropdown-toggle" data-toggle="dropdown" aria-expanded="true"
				 src="<?= $this->getPath() ?>img/FlecheBas-blanc.png" alt="Fleche bas du nom du collaborateur"/>
			<ul class="dropdown-menu" style="left: inherit; right: 0px;" id="setSizeHiddenMenu">
				<?php include("content.php") ?>
			</ul>
		</div>
		<div class="navAdd">
			<button data-toggle="modal" data-target="#addClientModal">AJOUTER UN CLIENT</button>
		</div>
	</div>
</div>


<div class="modal fade" id="addClientModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-backdrop fade in"></div>
	<div class="modal-dialog">
		<div class="modal-content" style="min-width: 850px;background-color: #EBEBEB;">
			<div class="modal-body">
				<div data-dismiss="modal" aria-label="Close" class="btn_close_prepapre">
					<span aria-hidden="true" class="btn_close">×</span></div>
				<h4 style="text-align: center;font-size:20px;">AJOUTER UN CLIENT MANUELLEMENT</h4>
				<div class="traitOrange" style="margin-top: 20px;margin-bottom: 20px;"></div>
				<p style="font-size: 16px; text-align: center; color: grey;">Création de compte Meilleurescpi.com</p>
				<div class="row" style="margin-top: 30px;">
					<form class="form-horizontal" method="post" id="addClientForm">
						<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
						<fieldset>

							<!-- Form Name -->

							<?php
							if ($this->collaborateur->type == "conseiller") {
								?>
								<input type="hidden" name="conseiller_id" value="<?= $this->collaborateur->id_dh ?>"/>
								<?php
							} elseif ($this->collaborateur->type == "yoda" || $this->collaborateur->type == "backoffice" || $this->collaborateur->type == "assistant" || $this->collaborateur->type == "prospecteur") {
								?>
								<div class="form-group">
									<label class="col-md-4 control-label" for="selectconseiller">Conseiller</label>
									<div class="col-md-4">
										<select id="selectconseiller" name="conseiller_id" class="form-control">
											<?php
											//if ($this->collaborateur->type == "yoda" || $this->collaborateur->type == "backoffice")
											{
												foreach (Dh::getConseillers() as $elm) {
													echo '<option value="' . $elm->id_dh . '">' . $elm->getPersonnePhysique()->getFirstName() . " " . $elm->getPersonnePhysique()->getName() . '</option>';
												}
											}
											?>
										</select>
									</div>
								</div>
								<?php
							}
							?>

							<!-- Select Basic -->
							<div class="form-group">
								<label class="col-md-4 control-label" for="selectbasic">Civilité</label>
								<div class="col-md-4">
									<select id="selectbasic" name="civil" class="form-control">
										<option value="Monsieur">Monsieur</option>
										<option value="Madame">Madame</option>
									</select>
								</div>
							</div>

							<!-- Text input-->
							<div class="form-group">
								<label class="col-md-4 control-label" for="Nom">Nom de famille</label>
								<div class="col-md-4">
									<input id="Nom" name="Nom" type="text" placeholder="" class="form-control input-md"
										   required="">

								</div>
							</div>

							<!-- Text input-->
							<div class="form-group">
								<label class="col-md-4 control-label" for="prenom">Prénom</label>
								<div class="col-md-4">
									<input id="prenom" name="prenom" type="text" placeholder=""
										   class="form-control input-md" required="">

								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label" for="indicatif">Indicatif téléphonique :</label>
								<div class="col-xs-4">
									<select id="countries_phone1" name="pays" class="form-control bfh-countries"
											data-country="FR">
										<option value="AF">Afghanistan</option>
										<option value="AL">Albania</option>
										<option value="DZ">Algeria</option>
										<option value="AS">American Samoa</option>
										<option value="AD">Andorra</option>
										<option value="AO">Angola</option>
										<option value="AI">Anguilla</option>
										<option value="AQ">Antarctica</option>
										<option value="AG">Antigua and Barbuda</option>
										<option value="AR">Argentina</option>
										<option value="AM">Armenia</option>
										<option value="AW">Aruba</option>
										<option value="AU">Australia</option>
										<option value="AT">Austria</option>
										<option value="AZ">Azerbaijan</option>
										<option value="BH">Bahrain</option>
										<option value="BD">Bangladesh</option>
										<option value="BB">Barbados</option>
										<option value="BY">Belarus</option>
										<option value="BE">Belgium</option>
										<option value="BZ">Belize</option>
										<option value="BJ">Benin</option>
										<option value="BM">Bermuda</option>
										<option value="BT">Bhutan</option>
										<option value="BO">Bolivia</option>
										<option value="BA">Bosnia and Herzegovina</option>
										<option value="BW">Botswana</option>
										<option value="BV">Bouvet Island</option>
										<option value="BR">Brazil</option>
										<option value="IO">British Indian Ocean Territory</option>
										<option value="VG">British Virgin Islands</option>
										<option value="BN">Brunei</option>
										<option value="BG">Bulgaria</option>
										<option value="BF">Burkina Faso</option>
										<option value="BI">Burundi</option>
										<option value="CI">Côte d'Ivoire</option>
										<option value="KH">Cambodia</option>
										<option value="CM">Cameroon</option>
										<option value="CA">Canada</option>
										<option value="CV">Cape Verde</option>
										<option value="KY">Cayman Islands</option>
										<option value="CF">Central African Republic</option>
										<option value="TD">Chad</option>
										<option value="CL">Chile</option>
										<option value="CN">China</option>
										<option value="CX">Christmas Island</option>
										<option value="CC">Cocos (Keeling) Islands</option>
										<option value="CO">Colombia</option>
										<option value="KM">Comoros</option>
										<option value="CG">Congo</option>
										<option value="CK">Cook Islands</option>
										<option value="CR">Costa Rica</option>
										<option value="HR">Croatia</option>
										<option value="CU">Cuba</option>
										<option value="CY">Cyprus</option>
										<option value="CZ">Czech Republic</option>
										<option value="CD">Democratic Republic of the Congo</option>
										<option value="DK">Denmark</option>
										<option value="DJ">Djibouti</option>
										<option value="DM">Dominica</option>
										<option value="DO">Dominican Republic</option>
										<option value="TP">East Timor</option>
										<option value="EC">Ecuador</option>
										<option value="EG">Egypt</option>
										<option value="SV">El Salvador</option>
										<option value="GQ">Equatorial Guinea</option>
										<option value="ER">Eritrea</option>
										<option value="EE">Estonia</option>
										<option value="ET">Ethiopia</option>
										<option value="FO">Faeroe Islands</option>
										<option value="FK">Falkland Islands</option>
										<option value="FJ">Fiji</option>
										<option value="FI">Finland</option>
										<option value="MK">Former Yugoslav Republic of Macedonia</option>
										<option value="FR">France</option>
										<option value="FX">France, Metropolitan</option>
										<option value="GF">French Guiana</option>
										<option value="PF">French Polynesia</option>
										<option value="TF">French Southern Territories</option>
										<option value="GA">Gabon</option>
										<option value="GE">Georgia</option>
										<option value="DE">Germany</option>
										<option value="GH">Ghana</option>
										<option value="GI">Gibraltar</option>
										<option value="GR">Greece</option>
										<option value="GL">Greenland</option>
										<option value="GD">Grenada</option>
										<option value="GP">Guadeloupe</option>
										<option value="GU">Guam</option>
										<option value="GT">Guatemala</option>
										<option value="GN">Guinea</option>
										<option value="GW">Guinea-Bissau</option>
										<option value="GY">Guyana</option>
										<option value="HT">Haiti</option>
										<option value="HM">Heard and Mc Donald Islands</option>
										<option value="HN">Honduras</option>
										<option value="HK">Hong Kong</option>
										<option value="HU">Hungary</option>
										<option value="IS">Iceland</option>
										<option value="IN">India</option>
										<option value="ID">Indonesia</option>
										<option value="IR">Iran</option>
										<option value="IQ">Iraq</option>
										<option value="IE">Ireland</option>
										<option value="IL">Israel</option>
										<option value="IT">Italy</option>
										<option value="JM">Jamaica</option>
										<option value="JP">Japan</option>
										<option value="JO">Jordan</option>
										<option value="KZ">Kazakhstan</option>
										<option value="KE">Kenya</option>
										<option value="KI">Kiribati</option>
										<option value="KW">Kuwait</option>
										<option value="KG">Kyrgyzstan</option>
										<option value="LA">Laos</option>
										<option value="LV">Latvia</option>
										<option value="LB">Lebanon</option>
										<option value="LS">Lesotho</option>
										<option value="LR">Liberia</option>
										<option value="LY">Libya</option>
										<option value="LI">Liechtenstein</option>
										<option value="LT">Lithuania</option>
										<option value="LU">Luxembourg</option>
										<option value="MO">Macau</option>
										<option value="MG">Madagascar</option>
										<option value="MW">Malawi</option>
										<option value="MY">Malaysia</option>
										<option value="MV">Maldives</option>
										<option value="ML">Mali</option>
										<option value="MT">Malta</option>
										<option value="MH">Marshall Islands</option>
										<option value="MQ">Martinique</option>
										<option value="MR">Mauritania</option>
										<option value="MU">Mauritius</option>
										<option value="YT">Mayotte</option>
										<option value="MX">Mexico</option>
										<option value="FM">Micronesia</option>
										<option value="MD">Moldova</option>
										<option value="MC">Monaco</option>
										<option value="MN">Mongolia</option>
										<option value="ME">Montenegro</option>
										<option value="MS">Montserrat</option>
										<option value="MA">Morocco</option>
										<option value="MZ">Mozambique</option>
										<option value="MM">Myanmar</option>
										<option value="NA">Namibia</option>
										<option value="NR">Nauru</option>
										<option value="NP">Nepal</option>
										<option value="NL">Netherlands</option>
										<option value="AN">Netherlands Antilles</option>
										<option value="NC">New Caledonia</option>
										<option value="NZ">New Zealand</option>
										<option value="NI">Nicaragua</option>
										<option value="NE">Niger</option>
										<option value="NG">Nigeria</option>
										<option value="NU">Niue</option>
										<option value="NF">Norfolk Island</option>
										<option value="KP">North Korea</option>
										<option value="MP">Northern Marianas</option>
										<option value="NO">Norway</option>
										<option value="OM">Oman</option>
										<option value="PK">Pakistan</option>
										<option value="PW">Palau</option>
										<option value="PS">Palestine</option>
										<option value="PA">Panama</option>
										<option value="PG">Papua New Guinea</option>
										<option value="PY">Paraguay</option>
										<option value="PE">Peru</option>
										<option value="PH">Philippines</option>
										<option value="PN">Pitcairn Islands</option>
										<option value="PL">Poland</option>
										<option value="PT">Portugal</option>
										<option value="PR">Puerto Rico</option>
										<option value="QA">Qatar</option>
										<option value="RE">Reunion</option>
										<option value="RO">Romania</option>
										<option value="RU">Russia</option>
										<option value="RW">Rwanda</option>
										<option value="ST">São Tomé and Príncipe</option>
										<option value="SH">Saint Helena</option>
										<option value="PM">St. Pierre and Miquelon</option>
										<option value="KN">Saint Kitts and Nevis</option>
										<option value="LC">Saint Lucia</option>
										<option value="VC">Saint Vincent and the Grenadines</option>
										<option value="WS">Samoa</option>
										<option value="SM">San Marino</option>
										<option value="SA">Saudi Arabia</option>
										<option value="SN">Senegal</option>
										<option value="RS">Serbia</option>
										<option value="SC">Seychelles</option>
										<option value="SL">Sierra Leone</option>
										<option value="SG">Singapore</option>
										<option value="SK">Slovakia</option>
										<option value="SI">Slovenia</option>
										<option value="SB">Solomon Islands</option>
										<option value="SO">Somalia</option>
										<option value="ZA">South Africa</option>
										<option value="GS">South Georgia and the South Sandwich Islands</option>
										<option value="KR">South Korea</option>
										<option value="ES">Spain</option>
										<option value="LK">Sri Lanka</option>
										<option value="SD">Sudan</option>
										<option value="SR">Suriname</option>
										<option value="SJ">Svalbard and Jan Mayen Islands</option>
										<option value="SZ">Swaziland</option>
										<option value="SE">Sweden</option>
										<option value="CH">Switzerland</option>
										<option value="SY">Syria</option>
										<option value="TW">Taiwan</option>
										<option value="TJ">Tajikistan</option>
										<option value="TZ">Tanzania</option>
										<option value="TH">Thailand</option>
										<option value="BS">The Bahamas</option>
										<option value="GM">The Gambia</option>
										<option value="TG">Togo</option>
										<option value="TK">Tokelau</option>
										<option value="TO">Tonga</option>
										<option value="TT">Trinidad and Tobago</option>
										<option value="TN">Tunisia</option>
										<option value="TR">Turkey</option>
										<option value="TM">Turkmenistan</option>
										<option value="TC">Turks and Caicos Islands</option>
										<option value="TV">Tuvalu</option>
										<option value="VI">US Virgin Islands</option>
										<option value="UG">Uganda</option>
										<option value="UA">Ukraine</option>
										<option value="AE">United Arab Emirates</option>
										<option value="GB">United Kingdom</option>
										<option value="US">United States</option>
										<option value="UM">United States Minor Outlying Islands</option>
										<option value="UY">Uruguay</option>
										<option value="UZ">Uzbekistan</option>
										<option value="VU">Vanuatu</option>
										<option value="VA">Vatican City</option>
										<option value="VE">Venezuela</option>
										<option value="VN">Vietnam</option>
										<option value="WF">Wallis and Futuna Islands</option>
										<option value="EH">Western Sahara</option>
										<option value="YE">Yemen</option>
										<option value="ZM">Zambia</option>
										<option value="ZW">Zimbabwe</option>
									</select>
								</div>
							</div>


							<!-- Text input-->
							<div class="form-group">
								<label class="col-md-4 control-label" for="tel">Téléphone</label>
								<div class="col-md-4">
									<input style="text-align: left;" id="tel" name="tel" type="tel" placeholder=""
										   class="form-control bfh-phone" data-country="countries_phone1" required="">

								</div>
							</div>

							<!-- Text input-->
							<div class="form-group">
								<label class="col-md-4 control-label" for="mail">E-mail</label>
								<div class="col-md-4">
									<input id="mail" name="mail" type="email" placeholder=""
										   class="form-control input-md" required="">
								</div>
							</div>
							<!--
							<div class="form-group">
							  <div class="col-md-12 text-center">
							  <label for="sendid" class="control-label">Transmettre les identifiants au client</label>
							  <input id="sendid" name="sendid" type="checkbox">
							  </div>
							</div>
							-->

							<!-- Button (Double) -->
							<div class="form-group">
								<div class="text-center">
									<button class="btn-mscpi btn-orange" name="button1id" value="AddClient">AJOUTER
									</button>
									<?php
									/*
								<button id="button1id" name="button1id" style="display: none;" value="AddClient">Envoi</button>
								<!--<button id="button2id" name="button2id" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Annuler</button>-->
								*/
									?>
								</div>
							</div>

						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</div>


<?php
/*
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="pull-left" href="admin_lkje5sjwjpzkhdl42mscpi.php?p=Accueil">
				<img src="img/logo-meilleurescpi.png" alt="logo">
			</a>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li style="margin-left: 10px;"></li>
				<?php
				if (property_exists($this, "id") && $this->id != null) {
				?>
					<li>
						<a href=<?php echo "?p=Synthese&client=" . $this->id; ?>>Synthèse</a>
					</li>
					<li>
						<a href=<?php echo "?p=Coordonnees&client=" . $this->id; ?>>Coordonnées</a>
					</li>
					<li>
						<a href=<?php echo "?p=Documents&client=" . $this->id; ?>>Documents</a>
					</li>
					 <li>
						<a href=<?php echo "?p=Suivi&client=" . $this->id; ?>>Suivi</a>
					</li>
					<li>
						<a href=<?php echo "?p=PEC&client=" . $this->id; ?>>Projet en cours</a>
					</li>
					<li>
						<a href=<?php echo "?p=QSLM&client=" . $this->id; ?>>Questionnaire et situation</a>
					</li>
				   <li>
						<p class="navbar-btn">
							<a href=<?php print('"admin_lkje5sjwjpzkhdl42mscpi.php?logout=' . (ft_decrypt_crypt_information($_COOKIE['token'])) .'"'); ?> class="btn btn-warning">Logout !</a>
						</p>
					</li>
				<?php
				}
				else {
				?>
			  	</ul><div class="col-md-offset-7 col-md-2" style="margin-top: 14px;">
					<p class="navbar-btn">
					  <a href=<?php print('"admin_lkje5sjwjpzkhdl42mscpi.php?logout=' . (ft_decrypt_crypt_information($_COOKIE['token'])) .'"'); ?> class="btn btn-warning">Logout !</a>
					</p>

  				</div> <?php } ?>
		</div>
	</div>
</nav>
*/
?>
