<?php
/**
 * Created by PhpStorm.
 * User: vthomas
 * Date: 16/10/2017
 * Time: 17:34
 */
?>
<div class="container-fluid">
    <div class="row">
        <h1>Ajout de SCPI</h1>
    </div>
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3 input-group">
            <span class="input-group-addon">SCPI:</span>
            <select class="form-control">
                <option value="-1"><i>Nouvelle SCPI</i></option>
                <option v-for="el in $store.state.scpi.lst" value="el.id">{{el.name}}</option>
            </select>
            <span class="input-group-addon btn"><i class="fa fa-wrench"></i></span>
        </div>
        <div class="col-lg-6 col-lg-offset-3 input-group">
            <span class="input-group-addon">Societe de gestion:</span>
            <select class="form-control">
                <option value="-1"><i>Nouvelle societe de gestion</i></option>
                <option v-for="el in $store.state.order_society_list.lst" value="el.id">{{el.name}}</option>
            </select>
            <span class="input-group-addon btn" data-toggle="modal" data-target="#new-soc"><i class="fa fa-wrench"></i></span>
        </div>
    </div>
    <div class="row">
        <div class="input-group col-lg-6 col-lg-offset-3">
            <span class="input-group-addon">URL</span>
        <input class="form-control" type="url">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <hr/>
        </div>
    </div>
    <div class="row">
        <div class="btn btn-success col-lg-2 col-lg-offset-7">Valider</div>
    </div>
    <div class="modal fade" role="dialog" id="new-soc">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-2 col-lg-offset-10">
                                ID: [XXX]
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-group col-lg-12">
                                <span class="input-group-addon">Nom:</span>
                                <input class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-group col-lg-12">
                                <span class="input-group-addon">Tableau:</span>
                                <input class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-group col-lg-12">
                                <span class="input-group-addon">Ligne:</span>
                                <input class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-group col-lg-12">
                                <span class="input-group-addon">Valeur:</span>
                                <input class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="btn btn-primary col-lg-2 col-lg-offset-7"><i class="fa fa-floppy-o"></i></div>
                            <div class="btn btn-danger col-lg-2 col-lg-offset-1" data-dismiss="modal">Annuler</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
