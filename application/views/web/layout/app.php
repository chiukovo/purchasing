<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta id="csrf" content="<?php echo $this->security->get_csrf_hash(); ?>">
<title>purchasing</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/sweetalert.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/materialize.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css" />
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
<script src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue.js"></script>
<script src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/materialize.min.js"></script>
<style>
[v-cloak] {
  display: none;
}
</style>
</head>

<body>
	<div id="mainBody">
		<div id="page-header" class="z-depth-2">
			<ul id="slide-out" class="side-nav">
				<li>
					<div class="userView">
					SHOP.
					</div>
				</li>
				<li><a href="<?php echo base_url(); ?>product/keyIn">新增進貨</a></li>
				<li><a href="<?php echo base_url(); ?>product/list">進貨單列表</a></li>
				<li><a href="<?php echo base_url(); ?>warehouse/setting">倉庫設定</a></li>
				<li><a href="<?php echo base_url(); ?>warehouse/list">倉庫</a></li>
				<li><a href="<?php echo base_url(); ?>warehouse/in">庫存</a></li>
				<li><a href="<?php echo base_url(); ?>product/order">新增訂單</a></li>
			</ul>
	        <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
	        <a href="#" class="brand-logo">SHOP.</a>
        </div>
        <div id="page-container">
			<div class="page-body">
        	<?php echo $content;?>
            </div>
        </div>
        <div id="page-footer"></div>
	</div>
	<script>
		$(".button-collapse").sideNav();
	</script>
</body>

</html>