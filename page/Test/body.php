<div class="containerPerso">
	<div class="testFlex">
		<div> block 1 </div>
		<div> block 2 </div>
		<div> block 3 </div>
	</div>

	<style type="text/css" media="all">
		.testFlex {
			width: 300px;
			height:300px;
			border:1px solid red;
			display: -webkit-box;  /* OLD - iOS 6-, Safari 3.1-6, BB7 */
			 display: -ms-flexbox;  /* TWEENER - IE 10 */
			display: -webkit-flex; /* NEW - Safari 6.1+. iOS 7.1+, BB10 */
			display: flex;
		}
		.testFlex > div {
			flex: 1;
			margin:10px;
			border:1px solid green;
			webkit-box-flex: 1;   /* OLD - iOS 6-, Safari 3.1-6 */
			width: 20%;            /* For old syntax, otherwise collapses. */
			-webkit-flex: 1;       /* Safari 6.1+. iOS 7.1+, BB10 */
			-ms-flex: 1;           /* IE 10 */
		}
	</style>
</div>
