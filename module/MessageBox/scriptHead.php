</script>

<script type="text/x-template" id="MessageBoxTemplate">
	<div class="modal fade" id="MessageBox" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog">
			<div class="modal-content" style="background-color:#EBEBEB;">
				<div class="modal-header" style="min-height: 50px">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="module/ApercuDeMonPorteFeuillev3/img/Close-Jaune.svg" alt="" /></button>
				</div>
	<!--			<div class="traitOrange"></div>-->
				<div class="modal-body">
					<div style="color:#505050;font-family: 'Open Sans', sans-serif;font-size:18px;text-align:center;" class="leMessage">
							{{message}}
					</div>
				</div>
				<div class="modal-footer">
					<div style="display: flex; justify-content: center;">
						<button  v-for="btn in btnShow" @click="btn.action()" type="button" class="btn-mscpi" :class="btn.class" data-dismiss="modal" >{{btn.text}}</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</script>

<script type="text/javascript" charset="utf-8">

function MsgBoxClass() {
	that = this;
	this.message = "";
	this.text = "";
	this.btnLst = [];
	this.defaulBtnLst = [
		{
			text: "Fermer",
			action: function() { return ; }
		}
	];
	this.show = function(message, btnLst) {
		if (typeof btnLst !== "undefined" && btnLst.length > 0)
			this.btnLst = btnLst;
		else
			this.btnLst = [];
		this.message = message;
		$("#MessageBox").modal("show");
	};
	this.showText = function(message, btnLst) {
		this.text = "";
		if (typeof btnLst !== "undefined" && btnLst.length > 0)
			this.btnLst = btnLst;
		else
			this.btnLst = [];
		this.message = message;
		$("#MessageTextBox").modal("show");
	};
	return (this);
}

var msgBox = new MsgBoxClass();

Vue.component(
	'msgBox',
	{
		data: function() {
			return (msgBox);
		},
		template:"#MessageBoxTemplate",
		computed: {
			btnShow : function() {
				if (this.btnLst.length > 0)
					return (this.btnLst);
				return (this.defaulBtnLst);
			}
		}
	}
);
</script>

<script type="text/x-template" id="MessageTextBoxTemplate">
	<div class="modal fade" id="MessageTextBox" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog">
			<div class="modal-content" style="background-color:#EBEBEB;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="module/ApercuDeMonPorteFeuillev3/img/Close-Jaune.svg" alt="" /></button>
				</div>
	<!--			<div class="traitOrange"></div>-->
				<div class="modal-body">
					<div style="color:#505050;font-family: 'Open Sans', sans-serif;font-size:18px;text-align:center;" class="leMessage">
							{{message}}
					</div>
					<textarea v-model="text" required>

					</textarea>
				</div>
					<div class="modal-footer">
				<?php
					//<button type="button" class="btn-mscpi" data-dismiss="modal">Fermer</button>
					?>
					<button v-for="btn in btnShow" @click="btn.action(text)" type="button" class="btn-mscpi" :class="btn.class" data-dismiss="modal" >{{btn.text}}</button>
				</div>
			</div>
		</div>
	</div>
</script>

<script type="text/javascript" charset="utf-8">

Vue.component(
	'msgTextBox',
	{
		data: function() {
			return (msgBox);
		},
		template:"#MessageTextBoxTemplate",
		computed: {
			btnShow : function() {
				if (this.btnLst.length > 0)
					return (this.btnLst);
				return (this.defaulBtnLst);
			}
		}
	}
);
