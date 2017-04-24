<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta id="csrf" content="<?php echo $this->security->get_csrf_hash(); ?>">
<title>purchasing</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/sweetalert.css">
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
	<?php echo $content;?>
</body>

</html>