<script src='https://www.google.com/recaptcha/api.js'></script>
<header>
	<div class=" imgTop">
  		<!--<div style="position: absolute;left: 50%;">-->
  		<div style="position: absolute;width: 100%;text-align: center;">
        	<div style="margin-top: 39px;">
				<h1>CRÉATION DE VOTRE COMPTE</h1>
        	</div>
    	</div>
    	<img src="<?= $this->getPath() ?>img/header.jpg">
	</div>
</header>
  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<a class="pull-left" href="index.php">
				<img src="<?= $this->getPath() ?>img/logo-meilleurescpi.png" alt="logo" style="margin-bottom: -1px;">
			</a>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		</div>
	</div>
  </nav>

<?php
if (!empty($_SESSION['captcha']))
	echo '<div class="alert alert-warning"><strong>Oups ... </strong>il semblerait que le captcha que vous avez renseigné n\'est pas valide.</div>';
$_SESSION['captcha'] = NULL;
if (!empty($_SESSION['mail']))
	echo '<div class="alert alert-warning"><strong>Oups ... </strong>il semblerait que l’adresse e-mail que vous avez renseigné est déjà utilisée. Avez-vous oublié votre mot de passe ?</div>';
$_SESSION['mail'] = NULL;
?>
<div class="mdlProgressBlock">
	<?=$this->ProgressBlock?>
</div>

<div class="outWell">
<div class="well">
<form id="tosendinfo" class="form-horizontal" method="post" action="?p=<?php echo $GLOBALS['GET']['p']?>">
<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
	<div class="maform">
    <div class="form-group">
    <label class="col-xs-6 control-label" for="civil">Civilité : </label>
        <div class="col-xs-6">
        <select name="civil" id="civil" required="1" class="form-control">
              <option value="">Choisir</option>
              <option value="Monsieur">Monsieur</option>
              <option value="Madame"<?php if (!empty($select)) print('selected');?>>Madame</option>
        </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-6 control-label" for="nom">Nom : </label>
        <div class="col-xs-6">
            <input maxlength="42" required name="nom" id="nom"<?php if (!empty($_COOKIE['nom']) && $_COOKIE['nom'] !== NULL) echo 'value="' . ft_decrypt_crypt_information($_COOKIE['nom']) . '"';?>></input><img class="valid1" src="<?= $this->getPath() ?>img/valid.png"> <img class="erreur1" src="<?= $this->getPath() ?>img/warning.ico">
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-6 control-label" for="prenom">Prénom : </label>
        <div class="col-xs-6">
            <input maxlength="42" required name="prenom" id="prenom" <?php if (!empty($_COOKIE['prenom'])) echo 'value="' . ft_decrypt_crypt_information($_COOKIE['prenom']) . '"';?> ></input><img class="valid2" src="<?= $this->getPath()?>img/valid.png"> <img class="erreur2" src="<?= $this->getPath()?>img/warning.ico">
        </div>
    </div>
    

<div class="form-group">
  <label class="col-xs-6 control-label" for="indicatif">Indicatif téléphonique :</label>
  <div class="col-xs-6">
