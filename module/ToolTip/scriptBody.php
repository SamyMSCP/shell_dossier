</script>
<script>

function disable_msg(e){
	var event = window.event || e;

	document.getElementById("msg_help").setAttribute("style", "position: absolute; left: " + (event.pageX) + "px; top: " + (event.pageY + 20) +"px; display: none;");
}

function display_tooltip_table_head($title, $msg, e){
	var event = window.event || e;
	document.getElementById("msg_help").children[0].innerHTML = "<h4>" + $title + "</h4>" + "<p style='font-weight=normal'>" + $msg + "</p>";
	document.getElementById("m_more").innerHTML = "";
	var msgWidth = $("#msg_help").width() / 2;
	var msgHeight = $("#msg_help").height();
	document.getElementById("msg_help").setAttribute("style", "background: rgba(255,255,255,1); z-index: 3048;position: absolute; left: " + (event.pageX - msgWidth) + "px; top: " + (event.pageY - (40 + msgHeight)) +"px; display: initial;");
}

function display_tooltip($title, $msg, e){
	var event = window.event || e;
	document.getElementById("msg_help").children[0].innerHTML = "<h4>" + $title + "</h4>" + "<p style='font-weight=normal'>" + $msg + "</p>";
	document.getElementById("m_more").innerHTML = "";
	document.getElementById("msg_help").setAttribute("style", "max-width:300px; background: rgba(255,255,255,1); z-index: 3048;position: absolute; left: " + (event.pageX - msgWidth) + "px; top: " + (event.pageY + 20) +"px; display: initial;");
	var msgWidth = document.getElementById("msg_help").getBoundingClientRect().width;
	var msgHeight= document.getElementById("msg_help").getBoundingClientRect().height;
	document.getElementById("msg_help").setAttribute("style", " left: " + (event.pageX - msgWidth) + "px; top: " + (event.pageY + 20) +"px; display: initial;");
	$('#msg_help').addClass('toolTipShow');
}

$('#msg_help').on('click', function(event) {
	disable_msg(event);
})
