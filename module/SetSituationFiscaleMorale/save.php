<p class="help-block info_block"><strong>Avertissement :</strong> Ce questionnaire a pour but de nous permettre de vous conseiller de la meilleure des façons et de nous assurer que<br>
les instruments ou services financiers sollicités par vos soins sont adaptés à vos connaissances et à votre expérience. Ces informations<br>
sont amenées à être actualisées à la suite de toute modification et au maximum tous les 3 ans.<br>
Il est nécessaire que vous répondiez de manière sincère à ces questions. Toute réponse incomplète ou erronée risque de compromettre<br>
la fiabilité et/ou la pertinence de notre analyse et donc des solutions que nous serons amenés à vous présenter.q</p>

<form method="POST" class="form-horizontal" id="tosendinfo">

<fieldset>
<div class="row">
    <div class="col-md-6">
<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="civilite">Civilité</label>
  <div class="col-md-4">
    <select id="civilite" name="civilite" class="form-control">
      <option value="Monsieur">Monsieur</option>
      <option value="Madame">Madame</option>
    </select>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="nom">Nom</label>  
  <div class="col-md-4">
  <input id="Nom" name="nom" type="text" value="<?=$this->Pp->getName()?>" placeholder="Nom" class="form-control input-md" required>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="nom_jeune_fille">Nom de jeune fille</label>  
  <div class="col-md-4">
  <input id="nom_jeune_fille" name="nom_jeune_fille" type="text" placeholder="Nom de jeune fille" value="<?=$this->Pp->getNomJeuneFille()?>" class="form-control input-md">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="prenom">Prénom</label>  
  <div class="col-md-4">
  <input id="prenom" name="prenom" type="text" placeholder="Prénom"  value="<?=$this->Pp->getFirstName()?>" class="form-control input-md" required>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="profession">Profession</label>  
  <div class="col-md-4">
  <input id="work" name="profession" type="text" placeholder="Profession" value="<?=$this->Pp->getProfession()?>" class="form-control input-md" required>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="date_naissance">Date de naissance</label>  
  <div class="col-md-4">
  <input id="date_naissance" name="date_naissance" type="date" placeholder="Date de naissance" <?=(!empty($this->Pp->getDateNaissance()) && $this->Pp->getDateNaissance()->getTimestamp()) ? "value='" . $this->Pp->getDateNaissance()->format("Y-m-d") . "'" : '' ?> class="form-control input-md" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="lieu_naissance">Lieu de naissance</label>  
  <div class="col-md-4">
  <input id="lieu_naissance" name="lieu_naissance" type="text" value="<?=$this->Pp->getLieuNaissance()?>" placeholder="Lieu de naissance" class="form-control input-md" required>
</div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="indicatif">Indicatif téléphonique :</label>
  <div class="col-md-4">
