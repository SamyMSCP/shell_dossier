<div class="container">
	<?=$this->Nav?>
      <div class="col-lg-12">
          <div class="well">
        <div class="row">
        <div class="col-lg-12">
            <table class="table" id="table" style="background-color: #01528A; border: 2px solid;">
                <thead>
                    <tr>
                        <th>Personne(s)</th>
                        <th>Date d'ajout</th>
                        <th>Type document</th>
                        <th>Date fin de validité</th>
                        <th>Historique</th>
                        <th>Aperçu</th>
                        <th>Charger</th>
                        <th>Inviter à mettre à jour</th>
                    </tr>
                </thead>
            <tbody>
               <!--  style="background-color: rgb(245, 245, 245);
                style="background-color: rgb(255, 255, 255);" -->
                <tr class="danger">
                        <td>Pas de db</td>
                        <td>Pas de db</td>
                        <td>Pas de db</td>
                        <td>Pas de db</td>
                        <td><a href=""><img src="img/history.png" style="width: 30px;"></a></td>
                        <td>Pas de db</td>
                        <td>Pas de db</td>
                        <td>Pas de db</td>
                    </tr>
                </tbody>
            </table>
            <hr>
        </div>
        </div>
            <a href="" class="btn btn-default" data-toggle="modal" data-target=".bs-example-modal-lg" style="position: absolute; right: 20px; bottom: 25px;"><img src="img/add.ico" style="width: 30px;"> Ajouter un document</a>
            </div>
        </div>

<div class="modal fade in bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
<!-- <div class="modal-backdrop fade in" style="height: 675px;"></div> -->
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
           <span aria-hidden="true">×</span>
          <span class="sr-only">Close                    </span>
         </button>
       <h4 class="modal-title">
            Type de documents
       </h4>
           <select class="selectpicker" data-live-search="true">
              <option value="CNI">CNI</option>
              <option value="RIB">PASSPORT</option>
              <option value="Justificatif de domicile">Justificatif de domicile</option>
              <option value="RIB">RIB</option>
              <option value="CNI Dirigeant">PM : CNI Dirigeant</option>
              <option value="KBIS">PM : KBIS</option>
              <option value="Status">PM : Status</option>
              <option value="Compte résultat N-1">PM : Compte résultat N-1</option>
              <option value="Compte résultat N-2">PM : Compte résultat N-2</option>
              <option value="Compte résultat N-3">PM : Compte résultat N-3</option>
              <option value="Bilan N-1">PM : Bilan N-1</option>
              <option value="Bilan N-2">PM : Bilan N-2</option>
              <option value="Bilan N-3">PM : Bilan N-3</option>
              <option value="PM : RIB">PM : RIB</option>
           </select>
      </div> 
      <div class="modal-body">
                      <input type="file" accept=".pdf" multiple="multiple">
                        <div class="container-fluid bfd-files"></div>
    <br>   
<div class="form-group">

  <div class="col-ms-6">
    <div class="input-group">
      <span class="input-group-addon">Expiration</span>
      <input class="datepicker" name="prependedtext" class="form-control" placeholder="Action Réaliser" type="text">
    </div>
    
  </div>
   <script>
      
     $('.datepicker').datepicker({
     dateFormat: 'dd-mm-yy',
     minDate: '+5d',
     changeMonth: true,
     changeYear: true,
     altFormat: "yy-mm-dd",
     language:"fr",
     closeText: 'Fermer'
    });
</script>
</div>
    
<br>
           <select class="selectpicker" data-live-search="true">
            <option value="Cni">Héléne Dupont</option>
              <option value="RIB">Hervé Dupont</option>
            </select>


       </div>
       <div class="modal-footer">
            <button type="button" class="btn btn-primary bfd-ok">Envoi               </button>
            <button type="button" class="btn btn-default bfd-cancel" data-dismiss="modal">Retour                </button>
       </div>
</div>
</div>
</div>

        
</div>
