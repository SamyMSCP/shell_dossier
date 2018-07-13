</script>
<script type="text/javascript" charset="utf-8">
function init_SuiviClient() {
}

function strcmp(str1,str2){
	myDate = str1.split("-");
	myDate2 = str2.split("-");
	var newDate = myDate[1] + "," + myDate[2] + "," + myDate[0];
	var newDate2 = myDate2[1] + "," + myDate2[2] + "," + myDate2[0];
   str1 = new Date(newDate).getTime();
   str2 = new Date(newDate2).getTime();
   return ( (str1  == str2 ) ? 0 : ( ( str1 > str2 ) ? 1 : -1 ) );
}

$(document).ready(function(){

    var progress = setInterval(function() {
    var $date = $('#date1');
    var $datep = $('#date2');

    if (strcmp($datep.val(), $date.val()) >= 0)
      $('.errormsg').css('visibility', 'hidden');
    else
      $('.errormsg').css('visibility', 'visible');
  }, 200);
});

function crm2(){
	$('.phase1').css('display', 'none');
	$('.phase2').css('display', 'initial');
}
function crm3(){
	$('.phase2').css('display', 'none');
	$('.phase3').css('display', 'initial');
}
function crm4(){
	$('.phase3').css('display', 'none');
	$('.phase4').css('display', 'initial');
}
function crm5(){
	$('.phase4').css('display', 'none');
	$('.phase5').css('display', 'initial');
}
var Global_btn = 0;
function btnqa(){
	if (document.getElementById("qa").style.opacity == "0.5")
	{
		Global_btn -= 1;
		document.getElementById("qa").style.opacity = "1"
	}
	else
	{
		Global_btn += 1;
		document.getElementById("qa").style.opacity = "0.5";
	}
	if (!Global_btn)
		document.getElementById("valide_btn").style.display = "none";
	else
		document.getElementById("valide_btn").style.display = "inline-block";
}
function selected_btn(that){
	document.getElementById('selected_btn_1').style.opacity = "0.5"
	document.getElementById('selected_btn_2').style.opacity = "0.5"
	document.getElementById('selected_btn_3').style.opacity = "0.5"
	document.getElementById('selected_btn_4').style.opacity = "0.5"
	that.style.opacity = "1"
}

function btnEtudes(){
	if (document.getElementById("Etudes").style.opacity == "0.5")
	{
		Global_btn -= 2;
		document.getElementById("Etudes").style.opacity = "1"
	}
	else
	{
		Global_btn += 2;
		document.getElementById("Etudes").style.opacity = "0.5";
	}
	if (!Global_btn)
		document.getElementById("valide_btn").style.display = "none";
	else
		document.getElementById("valide_btn").style.display = "inline-block";
}

function crm6(){
	$('.phase4').css('display', 'none');
	$('.phase5').css('display', 'none');
	if (Global_btn == 0)
		document.getElementById('action_r').value = 'Rien';
	else if (Global_btn == 1)
		document.getElementById('action_r').value = 'Etudes';
	else if (Global_btn == 2)
		document.getElementById('action_r').value = 'Q/A';
	else
		document.getElementById('action_r').value = 'Etudes & Q/A';
	//document.getElementById('action_r_picto').value = Global_btn;
	$('.phase6').css('display', 'initial');
}
