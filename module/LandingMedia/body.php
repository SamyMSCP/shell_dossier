<div class="container container-press">
	<div class="row">
		<div class="col-sm-12 feat">
			<div class="media">
				<div class="media-body">
					<div class="citation"><?= $this->Citation ?></div>
					<div class="who"><?= $this->Who ?></div>
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1">
							<img src="<?= $this->getPath() ?>res/bfm@3x.jpg"
								 srcset="<?= $this->getPath() ?>res/bfm@2x.jpg 2x,
				<?= $this->getPath() ?>res/bfm@3x.jpg 3x"
								 class="bfm visible-xs"
								 style="width: 100%">
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-md-3"><img src="<?= $this->getPath() ?>res/press/jdn-logo@3x.jpg" class="logos-presse"></div>
						<div class="col-xs-6 col-md-3"><img src="<?= $this->getPath() ?>res/press/le-particulier-logo@3x.png" class="logos-presse"></div>
						<div class="clearfix hidden-md hidden-lg hidden-xl"></div>
						<div class="col-xs-6 col-md-3"><img src="<?= $this->getPath() ?>res/press/challenges-logo@3x.jpg" class="logos-presse"></div>
						<div class="col-xs-6 col-md-3"><img src="<?= $this->getPath() ?>res/press/le-monde-logo@3x.png" class="logos-presse"></div>
					</div>
<!--					<img src="<?= $this->getPath() ?>res/logos-presse@3x.jpg"-->
<!--						 srcset="<?= $this->getPath() ?>res/logos-presse@2x.jpg 2x,-->
<!--					 <?= $this->getPath() ?>res/logos-presse@3x.jpg 3x"-->
<!--						 class="logos-presse">-->
				</div>
				<div class="media-right media-middle hidden-xs">
					<img src="<?= $this->getPath() ?>res/bfm.jpg"
						 srcset="<?= $this->getPath() ?>res/bfm@2x.jpg 2x,
					 <?= $this->getPath() ?>res/bfm@3x.jpg 3x"
						 class="bfm bfm-full">
				</div>
			</div>
		</div>
	</div>
</div>