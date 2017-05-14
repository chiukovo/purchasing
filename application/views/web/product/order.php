<!-- Include Date Range Picker -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/pikaday-package.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/pikaday-responsive-modernizr.js"></script>
<script src="<?php echo base_url(); ?>assets/js/pikaday.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/pikaday-responsive.js"></script>
<link href="<?php echo base_url(); ?>assets/css/select2.min.css"" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vee-validate.min.js"></script>

<style type="text/css">
	.is-danger{
		color: red;
	}
</style>
<script type="text/javascript">
$(function() {
    pikadayResponsive($('#date'));
});
</script>

<div id="buy" v-cloak>
<div class="card">
	<ul>
		<li>訂單編號: <?php echo $orderNum;?></li>
		<li>訂單日期:
			<input id="date" type="date" name="date" data-date-format="DD-YYYY-MM" v-model="date" v-validate="'required'">
			<span v-show="errors.has('date')" class="help is-danger">請輸入日期</span>
		</li>
		<li>購買人:
			<input type="text" name="name"  v-model="name" v-validate="'required'">
			<span v-show="errors.has('name')" class="help is-danger">請輸入購買人</span>
		</li>
		<li>地址:
			<div id="twzipcode">
				<div data-role="county" data-name="county"></div>
				<div data-role="district" data-name="district"></div>
				<div data-role="zipcode" data-name="zipcode"></div>
				<input type="text" v-model="addressDetail" placeholder="路名">
			</div>
		</li>
		<li>電話:
			<input type="phone" v-model="phone" name="phone" v-validate="'required'">
			<span v-show="errors.has('phone')" class="help is-danger">請輸入電話</span>
		</li>
		<li>身分證: <input type="text" v-model="idCard"></li>
		<li>備註欄: <textarea name="remark" v-model="remark" ></textarea></li>
	</ul>

	選擇商品:
	<select id="productSelect">
		<option value="">請選擇</option>
		<option v-for="(product, name) in onlineProduct" :value="product.name">{{ product.name }}</option>
	</select>
	</br>
	選擇所在倉庫:
	<select id="warehouseSelect" @change="changeWareHouse">
		<option v-for="(warehouse, key) in warehouseSelect" :value="warehouse">{{ warehouse }}</option>
	</select>
	</br>
	庫存量: <span>{{ amount }}</span>
	</br>
	折扣(%): <input type="number" v-model="discount"></br>
	售價(美金): <input type="number" v-model="price"></br>
	運費(台幣): <input type="number" v-model="fare"></br>
	<button type="button" @click="addProduct()">增加</button>
	<div>
		商品列表:
			<table>
				<tr>
					<th>名稱</th>
					<th>售價</th>
					<th>數量</th>
					<th>折扣(%)</th>
					<th>重量(g)</th>
					<th>運費</th>
					<th>所在倉庫</th>
					<th>庫存量</th>
					<th>功能</th>
				</tr>
				<tr v-for="(product, key) in productGroup">
					<td>{{ product.name }}</td>
					<td><input type="number" style="width: 50px" v-model="product.price" @change="productSum"></td>
					<td><input type="number" style="width: 50px" v-model="productCount[key]" @change="changeProductNum(productCount[key], product.amount, key)"></td>
					<td><input type="number" style="width: 50px" v-model="product.discount" @change="productSum"></td>
					<td><input type="number" style="width: 50px" v-model="product.weight" @change="productSum"></td>
					<td><input type="number" style="width: 50px" v-model="product.fare" @change="productSum"></td>
					<td>{{ product.warehouse }}</td>
					<td>{{ product.amount }}</td>
					<td><button type="button" @click="deleteProduct(key)">刪除</button></td>
				</tr>
			</table>

		<div>預付款(美金): <input type="number" v-model="pre_money" @change="productSum"></div>
		<div>
			輸入匯率: <input type="number" v-model="rate" @change="productSum"></br>
			總運費: {{ totalFare }}</br>
			商品總金額(美金): {{ costTotalSumUs }}</br>
			商品總金額+運費(台幣): {{ costTotalSumNt }}</br>
			<button type="button" @click="orderUpdate">送出</button>
		</div>

	</div>
</div>
</div>

<script type="text/javascript">
	var orderNum = <?php echo $orderNum;?>;
</script>
<script src="<?php echo base_url(); ?>assets/js/jquery.twzipcode.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/buy.js?v=3"></script>
<script>
	$('#twzipcode').twzipcode();
	$('#productSelect').select2().on('change', function (e) {
		buy.changeProduct(e.target.value);
	});
</script>