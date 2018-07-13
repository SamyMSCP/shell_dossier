<script>
var test = {
					'date' : 'Créé le 10 septembre 2016',
					'benef' : 'M Dupont',
					'budget' : '1 000 000 €',
					'finance' : 'Comptant',
					'obj1' : 'EXEMPLE',
					'obj2' : 'OBJ2',
					'obj3' : 'object 3',
					'simulation' : { 'titre' : ['titre 1', 'titre 2', 'titre 3', 'titre 4'],
									  'data' : [
									  				["data", "data", "data", "data"],
									  				["data", "data", "data", "data"],
									  				["data", "data", "data", "data"]
									  			]
									},
					'portefeuille' : { 'titre' : ['titre 1', 'titre 2', 'titre 3', 'titre 4', 'titre 5', 'titre 6'],
									  'data' : [
									  				["data", "data", "data", "data", "data", "data"],
									  				["data", "data", "data", "data", "data", "data"],
									  				["data", "data", "data", "data", "data", "data"]
									  			]
									},
					'profils' : { 'titre' : ['titre 1', 'titre 2', 'titre 3', 'titre 4'],
								'data' : [
									  				["data", "data", "data", "data"],
									  				["data", "data", "data", "data"],
									  				["data", "data", "data", "data"]
									  			],
								'total' : '1 000 000€'
									}
			}
</script>

<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModalProjet" onclick="modalTplProjet(test)">
  Launch demo modal
</button>


<div id="myModalProjet" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content modalViewBeneficiaireContent">
			<!--header-->
			<div class="row">
				<div class="col-md-10">
					<div style="display: inline-block;">
						<h2 class="pull-left">EPARGNE ÉTUDES</h2>
						<p class="gris" id="tplModalDate">Créé le 10 septembre 2016</p>
					</div>
				</div>
				<div class="col-md-2">
					<div class="modalViewBeneficiaireBntClose" data-dismiss="modal" aria-label="Close">
						<img src="<?=$this->getPath()?>img/Close-Jaune.svg" alt="">
					</div>
				</div>
			</div>
			<!--Endheader-->
			<!--block-->
			<div class="row">
				<div class="col-md-4">
					<div class="blockInfoModal">
						<h3 class="blockInfoModalTitle">DÉTAILS DU PROJET</h3>
						<div class="traitDonneurModalViewBeneficiairePp"></div>
						<div class="row">
							<div class="col-md-5">
								<p class="blockInfoModalLabel">Bénéficiaire(s)</p>
							</div>
							<div class="col-md-7">
								<p class="blockInfoModalResp" id="tplModalBenef">M. Edouard ROUSSEAU</p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-5">
								<p class="blockInfoModalLabel">Budget</p>
							</div>
							<div class="col-md-7">
								<p class="blockInfoModalResp" id="tplModalBudget">....</p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-5">
								<p class="blockInfoModalLabel">Type de financement</p>
							</div>
							<div class="col-md-7">
								<p class="blockInfoModalResp" id="tplModalFinance">Comptant</p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="blockInfoModal">
						<h3 class="blockInfoModalTitle">OBJECTIFS</h3>
						<div class="traitDonneurModalViewBeneficiairePp"></div>
						<div class="row">
							<div class="col-md-2">
								<p class="blockInfoModalLabel">1</p>
							</div>
							<div class="col-md-10" style="text-align: left;">
								<p class="blockInfoModalResp" id="tplModalobj1">Percevoir des revenus réguliers</p>
							</div>
							<div class="col-md-2">
								<p class="blockInfoModalLabel">2</p>
							</div>
							<div class="col-md-10" style="text-align: left;">
								<p class="blockInfoModalResp" id="tplModalobj2">Percevoir des revenus réguliers</p>
							</div>
							<div class="col-md-2">
								<p class="blockInfoModalLabel">3</p>
							</div>
							<div class="col-md-10" style="text-align: left;">
								<p class="blockInfoModalResp"  id="tplModalobj3">Percevoir des revenus réguliers</p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="blockInfoModal">
						<h3 class="blockInfoModalTitle">VOTRE CONSEILLER</h3>
						<div class="traitDonneurModalViewBeneficiairePp"></div>
					</div>
				</div>
			</div>
			<!--Endblock-->
			<!--BTN-->
			<div class="ongletsBoutons2">
				<ul id="allbtnonglet">
					<li class="onglets2Btn BtnProjet selected" onclick="showInOnglet(this, 'simulation')">
						SIMULATIONS<br>& COMPARAISONS
					</li>
					<li class="onglets2Btn BtnSituation" onclick="showInOnglet(this, 'portefeuille')">
						PORTEFEUILLE DE<br>SCPI PROPOSÉES
					</li>
					<li class="onglets2Btn BtnSituation" onclick="showInOnglet(this, 'profils')">
						VOS PROFILS<br>D’INVESTISSEURS
					</li>
					<li class="onglets2Btn BtnSituation" onclick="showInOnglet(this, 'notification')">
						NOTIFICATIONS
					</li>
					<li class="onglets2btn btnsituation" onclick="showInOnglet(this, 'question')">
						QUESTIONS<br>& RÉPONSES
					</li>
				</ul>
			</div>
			<!--EndBTN-->
			<!--ViewPage-->
			<div class="blockOnglet2">
				<div id="pageView">
					<div id="simulation" class="">
					</div>
					<div id="portefeuille" class="notDisplay">
					</div>
					<div id="profils" class="notDisplay">
					</div>
					<div id="notification" class="notDisplay">
						
						<div id="notificationTable" class="escape notificationTable">
							<div class="escape block-top" style="margin-left: 0%;">
								<div class="escape bulle-top">
									<h3>Text ici</h3>
								</div>
								<div class="escape flecheTop"></div>
								<h4 class="notificationDate">DATE</h4>
								<div class="escape bullePictoTop">
									<img src="<?=$this->getPath()?>img/EnCoursCreation-Orange.svg">
								</div>
							</div>
							<div class="escape block-top">
								<div class="escape bulle-top">
									<h3>Text ici</h3>
								</div>
								<div class="escape flecheTop"></div>
								<h4 class="notificationDate">DATE</h4>
								<div class="escape bullePictoTop">
									<img src="<?=$this->getPath()?>img/EnCoursCreation-Orange.svg">
								</div>
							</div>
						</div>
						
							<div class="escape flecheLeft"></div>
							<div class="escape traitDonneurModalNotification"></div>
							<div class="escape flecheRight"></div>

						<div id="notificationTable" class="escape notificationTable">
							<div class="escape block-down">
								<div class="escape bullePictoBottom">
									<img src="<?=$this->getPath()?>img/EnCoursCreation-Orange.svg">
								</div>
								<h4 class="notificationDate">DATE</h4>
								<div class="escape flecheBottom"></div>
								<div class="escape bulle-down">
									<h3>Text ici</h3>
								</div>
							</div>
							<div class="escape block-down">
								<div class="escape bullePictoBottom">
									<img src="<?=$this->getPath()?>img/EnCoursCreation-Orange.svg">
								</div>
							<h4 class="notificationDate">DATE</h4>
							<div class="escape flecheBottom"></div>
								<div class="escape bulle-down">
									<h3>Text ici</h3>
								</div>
							</div>
						</div>
					
					</div>
					<div id="question" class="notDisplay">
					</div>
				</div>
			</div>
			<!--ENDViewPage-->
		</div>
	</div>
