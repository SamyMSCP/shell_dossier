</script>
<script type="text/javascript" charset="utf-8">

$('.radio').click(function() {
   if($('#forwhom-1').is(':checked') || $('#forwhom-2').is(':checked') || $('#forwhom-3').is(':checked') || $('#forwhom-4').is(':checked')) {
    $(".mod_2").css("display", "inherit");
    $(".mod_1").css("display", "none");
    $("#el_1").css("background-color", "#039841");
    $("#el_1").css("border-color", "#039841");
    }
});
    function ft_rewrite_v(){
        var oInput = document.getElementById('sortable');
        for(i = 1; i < oInput.childNodes.length; i+= 2){
            oInput.childNodes[i].value = i;
        }
    }

$( function() {
     $( "#sortable" ).sortable({
      revert: true
    });
 });


    function ft_switch_at_3(){
        if ($(".mod_1").css("display") == "none" && $("#el_2").css("background-color") != "rgb(3, 152, 65)"){
            $(".mod_3").css("display", "inherit");
            $(".mod_2").css("display", "none");
            $("#el_2").css("background-color", "#039841");
            $("#el_2").css("border-color", "#039841");
        }
    }
    $('.radio').click(function() {
   if($('#invest-1').is(':checked') || $('#invest-2').is(':checked') || $('#invest-3').is(':checked') || $('#invest-4').is(':checked')) {
    $(".mod_4").css("display", "inherit");
    $(".mod_3").css("display", "none");
    $("#el_3").css("background-color", "#039841");
    $("#el_3").css("border-color", "#039841");
    }
});

$('#yes').click(() => {
   if($('#yes').is(':checked')) {
    $(".mod_4").css("display", "none");
    $(".mod_5").css("display", "inherit");
    $("#el_4").css("background-color", "#039841");
    $("#el_4").css("border-color", "#039841");
    }
});




$('#yes_2').click(() => {
   if($('#yes_2').is(':checked')) {
    $(".mod_5").css("display", "none");
    $("#el_5").css("background-color", "#039841");
    $("#el_5").css("border-color", "#039841");
    }
});
$('#no_2').click(() => {
   if($('#no_2').is(':checked')) {
    $(".mod_5").css("display", "none");
    $("#el_5").css("background-color", "#039841");
    $("#el_5").css("border-color", "#039841");
    }
});
