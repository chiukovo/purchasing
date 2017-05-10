<div id="page-header"></div>
<div id="page-container">
	<div class="page-body">
		<div class="page-tab">
			<ul>
				<li><a href="">全部</a></li>
				<?php foreach ($warehouse as $name) { ?>
				<li class="active">
					<a href=""><?php echo $name;?></a>
				</li>
				<?php } ?>
			</ul>
		</div>

		<table class="table" id="warehouse">
			<tr>
				<td>日期</td>
				<td>商品名稱</td>
				<td>規格</td>
				<td>數量</td>
				<td>重量</td>
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
				<td><?php echo $product['amount']?></td>
				<td><?php echo $product['weight']?></td>
				<td><?php echo $product['tracking_code']?></td>
				<td>
				<select @change="onChange" data-type="warehouse" data-id="<?php echo $product['id'];?>">
					<?php foreach ($warehouse as $name) { ?>
					<option value="<?php echo $name;?>" <?php if($name == $product['warehouse']) { echo 'selected'; } ?> ><?php echo $name;?></option>
					<?php } ?>
				</select>
				</td>
				<td>
				<select @change="onChange" data-type="freight" data-id="<?php echo $product['id'];?>">
					<?php foreach ($freight as $name) { ?>
					<option value="<?php echo $name;?>" <?php if($name == $product['freight']) { echo 'selected'; } ?> ><?php echo $name;?></option>
					<?php } ?>
				</select>
				</td>
				<td>
				<select @change="onChange" data-type="receiver" data-id="<?php echo $product['id'];?>">
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
</script>