<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
<div class="page-body">
	<div class="card material-table">
        <div class="table-header">
            <span class="table-title">倉庫庫存列表</span>
            <div class="actions">
                <a href="#" class="search-toggle waves-effect btn-flat"><i class="material-icons">search</i></a>
            </div>
        </div>
        <div class="hiddensearch" style="display: none">
            <div id="datatable_filter" class="dataTables_filter col s6">
                <form>
                <div class="row">
                    <div class="input-field col">
                        <input id="start" type="text" class="date" value="<?php echo $start;?>" />
                    </div>
                    <div class="input-field col">
                        <input id="end" type="text" class="date" value="<?php echo $end;?>">
                    </div>
                    <div class="col"><a onclick="document.forms[0].submit()" class="waves-effect waves-light btn">查詢</a></div>
                </div>
                </form>
            </div>
        </div>
		<ul class="page-tabs">
			<li class="tab <?php if ($type == '') { echo 'active';}?>"><a href="<?php echo base_url()?>warehouse/list?type=&start=<?php echo $start;?>&end=<?php echo $end;?>">全部</a></li>
			<?php foreach ($warehouse as $name) { ?>
			<li class="tab <?php if ($type == $name) { echo 'active';}?>">
				<a href="<?php echo base_url()?>warehouse/list?type=<?php echo $name;?>&start=<?php echo $start;?>&end=<?php echo $end;?>"><?php echo $name;?></a>
			</li>
			<?php } ?>
		</ul>
		<table class="table" id="warehouse">
			<tr>
				<th>日期</th>
				<th>商品名稱</th>
				<th>規格</th>
				<th>數量</th>
				<th>重量</th>
	            <th>追蹤代碼</th>
	            <th>存放倉庫</th>
	            <th>貨運單位</th>
	            <th>收貨人</th>
	            <th>備註</th>
			</tr>
			<?php foreach($products as $product) {?>
			<tr>
				<td><?php echo $product['created_at']?></td>
				<td><?php echo $product['name']?></td>
				<td><?php echo $product['standard']?></td>
				<td><?php echo format_money_nt($product['amount']);?></td>
				<td><?php echo format_money_nt($product['weight']);?></td>
				<td>
                    <input @change="onChange" type="text" data-type="tracking_code" data-id="<?php echo $product['id'];?>" value="<?php echo $product['tracking_code']?>" placeholder="請輸入追蹤代碼">
                </td>
				<td>
				<select @change="onChange" data-type="warehouse" data-id="<?php echo $product['id'];?>">
                    <?php if ($product['warehouse'] == '') { ?>
                        <option>請選擇</option>
                    <?php } ?>
					<?php foreach ($warehouse as $name) { ?>
					<option value="<?php echo $name;?>" <?php if($name == $product['warehouse']) { echo 'selected'; } ?> ><?php echo $name;?></option>
					<?php } ?>
				</select>
				</td>
				<td>
				<select @change="onChange" data-type="freight" data-id="<?php echo $product['id'];?>">
                    <?php if ($product['freight'] == '') { ?>
                        <option>請選擇</option>
                    <?php } ?>
					<?php foreach ($freight as $name) { ?>
					<option value="<?php echo $name;?>" <?php if($name == $product['freight']) { echo 'selected'; } ?> ><?php echo $name;?></option>
					<?php } ?>
				</select>
				</td>
				<td>
				<select @change="onChange" data-type="receiver" data-id="<?php echo $product['id'];?>">
                    <?php if ($product['receiver'] == '') { ?>
                        <option>請選擇</option>
                    <?php } ?>
					<?php foreach ($receiver as $name) { ?>
					<option value="<?php echo $name;?>" <?php if($name == $product['receiver']) { echo 'selected'; } ?> ><?php echo $name;?></option>
					<?php } ?>
				</select>
				</td>
				<td><?php echo $product['remark']?></td>
			</tr>
			<?php } ?>
		</table>
	</div>

</div>

<script type="text/javascript">
var warehouse = new Vue({
    el: '#warehouse',
    data: {
        type: '',
        id: '',
        csrf_value: $('#csrf').attr('content'),
    },
    methods: {
        onChange: function (e) {
            var value = e.target.value;
            this.type = event.currentTarget.getAttribute('data-type');
            this.id = event.currentTarget.getAttribute('data-id');

            doUpdate(value);
        }
    }
});

function doUpdate(value)
{
    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>/product/updateWarehouse",
        data: {
            value: value,
            type: warehouse.type,
            id: warehouse.id,
            chiuko_o_token: warehouse.csrf_value,
        },
        success: function(csrf) {
            warehouse.csrf_value = csrf;
        },
    });
}
$('.search-toggle').click(function() {
  if ($('.hiddensearch').css('display') == 'none')
    $('.hiddensearch').slideDown();
  else
    $('.hiddensearch').slideUp();
});
</script>