</div>

<script>
function showInOnglet(that, what) {
	var li = document.getElementById('allbtnonglet').getElementsByTagName('li');
	for (i = 0; i < li.length; i++){
		li[i].className = "onglets2Btn BtnProjet";
	}
	that.className = that.className + " selected"
	var div = document.getElementById('pageView').getElementsByTagName('div');
	for (i = 0; i < div.length; i++){
		if (div[i].className != "notDisplay" && div[i].className.indexOf("escape"))
			div[i].className = "notDisplay";
	}
	document.getElementById(what).className = ""
}

function genTable(id, res)
{
	//create table
	var table = document.createElement('table')
	table.className = "tableLstProject"
	var thead = document.createElement('thead')
 	var tr = document.createElement('tr');   
	for (var i = 0; i < res.titre.length; i++){
    	var td = document.createElement('th')
    	td.innerHTML = res.titre[i];
    	tr.appendChild(td)
	}
	thead.appendChild(tr)
	var tbody = document.createElement('tbody')
	for (i = 0; res.data.length > i; i++) {
		tr = document.createElement('tr')
		var len = res.data[i].length
		var	tmp = res.data[i]
		for (var x = 0; len > x; x++){
			td = document.createElement('td')
			var text = tmp[x]
			td.innerHTML = text
			td.style.textAlign = "center"
			tr.appendChild(td)
		}
		tbody.appendChild(tr)
	}
	if (typeof res.total !== "undefined"){
		tr = document.createElement('tr')
		tr.style.borderTop = "2px solid #1781e0"
		td = document.createElement('td')
		td.colSpan = res.data[0].length - 2
		tr.appendChild(td)
		td = document.createElement('td')
		td.innerHTML = "MONTANT TOTAL DU PROJET"
		td.style.color = "#1781e0"
		td.style.textAlign = "center"
		tr.appendChild(td)
		td = document.createElement('td')
		td.style.color = "#1781e0"
		td.style.textAlign = "center"
		td.innerHTML = res.total
		tr.appendChild(td)
		tbody.appendChild(tr)
	}
	table.appendChild(thead)
	table.appendChild(tbody)
	if (document.getElementById(id).hasChildNodes())
		document.getElementById(id).removeChild(document.getElementById(id).childNodes[0])
	document.getElementById(id).appendChild(table)

}

function modalTplProjet(tab){
	//tab = JSON.parse(tab)
	console.log(tab)
	document.getElementById('tplModalDate').innerHTML = tab.date
	document.getElementById('tplModalBenef').innerHTML = tab.benef
	document.getElementById('tplModalBudget').innerHTML = tab.budget
	document.getElementById('tplModalFinance').innerHTML = tab.finance

	genTable('simulation', tab.simulation)
	genTable('portefeuille', tab.portefeuille)
	genTable('profils', tab.profils)

	document.getElementById('tplModalobj1').innerHTML = tab.obj1
	document.getElementById('tplModalobj2').innerHTML = tab.obj2
	document.getElementById('tplModalobj3').innerHTML = tab.obj3



	// document.getElementById('tplModalBenef').innerHTML = tab.benef
	// document.getElementById('tplModalBenef').innerHTML = tab.benef
	// document.getElementById('tplModalBenef').innerHTML = tab.benef
	// document.getElementById('tplModalBenef').innerHTML = tab.benef
	// document.getElementById('tplModalBenef').innerHTML = tab.benef
	// document.getElementById('tplModalBenef').innerHTML = tab.benef
}
</script>
