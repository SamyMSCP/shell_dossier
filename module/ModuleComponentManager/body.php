<?php
if (SHOW_FRAME)
{
	?>
	<style type="text/css" media="all">
		.debugMsg {
			content: 'test';
			background-color: rgba(128, 0, 0, 0.8);
			display: block;
			margin-top: -20px;
			margin-left: -1px;
			padding:3px 10px;
			position: absolute;
			font-size:10px;
			color:white;
			display:none;
		}

		.component:hover{
			border:1px dashed red;
		}

		.component:hover  > .debugMsg {
			display:block;
		}
	</style>
	<?php
}
