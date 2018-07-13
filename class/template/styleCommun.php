.col-xs-5ths,
.col-sm-5ths,
.col-md-5ths,
.col-lg-5ths {
    position: relative;
    min-height: 1px;
    padding-right: 15px;
    padding-left: 15px;
}

.col-xs-5ths {
    width: 20%;
    float: left;
}

@media (min-width: 768px) {
    .col-sm-5ths {
        width: 20%;
        float: left;
    }
}

@media (min-width: 992px) {
    .col-md-5ths {
        width: 20%;
        float: left;
    }
}

@media (min-width: 1200px) {
    .col-lg-5ths {
        width: 20%;
        float: left;
    }
}
	.align-btn-right {
		width:100%;
		text-align:right;
	}
	.align-btn-center {
		width:100%;
		text-align:center;
	}
	.align-btn-left {
		width:100%;
		text-align:left;
	}
	html {
		height: 100%;
	}

	body {
		width: 100%;
		height: 100%;
		min-height:100%;
		margin: 0px;
		padding: 0px;
	}

	select {
		-webkit-appearance:none;
		-moz-appearance:none;
	}
	.btn-mscpi i {
		font-size: 18px;
	}
	.btn-mscpi {
		font-family: ‘Montserrat’, sans-serif;
		font-size: 14px;
		font-weight: 400;
		letter-spacing: 0.05em;
		line-height: 1.1;
	
		height: 32px;
		padding: 0px 20px 0px 20px;
	
		border: none;
		-moz-box-shadow: 0px 0px 10px -2px #3c3c3c;
		-webkit-box-shadow: 0px 0px 10px -2px #3c3c3c;
		-o-box-shadow: 0px 0px 10px -2px #3c3c3c;
		box-shadow: 0px 0px 10px -2px #3c3c3c;
		-moz-border-radius: 10px;
		-webkit-border-radius: 10px;
		border-radius: 10px;
		margin:10px;

		background-color: #1781E0;
		color: #FFF;

		border:0px solid #1781E0;
	}

	.btn-mscpi a{
		color:white;
	}

	h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
		font-family: ‘Open Sans’, sans-serif;
		font-weight: 900;
	}

	p {
		font-family: ‘Open Sans’, sans-serif;
		font-weight: 400;
	}

	.btn-orange {
		background-color: #ff9f1c;
		border:2px solid #ff9f1c;
	}

	.btn-orange.isEmpty {
		background-color: white;
		border:2px solid #ff9f1c;
		color:#ff9f1c;
	}

	.btn-rouge {
		background-color: red;
		border:0px solid red;
	}

	.btn-vert {
		background-color: #20BF55;
		border:0px solid #20BF55;
	}

	.btn-gris{
		background-color: #969696;
		border:0px solid #969696;
	}

	.traitOrange {
		background-color:#ff9f1c;
		width:150px;
		height:4px;
		margin-left: auto;
		margin-right: auto;
		margin-top: 5px;
		margin-bottom: 10px;
		-moz-border-radius: 10px;
		-webkit-border-radius: 10px;
		border-radius: 10px;
	}
	.alert {
		margin-right:10px;
		margin-left:10px;
		font-family: 'Open Sans', sans-serif;
		background-color:#fff !important;
	}

	.alert .close {
		color:#FF9F1C;
		opacity:0.7;
	}

	.alert .close:hover {
		color:#FF9F1C;
		opacity:1;
	}

	.btn-add-scpi {
		font-family: ‘Montserrat’, sans-serif;
		font-size: 14px;
		font-weight: 400;
		letter-spacing: 0.05em;
		line-height: 1.1;
		color: #FFF;

		height: 32px;
		padding: 0px 20px 0px 20px;

		background-color: #FF9F1C;
		border: none;
		-moz-box-shadow: 0px 0px 10px -2px #3c3c3c;
		-webkit-box-shadow: 0px 0px 10px -2px #3c3c3c;
		-o-box-shadow: 0px 0px 10px -2px #3c3c3c;
		box-shadow: 0px 0px 10px -2px #3c3c3c;
		-moz-border-radius: 10px;
		-webkit-border-radius: 10px;
		border-radius: 10px;
		margin:10px;
	}

	.btn-more-info {
		font-family: ‘Montserrat’, sans-serif;
		font-size: 14px;
		font-weight: 400;
		letter-spacing: 0.05em;
		line-height: 1.1;
		color: #FFF;

		height: 32px;
		padding: 0px 20px 0px 20px;

		background-color: #1781E0;
		border: none;
		-moz-box-shadow: 0px 0px 10px -2px #3c3c3c;
		-webkit-box-shadow: 0px 0px 10px -2px #3c3c3c;
		-o-box-shadow: 0px 0px 10px -2px #3c3c3c;
		box-shadow: 0px 0px 10px -2px #3c3c3c;
		-moz-border-radius: 10px;
		-webkit-border-radius: 10px;
		border-radius: 10px;
		margin:10px;
	}

	.modal-footer {
		padding:0px !important;
	}
	.modal-footer .form-group {
		margin-bottom:0px;
	}

	.modal-header {
		border-bottom:none;
	}

	.modal-header button {
		opacity:1;
	}

	.modal-header button:hover {
		opacity:1;
	}

	.modal-header img {
		height:30px;
	}
	.modal-backdrop.in {
		z-index: 1000;
	}

	.modal.in .modal-dialog {
	margin-top: 120px;
	}

	.modal-title {
	font-size: 20px;
	}

	.modal {
		z-index:1001 !important;
	}
	.modal .modal-dialog {
		margin-top: 20vh;
		z-index:1001 !important;
	}
	.modal-content {
		background-color: #EBEBEB;
	}
	.ui-datepicker-header {
		background-color: #428bca !important;
	}

	.ui-datepicker th {
		background-color: #8da6bb;
	}

	.ui-state-default {
		border-color:white !important;
		color:#01528A !important;
		height: 32px !important;
		text-align: center !important;
		padding: 6px !important;
	}

	.ui-datepicker-month,
	.ui-datepicker-year {
		background: none;
		border: none;
		color: white;
		font-size: 18px;
		margin: 5px;
		font-family: 'Montserrat', sans-serif;
		font-size: 16px;
		font-weight: 400;
		letter-spacing: 0.05em;
		line-height: 1.1;
	}

	.ui-widget-content {
		font-family: 'Montserrat', sans-serif;
		font-size: 16px;
		font-weight: 400;
		letter-spacing: 0.05em;
		line-height: 1.1;
		color: #428bca !important;
	}

	.ui-state-highlight {
		background:#a1c2de !important;
		color:white !important;
	}

	.ui-state-active {
		background:#FF9F1C !important;
		color:white !important;

	}

	.ui-datepicker {
		z-index: 9999 !important;
		min-width: 330px;
	}

	.arrSelect {
		border:2px solid #01528A;
		height:33px;
		background-color:white;
		flex: 1;
		border-radius:5px;
		min-width:200px;
	}

	.arrSelect select{
		border:none;
		width:100%;
		height:100%;
	}

	.btn-not-allowed {
		cursor:not-allowed;
	}

	.btn-not-check.btn-orange {
		color: #ff9f1c;
		border:1px solid #ff9f1c;
	}

	.btn-not-check.btn-rouge {
		color: red;
		border:1px solid red;
	}

	.btn-not-check.btn-gris{
		color: #969696;
		border:1px solid #969696;
	}

	.isEmpty,
	.btn-not-check {

		background-color:white;
		color:#1781E0;
		border-width: 1px;
	}
	.radio-inline input[type="radio"],
	.radio-inline input[type="checkbox"]{
		display: none;
	}
	.radio-inline span{
		display: inline-block;
		border: 1px solid #969696;
		border-radius: 6px;
		width: 20px;
		height: 20px;
		background: #FFFFFF;
		vertical-align: middle;
		transition: width 0.1s, height 0.1s, margin 0.1s;
		margin: 0px !important;
		padding: 0px !important;
		margin-right: 5px !important;
	}
	.radio-inline :checked + span {
		background: #1781e0;
	}

	.radio-inline{
		margin: 0px;
		padding: 0px !important;
		min-height:auto !important;
	}
	.picto-small {
		height:32px;
	}

	.outRight {
		position: absolute;
		right: -90px;
		top: 20px;
	}

	.outRight > .outContent {
		cursor:pointer;
		display:inline-block;
		height: 42px;
		background: #1781e0;
		width: 42px;
		border-radius: 4px;
		box-shadow: 0px 0px 10px -2px #3c3c3c;
		padding-top: 5px;
	}
	.outRight > .outContent:hover {
		background-color:#519fe0;
	}

	.outRight > .outContent-orange {
		background: #ff9f1c !important;
	}

	.outRight > .outContent-orange:hover {
		background: #f7b65d !important;
	}

	.outRight i {
		font-size:30px;
		color:white;
	}

	.outRight img {
		height:24px;
	}
	.noBorder {
		background: white;
		padding: 0;
		color: #01528d;
		font-weight: 400;
		text-align: left;
		margin-left: 5px;
		border: none;
		box-shadow: 0px 0px 15px -2px rgba(0, 66, 125, 0.45);
		cursor:pointer;
		text-decoration:underline;
	}
