<?php

$this->modal_content .= $this->generateCacheModal($this->dh->id_dh);

if (isset($_POST['button2id']) && $_POST['button2id'] == 'addTransaction')
	$this->insertNewTransaction();