<select id="countries_phone1" name="pays" class="form-control bfh-countries" data-country="FR">
<option value="AF">Afghanistan</option>
<option value="AL">Albania</option>
<option value="DZ">Algeria</option>
<option value="AS">American Samoa</option>
<option value="AD">Andorra</option><option value="AO">Angola</option><option value="AI">Anguilla</option><option value="AQ">Antarctica</option><option value="AG">Antigua and Barbuda</option><option value="AR">Argentina</option><option value="AM">Armenia</option><option value="AW">Aruba</option><option value="AU">Australia</option><option value="AT">Austria</option><option value="AZ">Azerbaijan</option><option value="BH">Bahrain</option><option value="BD">Bangladesh</option><option value="BB">Barbados</option><option value="BY">Belarus</option><option value="BE">Belgium</option><option value="BZ">Belize</option><option value="BJ">Benin</option><option value="BM">Bermuda</option><option value="BT">Bhutan</option><option value="BO">Bolivia</option><option value="BA">Bosnia and Herzegovina</option><option value="BW">Botswana</option><option value="BV">Bouvet Island</option><option value="BR">Brazil</option><option value="IO">British Indian Ocean Territory</option><option value="VG">British Virgin Islands</option><option value="BN">Brunei</option><option value="BG">Bulgaria</option><option value="BF">Burkina Faso</option><option value="BI">Burundi</option><option value="CI">Côte d'Ivoire</option><option value="KH">Cambodia</option><option value="CM">Cameroon</option><option value="CA">Canada</option><option value="CV">Cape Verde</option><option value="KY">Cayman Islands</option><option value="CF">Central African Republic</option><option value="TD">Chad</option><option value="CL">Chile</option><option value="CN">China</option><option value="CX">Christmas Island</option><option value="CC">Cocos (Keeling) Islands</option><option value="CO">Colombia</option><option value="KM">Comoros</option><option value="CG">Congo</option><option value="CK">Cook Islands</option><option value="CR">Costa Rica</option><option value="HR">Croatia</option><option value="CU">Cuba</option><option value="CY">Cyprus</option><option value="CZ">Czech Republic</option><option value="CD">Democratic Republic of the Congo</option><option value="DK">Denmark</option><option value="DJ">Djibouti</option><option value="DM">Dominica</option><option value="DO">Dominican Republic</option><option value="TP">East Timor</option><option value="EC">Ecuador</option><option value="EG">Egypt</option><option value="SV">El Salvador</option><option value="GQ">Equatorial Guinea</option><option value="ER">Eritrea</option><option value="EE">Estonia</option><option value="ET">Ethiopia</option><option value="FO">Faeroe Islands</option><option value="FK">Falkland Islands</option><option value="FJ">Fiji</option><option value="FI">Finland</option><option value="MK">Former Yugoslav Republic of Macedonia</option><option value="FR">France</option><option value="FX">France, Metropolitan</option><option value="GF">French Guiana</option><option value="PF">French Polynesia</option><option value="TF">French Southern Territories</option><option value="GA">Gabon</option><option value="GE">Georgia</option><option value="DE">Germany</option><option value="GH">Ghana</option><option value="GI">Gibraltar</option><option value="GR">Greece</option><option value="GL">Greenland</option><option value="GD">Grenada</option><option value="GP">Guadeloupe</option><option value="GU">Guam</option><option value="GT">Guatemala</option><option value="GN">Guinea</option><option value="GW">Guinea-Bissau</option><option value="GY">Guyana</option><option value="HT">Haiti</option><option value="HM">Heard and Mc Donald Islands</option><option value="HN">Honduras</option><option value="HK">Hong Kong</option><option value="HU">Hungary</option><option value="IS">Iceland</option><option value="IN">India</option><option value="ID">Indonesia</option><option value="IR">Iran</option><option value="IQ">Iraq</option><option value="IE">Ireland</option><option value="IL">Israel</option><option value="IT">Italy</option><option value="JM">Jamaica</option><option value="JP">Japan</option><option value="JO">Jordan</option><option value="KZ">Kazakhstan</option><option value="KE">Kenya</option><option value="KI">Kiribati</option><option value="KW">Kuwait</option><option value="KG">Kyrgyzstan</option><option value="LA">Laos</option><option value="LV">Latvia</option><option value="LB">Lebanon</option><option value="LS">Lesotho</option><option value="LR">Liberia</option><option value="LY">Libya</option><option value="LI">Liechtenstein</option><option value="LT">Lithuania</option><option value="LU">Luxembourg</option><option value="MO">Macau</option><option value="MG">Madagascar</option><option value="MW">Malawi</option><option value="MY">Malaysia</option><option value="MV">Maldives</option><option value="ML">Mali</option><option value="MT">Malta</option><option value="MH">Marshall Islands</option><option value="MQ">Martinique</option><option value="MR">Mauritania</option><option value="MU">Mauritius</option><option value="YT">Mayotte</option><option value="MX">Mexico</option><option value="FM">Micronesia</option><option value="MD">Moldova</option><option value="MC">Monaco</option><option value="MN">Mongolia</option><option value="ME">Montenegro</option><option value="MS">Montserrat</option><option value="MA">Morocco</option><option value="MZ">Mozambique</option><option value="MM">Myanmar</option><option value="NA">Namibia</option><option value="NR">Nauru</option><option value="NP">Nepal</option><option value="NL">Netherlands</option><option value="AN">Netherlands Antilles</option><option value="NC">New Caledonia</option><option value="NZ">New Zealand</option><option value="NI">Nicaragua</option><option value="NE">Niger</option><option value="NG">Nigeria</option><option value="NU">Niue</option><option value="NF">Norfolk Island</option><option value="KP">North Korea</option><option value="MP">Northern Marianas</option><option value="NO">Norway</option><option value="OM">Oman</option><option value="PK">Pakistan</option><option value="PW">Palau</option><option value="PS">Palestine</option><option value="PA">Panama</option><option value="PG">Papua New Guinea</option><option value="PY">Paraguay</option><option value="PE">Peru</option><option value="PH">Philippines</option><option value="PN">Pitcairn Islands</option><option value="PL">Poland</option><option value="PT">Portugal</option><option value="PR">Puerto Rico</option><option value="QA">Qatar</option><option value="RE">Reunion</option><option value="RO">Romania</option><option value="RU">Russia</option><option value="RW">Rwanda</option><option value="ST">São Tomé and Príncipe</option><option value="SH">Saint Helena</option><option value="PM">St. Pierre and Miquelon</option><option value="KN">Saint Kitts and Nevis</option><option value="LC">Saint Lucia</option><option value="VC">Saint Vincent and the Grenadines</option><option value="WS">Samoa</option><option value="SM">San Marino</option><option value="SA">Saudi Arabia</option><option value="SN">Senegal</option><option value="RS">Serbia</option><option value="SC">Seychelles</option><option value="SL">Sierra Leone</option><option value="SG">Singapore</option><option value="SK">Slovakia</option><option value="SI">Slovenia</option><option value="SB">Solomon Islands</option><option value="SO">Somalia</option><option value="ZA">South Africa</option><option value="GS">South Georgia and the South Sandwich Islands</option><option value="KR">South Korea</option><option value="ES">Spain</option><option value="LK">Sri Lanka</option><option value="SD">Sudan</option><option value="SR">Suriname</option><option value="SJ">Svalbard and Jan Mayen Islands</option><option value="SZ">Swaziland</option><option value="SE">Sweden</option><option value="CH">Switzerland</option><option value="SY">Syria</option><option value="TW">Taiwan</option><option value="TJ">Tajikistan</option><option value="TZ">Tanzania</option><option value="TH">Thailand</option><option value="BS">The Bahamas</option><option value="GM">The Gambia</option><option value="TG">Togo</option><option value="TK">Tokelau</option><option value="TO">Tonga</option><option value="TT">Trinidad and Tobago</option><option value="TN">Tunisia</option><option value="TR">Turkey</option><option value="TM">Turkmenistan</option><option value="TC">Turks and Caicos Islands</option><option value="TV">Tuvalu</option><option value="VI">US Virgin Islands</option><option value="UG">Uganda</option><option value="UA">Ukraine</option><option value="AE">United Arab Emirates</option><option value="GB">United Kingdom</option><option value="US">United States</option><option value="UM">United States Minor Outlying Islands</option><option value="UY">Uruguay</option><option value="UZ">Uzbekistan</option><option value="VU">Vanuatu</option><option value="VA">Vatican City</option><option value="VE">Venezuela</option><option value="VN">Vietnam</option><option value="WF">Wallis and Futuna Islands</option><option value="EH">Western Sahara</option><option value="YE">Yemen</option><option value="ZM">Zambia</option><option value="ZW">Zimbabwe</option></select>
  </div>