<select id="countries_phone1" name="indicatif" class="form-control bfh-countries" data-country="FR">
<option value="AF">Afghanistan</option>
<option value="AL">Albania</option>
<option value="DZ">Algeria</option>
<option value="AS">American Samoa</option>
<option value="AD">Andorra</option><option value="AO">Angola</option><option value="AI">Anguilla</option><option value="AQ">Antarctica</option><option value="AG">Antigua and Barbuda</option><option value="AR">Argentina</option><option value="AM">Armenia</option><option value="AW">Aruba</option><option value="AU">Australia</option><option value="AT">Austria</option><option value="AZ">Azerbaijan</option><option value="BH">Bahrain</option><option value="BD">Bangladesh</option><option value="BB">Barbados</option><option value="BY">Belarus</option><option value="BE">Belgium</option><option value="BZ">Belize</option><option value="BJ">Benin</option><option value="BM">Bermuda</option><option value="BT">Bhutan</option><option value="BO">Bolivia</option><option value="BA">Bosnia and Herzegovina</option><option value="BW">Botswana</option><option value="BV">Bouvet Island</option><option value="BR">Brazil</option><option value="IO">British Indian Ocean Territory</option><option value="VG">British Virgin Islands</option><option value="BN">Brunei</option><option value="BG">Bulgaria</option><option value="BF">Burkina Faso</option><option value="BI">Burundi</option><option value="CI">Côte d'Ivoire</option><option value="KH">Cambodia</option><option value="CM">Cameroon</option><option value="CA">Canada</option><option value="CV">Cape Verde</option><option value="KY">Cayman Islands</option><option value="CF">Central African Republic</option><option value="TD">Chad</option><option value="CL">Chile</option><option value="CN">China</option><option value="CX">Christmas Island</option><option value="CC">Cocos (Keeling) Islands</option><option value="CO">Colombia</option><option value="KM">Comoros</option><option value="CG">Congo</option><option value="CK">Cook Islands</option><option value="CR">Costa Rica</option><option value="HR">Croatia</option><option value="CU">Cuba</option><option value="CY">Cyprus</option><option value="CZ">Czech Republic</option><option value="CD">Democratic Republic of the Congo</option><option value="DK">Denmark</option><option value="DJ">Djibouti</option><option value="DM">Dominica</option><option value="DO">Dominican Republic</option><option value="TP">East Timor</option><option value="EC">Ecuador</option><option value="EG">Egypt</option><option value="SV">El Salvador</option><option value="GQ">Equatorial Guinea</option><option value="ER">Eritrea</option><option value="EE">Estonia</option><option value="ET">Ethiopia</option><option value="FO">Faeroe Islands</option><option value="FK">Falkland Islands</option><option value="FJ">Fiji</option><option value="FI">Finland</option><option value="MK">Former Yugoslav Republic of Macedonia</option><option value="FR">France</option><option value="FX">France, Metropolitan</option><option value="GF">French Guiana</option><option value="PF">French Polynesia</option><option value="TF">French Southern Territories</option><option value="GA">Gabon</option><option value="GE">Georgia</option><option value="DE">Germany</option><option value="GH">Ghana</option><option value="GI">Gibraltar</option><option value="GR">Greece</option><option value="GL">Greenland</option><option value="GD">Grenada</option><option value="GP">Guadeloupe</option><option value="GU">Guam</option><option value="GT">Guatemala</option><option value="GN">Guinea</option><option value="GW">Guinea-Bissau</option><option value="GY">Guyana</option><option value="HT">Haiti</option><option value="HM">Heard and Mc Donald Islands</option><option value="HN">Honduras</option><option value="HK">Hong Kong</option><option value="HU">Hungary</option><option value="IS">Iceland</option><option value="IN">India</option><option value="ID">Indonesia</option><option value="IR">Iran</option><option value="IQ">Iraq</option><option value="IE">Ireland</option><option value="IL">Israel</option><option value="IT">Italy</option><option value="JM">Jamaica</option><option value="JP">Japan</option><option value="JO">Jordan</option><option value="KZ">Kazakhstan</option><option value="KE">Kenya</option><option value="KI">Kiribati</option><option value="KW">Kuwait</option><option value="KG">Kyrgyzstan</option><option value="LA">Laos</option><option value="LV">Latvia</option><option value="LB">Lebanon</option><option value="LS">Lesotho</option><option value="LR">Liberia</option><option value="LY">Libya</option><option value="LI">Liechtenstein</option><option value="LT">Lithuania</option><option value="LU">Luxembourg</option><option value="MO">Macau</option><option value="MG">Madagascar</option><option value="MW">Malawi</option><option value="MY">Malaysia</option><option value="MV">Maldives</option><option value="ML">Mali</option><option value="MT">Malta</option><option value="MH">Marshall Islands</option><option value="MQ">Martinique</option><option value="MR">Mauritania</option><option value="MU">Mauritius</option><option value="YT">Mayotte</option><option value="MX">Mexico</option><option value="FM">Micronesia</option><option value="MD">Moldova</option><option value="MC">Monaco</option><option value="MN">Mongolia</option><option value="ME">Montenegro</option><option value="MS">Montserrat</option><option value="MA">Morocco</option><option value="MZ">Mozambique</option><option value="MM">Myanmar</option><option value="NA">Namibia</option><option value="NR">Nauru</option><option value="NP">Nepal</option><option value="NL">Netherlands</option><option value="AN">Netherlands Antilles</option><option value="NC">New Caledonia</option><option value="NZ">New Zealand</option><option value="NI">Nicaragua</option><option value="NE">Niger</option><option value="NG">Nigeria</option><option value="NU">Niue</option><option value="NF">Norfolk Island</option><option value="KP">North Korea</option><option value="MP">Northern Marianas</option><option value="NO">Norway</option><option value="OM">Oman</option><option value="PK">Pakistan</option><option value="PW">Palau</option><option value="PS">Palestine</option><option value="PA">Panama</option><option value="PG">Papua New Guinea</option><option value="PY">Paraguay</option><option value="PE">Peru</option><option value="PH">Philippines</option><option value="PN">Pitcairn Islands</option><option value="PL">Poland</option><option value="PT">Portugal</option><option value="PR">Puerto Rico</option><option value="QA">Qatar</option><option value="RE">Reunion</option><option value="RO">Romania</option><option value="RU">Russia</option><option value="RW">Rwanda</option><option value="ST">São Tomé and Príncipe</option><option value="SH">Saint Helena</option><option value="PM">St. Pierre and Miquelon</option><option value="KN">Saint Kitts and Nevis</option><option value="LC">Saint Lucia</option><option value="VC">Saint Vincent and the Grenadines</option><option value="WS">Samoa</option><option value="SM">San Marino</option><option value="SA">Saudi Arabia</option><option value="SN">Senegal</option><option value="RS">Serbia</option><option value="SC">Seychelles</option><option value="SL">Sierra Leone</option><option value="SG">Singapore</option><option value="SK">Slovakia</option><option value="SI">Slovenia</option><option value="SB">Solomon Islands</option><option value="SO">Somalia</option><option value="ZA">South Africa</option><option value="GS">South Georgia and the South Sandwich Islands</option><option value="KR">South Korea</option><option value="ES">Spain</option><option value="LK">Sri Lanka</option><option value="SD">Sudan</option><option value="SR">Suriname</option><option value="SJ">Svalbard and Jan Mayen Islands</option><option value="SZ">Swaziland</option><option value="SE">Sweden</option><option value="CH">Switzerland</option><option value="SY">Syria</option><option value="TW">Taiwan</option><option value="TJ">Tajikistan</option><option value="TZ">Tanzania</option><option value="TH">Thailand</option><option value="BS">The Bahamas</option><option value="GM">The Gambia</option><option value="TG">Togo</option><option value="TK">Tokelau</option><option value="TO">Tonga</option><option value="TT">Trinidad and Tobago</option><option value="TN">Tunisia</option><option value="TR">Turkey</option><option value="TM">Turkmenistan</option><option value="TC">Turks and Caicos Islands</option><option value="TV">Tuvalu</option><option value="VI">US Virgin Islands</option><option value="UG">Uganda</option><option value="UA">Ukraine</option><option value="AE">United Arab Emirates</option><option value="GB">United Kingdom</option><option value="US">United States</option><option value="UM">United States Minor Outlying Islands</option><option value="UY">Uruguay</option><option value="UZ">Uzbekistan</option><option value="VU">Vanuatu</option><option value="VA">Vatican City</option><option value="VE">Venezuela</option><option value="VN">Vietnam</option><option value="WF">Wallis and Futuna Islands</option><option value="EH">Western Sahara</option><option value="YE">Yemen</option><option value="ZM">Zambia</option><option value="ZW">Zimbabwe</option></select>
  </div>
