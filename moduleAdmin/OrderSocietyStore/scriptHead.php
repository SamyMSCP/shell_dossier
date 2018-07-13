</script>
<script type="text/javascript" charser="utf-8">
    store.registerModule('order_society_list', {
        state: {
            lst: <?= json_encode($this->societylist) ?>
        },
        getters: {
            getSocietyFromId: function(state, getters) {
                return (function (id){
                    for (i = 0; state.lst.length > i; i++) {
                        if (parseInt(state.lst[i]['id']) == id)
                            break;
                    }
                    if (parseInt(state.lst[i]['id']) == id)
                        return (state.lst[i]);
                    return ({
                        index_el: "",
                        is_multi: "",
                        is_shuffle: "",
                        name: "",
                        row: "",
                        sort_a: "",
                        sort_v: "",
                        tab: "",
                        v_before_a: "",
                        val: ""
                    });
                });
            },
        }
    });