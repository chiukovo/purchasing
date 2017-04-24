<link href="<?php echo base_url(); ?>assets/css/select2.min.css"" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>

<div id="buy" v-cloak>
	<ul>
		<li>訂單編號: <?php echo $orderNum;?></li>
		<li>購買人: <input type="text" v-model="name"></li>
		<li>地址: 
			<div id="twzipcode">
				<div data-role="county" data-style="Style Name" data-value=""></div>
				<div data-role="district" data-style="Style Name" data-value=""></div>
				<div data-role="zipcode" data-style="Style Name" data-value=""></div>
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
		<option v-for="product in onlineProduct" :value="product.id">{{ product.name }}</option>
	</select>
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
			</tr>
			<tr v-for="(product, key) in productGroup">
				<td>{{ product.name }}</td>
				<td>{{ product.money }}</td>
				<td><input type="number" style="width: 50px" v-model="productCount[key]" @change="changeProductNum(productCount[key], product.amount, key)"></td>
				<td>{{ product.discount }}</td>
				<td>{{ product.weight }}</td>
			</tr>
		</table>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/jquery.twzipcode.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/buy.js?v=9"></script>
<script>
	$('#twzipcode').twzipcode();
	$('#productSelect').select2();
</script>