</div>

<!-- Telephoneinput-->
<div class="form-group">
	<label class="col-md-4 control-label" for="num">Téléphone Portable : </label>
	<div class="col-md-4">
		<input name="num" id="num" type="tel" onclick="$('#numex').css('display', 'initial');" class="form-control bfh-phone" data-country="countries_phone1" 
	<?php
	/*
		value="<?=$this->Pp->getPhone()?>" 
		*/?>
		
		required="">

		<label style="text-align: left; display: none;" id="numex" class="col-xs-12 control-label" for="num">Ex : +33 6 45 45 45 45</label>
	</div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="mail">Email</label>  
  <div class="col-md-4">
  <input id="mail" name="mail" type="text" placeholder="Email" value="<?=$this->Pp->getMail()?>" class="form-control input-md" required>
    
  </div>
</div>
        
    </div>
    <div class="col-md-6">
<div class="form-group">
  <label class="col-md-4 control-label" for="etat_civil">Etat civil</label>
  <div class="col-md-4">
    <select id="etat_civil" name="etat_civil" class="form-control" value="celibataire">
      <option value="marie" <?=(($this->Pp->getEtatCivil()) ==			"marie"			) ? "selected": ""?>>Marié(e)</option>
      <option value="pacse" <?=(($this->Pp->getEtatCivil()) ==			"pacse"			) ? "selected": ""?>>pacsé(e)</option>
      <option value="celibataire" <?=(($this->Pp->getEtatCivil()) ==	"celibataire"	) ? "selected": ""?>>Célibataire</option>
      <option value="veuf" <?=(($this->Pp->getEtatCivil()) ==			"veuf"			) ? "selected": ""?>>Veuf(e)</option>
      <option value="divorce" <?=(($this->Pp->getEtatCivil()) ==		"divorce"		) ? "selected": ""?>>Divorce</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="regime_matri">Régime matrimonial</label>
  <div class="col-md-4">
    <select id="regime_matri" name="regime_matri" class="form-control">
      <option value="0">-</option>
	  <?php
		foreach (SituationJuridique::$_regimeMatrimonial as $key => $elm)
		{
			?>
			<option value="<?=$key?>" <?= (isset($this->SituationJuridique) && ($this->SituationJuridique->getRegimeMat() == $key)) ? "selected" : "" ?>><?=$elm?></option>
			<?php
		}
	  ?>
    </select>
  </div>
