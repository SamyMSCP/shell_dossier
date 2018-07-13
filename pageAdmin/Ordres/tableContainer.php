<div>
    <div class="modal fade" role="dialog" id="modal-validating">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
                    <h2 class="modal-title">
                        Entrez une recommandation de prix net vendeur
                    </h2>
                </div>
                <div class="modal-body">
                    <form action="" target="_blank" method="get" id="form-load-pdf" onsubmit="return changeFloat(this)">
                        <input type="hidden" name="scpi" v-model="scpi_name"/>
                        <input type="hidden" name="p" value="ShowValeurOrdres"/>
                        <div class="input-group">
                            <input class="form-control" name="price" type="text" step="0.01" value="1.00" onchange="updateText(this);">
                            <span class="input-group-addon">&euro;</span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <button class="btn btn-danger col-lg-2 col-lg-offset-7" data-dismiss="modal">
                            Annuler
                        </button>
                        <button class="btn btn-success col-lg-2" data-dismiss="modal" onclick="$('#form-load-pdf').submit();">
                            Confirmer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <h1 class="col-lg-12 text-center"><u>{{scpiFormatter}}</u></h1>
    </div>
    <div class="row">
        <div class="form-group">
            <select class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-xs-12 btn" v-model="scpi_name">
                <option v-for="cur_scpi in $store.state.order_society.lst" v-bind:value="cur_scpi.id">{{cur_scpi.name}}</option>
            </select>
			<a class="btn btn-primary" v-bind:href="scpiGetUrl" target="_blank"><i class="fa fa-link"></i></a>
        </div>
    </div>
    <br>
    <div class="row">
        <img class="col-lg-6 col-md-6 col-xs-12" v-bind:src="imgAchat"/>
        <img class="col-lg-6 col-md-6 col-xs-12" v-bind:src="imgVente"/>
    </div>
    <div class="row">
        <span class="col-lg-3">*NR: Non Renseign&eacute;</span>
    </div>
    <div class="row">
        <!--
        <a v-bind:href="showPdfUrl" target="_blank">
            <div class="btn btn-primary col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-xs-12">T&eacute;l&eacute;charger le carnet d'ordre</div>
        </a>-->
        <div data-toggle="modal" data-target="#modal-validating" class="btn btn-primary col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-xs-12">T&eacute;l&eacute;charger le carnet d'ordre</div>
    </div>
</div>
