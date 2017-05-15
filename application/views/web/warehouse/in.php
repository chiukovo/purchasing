<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/table.css" />
<div class="page-body">
	<h3 class="warehouse-ttl">商品庫存</h3>
	<div class="warehouse-search form-search">
		<form>
		<input class="form-input" type="search" name="search" value="<?php echo $search;?>">
            <button type="submit">查詢</button>
        </form>
	</div>
	<div class="warehouse-item-list" id="list">
		<table class="table warehouse-item table table-hover table-mc-light-blue">
			<thead>
			<tr>
				<th>品名</th>
				<th>規格</th>
				<th>重量</th>
				<th>總數量</th>
				<th>展開</th>
			</tr>
			</thead>
			<?php $num = 0;?>
	        <?php foreach($products as $name => $info) { ?>
	        <tbody>
			<tr>
				<td><?php echo $name;?></td>
				<td><?php echo $info['standard'];?></td>
				<td><?php echo $info['weight'];?></td>
				<td><?php echo $info['amount'];?></td>
				<td><button @click='checkShow("<?php echo $num;?>")' type="button" class="btn">詳情</button></td>
			</tr>
	        <tr class="expand" v-show='showProduct["<?php echo $num;?>"]'>
	            <td colspan="5">
	                <div class="expand">
	                    <table>
	                        <tr>
	                            <th>日期</th>
	                            <th>品名</th>
	                            <th>數量</th>
	                            <th>規格</th>
	                            <th>進貨金額(US)</th>
	                            <th>進貨金額(NT)</th>
	                            <th>追蹤代碼</th>
	                            <th>存放倉庫</th>
	                            <th>貨運單位</th>
	                            <th>收貨人</th>
	                            <th>備註</th>
	                        </tr>
	                        <?php foreach($info['detail'] as $productInfo) { ?>
	                        <tr>
	                            <td><?php echo $productInfo['created_at']?></td>
	                            <td><?php echo $productInfo['name']?></td>
	                            <td><?php echo $productInfo['amount']?></td>
	                            <td><?php echo $productInfo['standard']?></td>
	                            <td><?php echo $productInfo['money_us']?></td>
	                            <td><?php echo $productInfo['money_nt']?></td>
	                            <td><?php echo $productInfo['tracking_code']?></td>
	                            <td><?php echo $productInfo['warehouse']?></td>
	                            <td><?php echo $productInfo['freight']?></td>
	                            <td><?php echo $productInfo['receiver']?></td>
	                            <td><?php echo $productInfo['remark']?></td>
	                        </tr>
	                        <?php } ?>
	                    </table>
	                </div>
	            </td>
	        </tr>
			</tbody>
			<?php $num++;?>
	        <?php } ?>
		</table>
	</div>
</div>

<script type="text/javascript">
var list = new Vue({
    el: '#list',
    data: {
        count: <?php echo count($productsName);?>,
        showProduct: [],
    },
    mounted: function () {
        for(num = 0; num < this.count; num++) {
            this.showProduct.push(false);
        }
    },
    methods: {
        checkShow: function (key) {
            Vue.set(this.showProduct, key, !this.showProduct[key]);
        }
    }
});
</script>