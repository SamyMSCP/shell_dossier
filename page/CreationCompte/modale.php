<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Fiche d’informations légales - Meilleurescpi.com</h4>
      </div>
      <div class="modal-footer">
		<div class="forButton">
			<div>
				<button onClick="$('#beta').trigger('click'); $('#myModal').modal('hide');" class="btn-mscpi">
					CONTINUER
				</button>
			</div>
		</div>
      </div>
      <div class="modal-body">
        <div class="embed-responsive embed-responsive-16by9">
			<?php
			if (count($this->linkFIL))
			{
				$this->linkFIL = $this->linkFIL[0];
				?>
				<iframe class="embed-responsive-item" src='Download.php?idDocument=<?=$this->linkFIL->id?>#zoom=100'></iframe>
				<?php
			}
			else
			{
				?>
					<span>Il n'y a pas de document ici</span>
				<?php
			}
			?>
        </div>
      </div>
      <div class="modal-footer">
		<div class="forButton">
			<div>
				<button onClick="$('#beta').trigger('click'); $('#myModal').modal('hide');" class="btn-mscpi">
					CONTINUER
				</button>
			</div>
		</div>
      </div>
    </div>
  </div>
</div>
</div>



<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Conditions générales d’utilisation - Meilleurescpi.com</h4>
      </div>
      <div class="modal-footer">
		<div class="forButton">
			<div>
				<button onClick="$('#myModal').modal('hide'); $('#myModal2').modal('hide'); $('#beta').trigger('click');"  class="btn-mscpi">
					CONTINUER
				</button>
			</div>
		</div>
      </div>
      <div class="modal-body">
        <div class="embed-responsive embed-responsive-16by9">
			<?php
			if (count($this->linkCGU))
			{
				$this->linkCGU = $this->linkCGU[0];
				?>
				<iframe class="embed-responsive-item" src='Download.php?idDocument=<?=$this->linkCGU->id?>#zoom=100'></iframe>
				<?php
			}
			else
			{
				?>
					<span>Il n'y a pas de document ici</span>
				<?php
			}
			?>
        </div>
      </div>
      <div class="modal-footer">
		<div class="forButton">
			<div>
				<button onClick="$('#myModal').modal('hide'); $('#myModal2').modal('hide'); $('#beta').trigger('click');"  class="btn-mscpi">
					CONTINUER
				</button>
			</div>
		</div>
      </div>
    </div>
  </div>
</div>
</div>
<?php Notif::getAll(); ?>
