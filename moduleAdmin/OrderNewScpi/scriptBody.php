</script>
<script>
function prettyPrint(el) {
    var ugly = el.value;
    var obj = JSON.parse(ugly);
    var pretty = JSON.stringify(obj, undefined, 4);
    el.value = pretty;
}