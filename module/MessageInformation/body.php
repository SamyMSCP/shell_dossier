<div class="modal fade modal-mscpi" id="<?=$this->tag?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="<?= $this->getPath() ?>img/Close-Jaune.svg" alt="" /></button>
        <h4 class="modal-title text-center">Information</h4>
        <div class="modal-trait"></div>
      </div>
      <div class="modal-body">
<?php
if (!empty($this->path)) include($this->path);
else if (!empty($this->content)) echo $this->content;
?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>