</div>
    <div class="form-group">
        <label class="col-xs-6 control-label" for="num">Téléphone Portable : </label>
        <div class="col-xs-6">
            <input name="num" id="num" type="tel" onclick="$('#numex').css('display', 'initial');" class="form-control bfh-phone" data-country="countries_phone1" <?php if (!empty($_COOKIE['num'])) echo 'value="' . ft_decrypt_crypt_information($_COOKIE['num']) . '"';?> required=""><img class="valid3" src="<?= $this->getPath() ?>img/valid.png"><!-- <img class="erreur3" src="<?= $this->getPath() ?>img/warning.ico"> -->
			<label style="text-align: left; display: none;" id="numex" class="col-xs-12 control-label" for="num">Ex : +33 6 45 45 45 45</label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-6 control-label" for="mail">E-Mail : </label>
        <div class="col-xs-6">
            <input required maxlength="200" type="email" name="mail" id="mail" <?php if (!empty($_COOKIE['mail'])) echo 'value="' . ft_decrypt_crypt_information($_COOKIE['mail']) . '"';?>></input><img class="valid4" src="<?= $this->getPath() ?>img/valid.png"> <img class="erreur4" src="<?= $this->getPath() ?>img/warning.ico">
        </div>  
    </div>
    <script>
        var disp = 0;
        function mydisplaymodal(){
            $('#__check').attr("checked", true);
            if (disp == 0)
				 disp = 1;
			else if (disp == 2)
                disp += 1;
			if (disp == 3){
				$('.tosend').replaceWith( '<input id="beta" class="tosend" type="image" style="display: none;" src="<?= $this->getPath() ?>img/btn_1_hd.JPG" name="send" value="send"></input>' );
			}
		}
        function mydisplaymodal2(){
            $('#__check2').attr("checked", true);
            if (disp == 0)
			   disp = 2;
			else if (disp == 1)
                disp += 2;
			if (disp == 3)
				$('.tosend').replaceWith( '<input id="beta" class="tosend" type="image" style="display: none;" src="<?= $this->getPath() ?>img/btn_1_hd.JPG" name="send" value="send"></input>' );
        }
        function check_read(){
			if (disp == 1)
                document.getElementById('pushmodal2').click();
            else
				document.getElementById('pushmodal').click();
		}
        $(document).ready(function(){
        $('#pass').keyup(function()
        {
            checkStrength($('#pass').val())
        })
        $('#nom').keyup(function(){
            if (!$('#nom').val().match(/^([A-Za-z '-éèëêâä]+)$/)){
                $('.valid1').css("display", "none");
                $('.erreur1').css("display", "initial");
                $('#nom').css("border", "2px solid #01528A");
                $('#msgimp').css("display", "block");
            }
            else{
                $('.valid1').css("display", "initial");
                $('.erreur1').css("display", "none");
                $('#nom').css("border", "2px solid #018A13");
                $('#msgimp').css("display", "none");
            }
        })
        $('#prenom').keyup(function(){
            if (!$('#prenom').val().match(/^([A-Za-z '-éèêëâä]+)$/)){
                $('.valid2').css("display", "none");
                $('.erreur2').css("display", "initial");
                $('#prenom').css("border", "2px solid #01528A");
                $('#msgimp').css("display", "block");
            }
            else{
                $('.valid2').css("display", "initial");
                $('.erreur2').css("display", "none");
                $('#prenom').css("border", "2px solid #018A13");
                $('#msgimp').css("display", "none");
            }
        })
        $('#mail').keyup(function(){
            if (!$('#mail').val().match(/(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/)){
                $('.valid4').css("display", "none");
                $('.erreur4').css("display", "initial");
                $('#mail').css("border", "2px solid #01528A");
                $('#msgimp').css("display", "block");
            }
            else{
                $('.valid4').css("display", "initial");
                $('.erreur4').css("display", "none");
                $('#mail').css("border", "2px solid #018A13");
                $('#msgimp').css("display", "none");
            }
        })
        function checkStrength(password){
        if (!password.match(/([a-z])/g)){
            $('.pass_erreur1').css("display", "none");
            $('.pass_erreur2').css("display", "none");
            $('.pass_erreur3').css("display", "initial");
            $('.pass_erreur4').css("display", "none");
            $('.success_1').css("display", "none");
			$('#pass').css("border", "2px solid #01528A");
		    $('#msgimp').css("display", "block");
        }
		else if (!password.match(/([A-Z])/g)){
			$('.pass_erreur1').css("display", "none");
			$('.pass_erreur2').css("display", "initial");
			$('.pass_erreur3').css("display", "none");
			$('.pass_erreur4').css("display", "none");
			$('.success_1').css("display", "none");
			$('#pass').css("border", "2px solid #01528A");
		    $('#msgimp').css("display", "block");
        }
		else if (!password.match(/[0-9]/g)){
			$('.pass_erreur1').css("display", "none");
			$('.pass_erreur2').css("display", "none");
			$('.pass_erreur3').css("display", "none");
			$('.pass_erreur4').css("display", "initial");
			$('.success_1').css("display", "none");
			$('#pass').css("border", "2px solid #01528A");
		    $('#msgimp').css("display", "block");
        }
		else if (password.length < 8){
			console.log(password);
			$('.pass_erreur1').css("display", "initial");
			$('.pass_erreur2').css("display", "none");
			$('.pass_erreur3').css("display", "none");
			$('.pass_erreur4').css("display", "none");
			$('.success_1').css("display", "none");
			$('#pass').css("border", "2px solid #01528A");
		    $('#msgimp').css("display", "block");
        }
		else{
			$('.pass_erreur1').css("display", "none");
			$('.pass_erreur2').css("display", "none");
			$('.pass_erreur3').css("display", "none");
			$('.pass_erreur4').css("display", "none");
			$('.success_1').css("display", "initial");
			$('#pass').css("border", "2px solid #018A13");
		    $('#msgimp').css("display", "none");
        }
		}
		$('#pass2').keyup(function(){
			if ($('#pass2').val() != $('#pass').val()){
				$('.success_2').css("display", "none");
				$('.erreur5').css("display", "initial");
				$('#pass2').css("border", "2px solid #01528A");
			    $('#msgimp').css("display", "block");
            }
			else{
				$('.success_2').css("display", "initial");
				$('.erreur5').css("display", "none");
				$('#pass2').css("border", "2px solid #018A13");
			    $('#msgimp').css("display", "none");
            }
		})
	})
	</script>
	<div class="form-group">
		<label class="col-xs-6 control-label" for="pass">Saisissez un mot de passe :</label>
		<div class="col-xs-6">
			<input required maxlength="42" type="password" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Mot de passe non conforme' : ''); if(this.checkValidity()) form.pass2.pattern = this.value;"  pattern="^(?=.*\d)(?=.*[a-z])(?=.{8,42})(?=.*[A-Z])(?!.*\s).*$" name="pass" id="pass"<?php if (!empty($_COOKIE['pass'])) echo 'value="' . ft_decrypt_crypt_information($_COOKIE['pass']) . '"';?>></input>
		<p class="pass_erreur1"><img style="width: 37px; margin-left: -4px; margin-top: -9px;" src="<?= $this->getPath() ?>img/warning.ico"> 8 caractères sont nécessaires.</p>
		<p class="pass_erreur2"><img style="width: 37px; margin-left: -4px; margin-top: -9px;" src="<?= $this->getPath() ?>img/warning.ico">Une majuscule est manquante.</p>
		<p class="pass_erreur3"><img style="width: 37px; margin-left: -4px; margin-top: -9px;" src="<?= $this->getPath() ?>img/warning.ico">Une minuscule est manquante.</p>
		<p class="pass_erreur4"><img style="width: 37px; margin-left: -4px; margin-top: -9px;" src="<?= $this->getPath() ?>img/warning.ico">Un chiffre est manquant.</p>
		<p class="success_1"><img style="width: 30px; margin-left: 0px; margin-top: -9px;" src="<?= $this->getPath() ?>img/valid.png"></p>
		</div>
	</div>
	<div class="form-group">
		<label class="col-xs-6 control-label" for="pass2">Confirmez le mot de passe :</label>
		<div class="col-xs-6">
		<input required="1" maxlength="42" type="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.{8,42})(?=.*[A-Z])(?!.*\s).*$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Les mots de passe ne correspondent' : '');"  name="pass2" id="pass2"<?php if (!empty($_COOKIE['pass2'])) echo 'value="' . ft_decrypt_crypt_information($_COOKIE['pass2']) . '"';?> ></input>
		<p class="help-block erreur5"><img style="width: 37px; margin-left: -4px; margin-top: -9px;" src="<?= $this->getPath() ?>img/warning.ico">Mot de passe incorrect.</p>
		<p class="help-block success_2"><img style="width: 30px; margin-left: 0px; margin-top: -9px;" src="<?= $this->getPath() ?>img/valid.png">Mots de passe correct.</p>
	</div>
		</div>
	<div class="form-group">
		<label class="col-md-6 col-xs-12 control-label">Etes-vous un robot ? :</label>
		<div class="col-md-6 col-xs-12 captcha_mobile">
			<div class="g-recaptcha" data-sitekey="6LdQvwwUAAAAANOARBZ0WDlYRZ5A0XkfgAxxG8Sn"></div>
		</div>
	</div>
	<div class="form-group col-md-12">
		<label style="font-size: 15px; font-weight: normal;">
        <input type="checkbox" style="height:14px;width:14px;"name="fil" required="" id="__check" value="42"<?php if (!empty($_COOKIE['fil'])) echo "checked"?>> Je reconnais avoir pris connaissance de la <a onclick="mydisplaymodal()" id="pushmodal" data-toggle="modal" data-target="#myModal" style="color: #01528A;">Fiche d'informations légales de MeilleureSCPI.com</a></label>
        <input type="checkbox" style="height:14px;width:14px;"name="CGU" required="" id="__check2" value="42"<?php if (!empty($_COOKIE['fil'])) echo "checked"?>> Je reconnais avoir pris connaissance des <a onclick="mydisplaymodal2()" id="pushmodal2" data-toggle="modal" data-target="#myModal2" style="color: #01528A;">CGU</a></label>
	</div>
	</div>
	<img id="beta" onclick="check_read()" style="display: none; cursor:pointer;" class="tosend" type="image" src="<?= $this->getPath() ?>img/btn_1_hd.JPG" name="send" value="send"></img>
    <br><br><br>
        <div  class="forButton">
            <div class="btn" onClick="$('#beta').trigger('click');" style="background-color: #ffffff ; border: solid 2px #01528A; width: 260px; height: 50px; text-align: center;    color: #01528A; cursor:pointer; max-width: 100%;">
                <img style="width: 50px; padding: 0px; float: left;" src="<?= $this->getPath() ?>img/MS-CreationCompte-Visuels_Valider.png">
                <p>VALIDER ET PASSER A<br>L'ETAPE SUIVANTE</p>
            </div>
        </div>
</form>

</div>








<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Fiche d’informations légales - Meilleurescpi.com</h4>
      </div>
      <div class="modal-body">
        <div class="embed-responsive embed-responsive-16by9">
			<?php
			if (count($this->linkFIL))
			{
				$this->linkFIL = $this->linkFIL[0];
				?>
				<iframe class="embed-responsive-item" src='Download.php?idDocument=<?=$this->linkFIL->id?>#zoom=100'></iframe>
				<?php
			}
			else
			{
				?>
					<span>Il n'y a pas de document ici</span>
				<?php
			}
			?>
        </div>
      </div>
      <div class="modal-footer">
	<div class="forButton">
		<div>
			<div onClick="$('#beta').trigger('click'); $('#myModal').modal('hide');" style="background-color: #ffffff ; border: solid 2px #01528A; width: 260px; height: 50px; text-align: center; color: #01528A; cursor:pointer; margin-left: 0px;">
				<img style="width: 50px; padding: 0px; float: left;" src="<?= $this->getPath() ?>img/MS-CreationCompte-Visuels_Valider.png">
				<p>VALIDER ET PASSER A<br>L'ETAPE SUIVANTE</p>
			</div>
		</div>
	</div>
      </div>
    </div>
  </div>
</div>
</div>



<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Fiche d’informations légales - Meilleurescpi.com</h4>
      </div>
      <div class="modal-body">
        <div class="embed-responsive embed-responsive-16by9">
			<?php
			if (count($this->linkCGU))
			{
				$this->linkCGU = $this->linkCGU[0];
				?>
				<iframe class="embed-responsive-item" src='Download.php?idDocument=<?=$this->linkCGU->id?>#zoom=100'></iframe>
				<?php
			}
			else
			{
				?>
					<span>Il n'y a pas de document ici</span>
				<?php
			}
			?>
        </div>
      </div>
      <div class="modal-footer">
	<div class="forButton">
		<div>
			<div onClick="$('#myModal').modal('hide'); $('#myModal2').modal('hide'); $('#beta').trigger('click');" style="background-color: #ffffff ; border: solid 2px #01528A; width: 260px; height: 50px; text-align: center; color: #01528A; cursor:pointer; margin-left: 0px;">
				<img style="width: 50px; padding: 0px; float: left;" src="<?= $this->getPath() ?>img/MS-CreationCompte-Visuels_Valider.png">
				<p>VALIDER ET PASSER A<br>L'ETAPE SUIVANTE</p>
			</div>
		</div>
	</div>
      </div>
    </div>
  </div>
</div>
</div>
<?php Notif::getAll(); ?>
