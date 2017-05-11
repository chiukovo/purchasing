<link href="<?php echo base_url(); ?>assets/css/select2.min.css"" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>

<div id="buy" v-cloak>
	<ul>
		<li>訂單編號: <?php echo $orderNum;?></li>
		<li>訂單日期: <input type="date" data-date-format="DD-YYYY-MM" v-model="date"></li>
		<li>購買人: <input type="text" v-model="name"></li>
		<li>地址:
			<div id="twzipcode">
				<div data-role="county" data-name="county"></div>
				<div data-role="district" data-name="district"></div>
				<div data-role="zipcode" data-name="zipcode"></div>
				<input type="text" v-model="addressDetail" placeholder="路名">
			</div>
		</li>
		<li>電話: <input type="text" v-model="phone"></li>
		<li>身分證: <input type="text" v-model="idCard"></li>
		<li>備註欄: <textarea name="remark" v-model="remark" ></textarea></li>
	</ul>

	選擇商品:
	<select id="productSelect">
		<option value="">請選擇</option>
		<option v-for="(product, name) in onlineProduct" :value="product.name">{{ product.name }}</option>
	</select>
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
				</tr>
				<tr v-for="(product, key) in productGroup">
					<td>{{ product.name }}</td>
					<td><input type="number" style="width: 50px" v-model="product.price" @change="productSum"></td>
					<td><input type="number" style="width: 50px" v-model="productCount[key]" @change="changeProductNum(productCount[key], product.amount, key)"></td>
					<td><input type="number" style="width: 50px" v-model="product.discount" @change="productSum"></td>
					<td><input type="number" style="width: 50px" v-model="product.weight" @change="productSum"></td>
					<td><input type="number" style="width: 50px" v-model="product.fare" @change="productSum"></td>
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

<script type="text/javascript">
	var orderNum = <?php echo $orderNum;?>;
</script>
<script src="<?php echo base_url(); ?>assets/js/jquery.twzipcode.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/buy.js?v=17"></script>
<script>
	$('#twzipcode').twzipcode();
	$('#productSelect').select2();
</script>