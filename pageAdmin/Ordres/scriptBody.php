</script>
<script>
var vueInstance = new Vue({
	el: '.vueApp_tordres'
});

function updateText(input){
    input.value = parseFloat(input.value.replace(",", "."));
    if (input.value === NaN || input.value === "NaN")
        input.value = 0.00;
    input.value = parseFloat(input.value).toFixed(2);
}

function changeFloat(form)
{
    updateText(form.elements['price']);
    return (true);
}