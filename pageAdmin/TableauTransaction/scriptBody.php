</script>
<script>
var app = new Vue({
    el: ".vueApp",
    data: {
        date: {
            start: moment().subtract(1, 'months').format('DD/MM/YYYY'),
            end: moment().format('DD/MM/YYYY')
        },
        date_tmp: {
            start: moment().subtract(7, 'months').format('DD/MM/YYYY'),
            end: moment().format('DD/MM/YYYY')
        },
        select: {
            edit: false,
            data: ["enr"]
        },
        select_tmp: {
            edit: false,
            data: ["enr"]
        },
        mscpi: 1,
        socgest: "",
        namesearch: "",
        socgest_tmp: "",
        namesearch_tmp: ""
    },
    store: store,
    methods: {
        updateTransac: function () {
        },
        getLegend: function (index) {
            var x = store.state.transactstatestore.lstStatusTransaction[index];
            var text = "";
            var i = 0;
            while (i < x.length){
                text += "<u>" + index + "-" + i + ":</u> " + x[i].title + "<br>";
                i++;
            }
            return text;
        },
        applyFilters: function () {
            var self = this;
            swal({
                title: "Application des filtres",
                text: "",
                allowOutsideClick: () => !swal.isLoading(),
                showConfirmButton: false,
                onOpen: () => {
                    // console.log("date: ", self.date.start);
                    // console.log("tmp: ", self.date_tmp.start);
                    //swal.showLoading();
                    Vue.http.post('/ajax_request.php', {
                        req: 'ajaxTransaction',
                        action: 'read',
                        token: "<?= $_SESSION['csrf'][0] ?>",
                        data: JSON.stringify({
                            start: moment(self.date_tmp.start, 'DD-MM-YYYY').format('X'),
                            end: moment(self.date_tmp.end, 'DD-MM-YYYY').add(1, 'd').format('X'),
                            who: self.namesearch_tmp,
                            socgest: self.socgest_tmp,
                            d_sel: self.select_tmp.data,
                            token: "<?= $_SESSION['csrf'][0] ?>",
                        }),
                    }, {emulateJSON: true}).then(function (res) {
                        console.warn(res);
                        self.socgest = self.socgest_tmp;
                        let ct = (res.body);
                        ct.socgest = self.socgest;
                        var trs = ct.transactions.filter((el) => {
                            if (self.mscpi === 0)
                                return (true);
                            if (self.mscpi === 1)
                                return (el.fait_par_mscpi === "1");
                            return (el.fait_par_mscpi === "0");
                        });
                        ct.transactions = trs;
                        console.log(ct);
                        store.commit('CHANGE_LIST_FROM_AJAX', ct);
                        swal.close();
                    }, function (res) {
                        swal({
                            type: "error",
                            title: "Impossible d'appliquer le filtre:",
                            text: res.body.err,
                            width: 780
                        })
                    });
                }
            });
        }
    },
    filters: {
        moment: function (date) {
            return moment.unix(date).format('DD / MM / Y');
        },
        mois: function (date) {
            return moment.unix(date).format('MM');
        }
    },
    mounted: function () {
        $(document).ready(function(){
//			$('[data-toggle="tooltip"]').tooltip({html: true});
// 			console.log(app);
            app.applyFilters();
        });
    }
});



$(function () {
    $(".datepicker").datepicker({dateFormat: "dd/mm/yy"});
});
/*$('.t-visu').dataTable(
    {
        searching: false,
        ordering: false,
        info: false,
        scrollY: "70vh",
        scrollCollapse: true,
        paging: false,

    });*/

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip({html: true});
});