<!DOCTYPE html>
<html>

<head>
    
    <?php echo $this->_metaHTTP; ?>
    <?php echo $this->_metaName; ?>
    <title><?php echo $this->_title; ?></title>
    <?php echo $this->_cssFiles; ?>
    <?php echo $this->_jsFiles; ?>
</head>

<?php include_once('html/header.php') ?>

<div id="content-box">
	<!--  LOAD CONTENT -->
	<?php
	require_once MODULE_PATH . $this->_moduleName . DS . 'views' . DS . $this->_fileView . '.php';
	?>
</div>

<?php include_once('html/footer.php') ?>