</div>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="enfant">Avez-vous des enfants ?</label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="enfant-0">
      <input type="radio" name="enfant" id="enfant-0" value="1" <?=(isset($this->SituationJuridique) && !empty($this->SituationJuridique->getNbrEnfantCharge())) ? "checked" : ""?>>
      Oui
    </label>
    <label class="checkbox-inline" for="enfant-1">
      <input type="radio" name="enfant" id="enfant-1" value="0" <?=(isset($this->SituationJuridique) && ($this->SituationJuridique->getNbrEnfantCharge() == 0)) ? "checked" : ""?>>
      Non
    </label>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="nbr_enfant">Combien à charge ?</label>  
  <div class="col-md-4">
  <input id="nbr_enfant" min="0" name="nbr_enfant" type="number" value="<?=(isset($this->SituationJuridique)) ? $this->SituationJuridique->getNbrEnfantCharge() : ""?>" placeholder="" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="autres_charge">Avez vous d’autres personnes à charge ?</label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="autres_charge-0">
      <input type="radio" name="autres_charge" id="autres_charge-0" value="1" <?=(isset($this->SituationJuridique) && !empty($this->SituationJuridique->getNbrPersonnesCharge())) ? "checked" : ""?>>
      Oui
    </label>
    <label class="checkbox-inline" for="autres_charge-1">
      <input type="radio" name="autres_charge" id="autres_charge-1" value="0" <?=(isset($this->SituationJuridique) && ($this->SituationJuridique->getNbrPersonnesCharge() == 0)) ? "checked" : ""?>>
      Non
    </label>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="nbr_autres">Combien ?</label>  
  <div class="col-md-4">
  <input id="nbr_autres" min="0" name="nbr_autres" type="number" placeholder=""  value="<?=(isset($this->SituationJuridique)) ? $this->SituationJuridique->getNbrPersonnesCharge() : ""?>" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="us_person">US Person ?</label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="us_person-0">
      <input type="radio" name="us_person" id="us_person-0" value="1" <?=($this->Pp->getUsPerson()) ? "checked" : ""?>>
      Oui
    </label>
    <label class="checkbox-inline" for="us_person-1">
      <input type="radio" name="us_person" id="us_person-1" value="0" <?=(!$this->Pp->getUsPerson()) ? "checked" : ""?>>
      Non
    </label>
  </div>
</div>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="politique">Personne politique exposée ?</label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="politique-0">
      <input type="radio" name="politique" id="politique-0" value="1" <?=($this->Pp->getPolitiquementExpose()) ? "checked" : ""?>>
      Oui
    </label>
    <label class="checkbox-inline" for="politique-1">
      <input type="radio" name="politique" id="politique-1" value="0" <?=(!$this->Pp->getPolitiquementExpose()) ? "checked" : ""?>>
      Non
    </label>
  </div>
</div>
        
    </div>
</div>


</fieldset>

	<input type="hidden" name="id_phs"  value="<?=$this->Pp->id_phs?>"/>
	<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
	<input type="hidden" name="action" id="" value="setSituationJuridique" />
	<input style="margin-top: 20px;" class="tosend" type="image" src="view/img/btn_1_hd.JPG" name="send" value="send">
	<?php
	//<button  id="sendBtn" class="tosend"  style="margin-top: 20px;margin-bottom: 20px;" />
	?>
</form>

