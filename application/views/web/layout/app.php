<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta id="csrf" content="<?php echo $this->security->get_csrf_hash(); ?>">
<title>purchasing</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/sweetalert.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.css" />
<script src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue.js"></script>
<script src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script>
<style>
[v-cloak] {
  display: none;
}
</style>
</head>

<body>
	<div id="mainBody">
        <div id="page-header"></div>
            <div id="page-container">
        	<?php echo $content;?>
            </div>
        </div>
	</div>
    <div id="page-footer"></div>
</body>

</html>