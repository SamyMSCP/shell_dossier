<div class="container-fluid container-features">
	<div class="row">
		<div class="col-sm-4 feat text-uppercase">
			<div class="media">
				<div class="media-left media-top">
						<img src="<?= $this->getPath() ?>res/blue.svg" class="blue">
				</div>
				<div class="media-body">
					<h4><?=$this->b0?></h4>
				</div>
			</div>
		</div>
		<div class="col-sm-4 feat text-uppercase">
			<div class="media">
				<div class="media-left media-top">
					<img src="<?= $this->getPath() ?>res/blue.svg" class="blue">
				</div>
				<div class="media-body">
					<h4><?=$this->b1?></h4>
				</div>
			</div>
		</div>
		<div class="col-sm-4 feat text-uppercase">
			<div class="media">
				<div class="media-left media-top">
					<img src="<?= $this->getPath() ?>res/blue.svg" class="blue">
				</div>
				<div class="media-body">
					<h4><?=$this->b2?></h4>
				</div>
			</div>
		</div>
	</div>
	<?php if (isset($this->legend)) { ?>
	<div class="row">
		<div class="col-xs-12 legend">
			<?= $this->legend ?>
		</div>
	</div>
	<?php } ?>
</div>