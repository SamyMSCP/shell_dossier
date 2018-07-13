<meta name="twitter:image" content="<?= $this->getPath() ?>res/mon-compte-scpi.jpg" />
<meta property="og:image" content="<?= $this->getPath() ?>res/mon-compte-scpi.jpg" />
<?php $protocol = isset($_SERVER['HTTPS']) ? "https://" : "http://";  ?>
<meta property="og:url"content="<?= $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']?>" />
