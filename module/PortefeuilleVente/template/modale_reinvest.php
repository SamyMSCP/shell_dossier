<?php
/**
 * Created by PhpStorm.
 * User: vthomas
 * Date: 20/02/2018
 * Time: 17:14
 */
?>
<div class="modal fade"  role="dialog" aria-labelledby="myLargeModalLabel" id="modale_vente">
	<div class="modal-backdrop fade in"></div>
	<div class="modal-dialog" style="z-index:1100">
		<div class="modal-content" style="background-color:#EBEBEB;">
			<div class="modal-body">
				<div data-dismiss="modal" aria-label="Close" class="btn_close_prepapre">
					<span aria-hidden="true" class="btn_close">×</span>
				</div>
				<h2 style="text-align: center;">Information</h2>
				<div>
					<hr class="hr_bar">
				</div>
				<div class="row" style="margin: 30px 0;">

					<div class="col-md-6">
					<!-- data-toggle="modal" data-dismiss="modal" data-target="#modale_list_transact" -->
						<div class="button grey text-uppercase left">
							Je cede des parts sur une transactions
						</div>
					</div>
					<div class="col-md-6">
						<div class="button orange text-uppercase" data-toggle="modal"  data-dismiss="modal"  @click="demandeContact" style="">
							Je souhaite vendre des parts avec mon conseiller
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
