<?php
//There is some code for checking and understand what we must do
//dbg($_POST['data']);
if (!($this->createAccount($_POST['data'])))
	error($this->message);