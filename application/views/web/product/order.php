<!-- Include Date Range Picker -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/pikaday-package.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/pikaday-responsive-modernizr.js"></script>
<script src="<?php echo base_url(); ?>assets/js/pikaday.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/pikaday-responsive.js"></script>
<link href="<?php echo base_url(); ?>assets/css/select2.min.css"" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vee-validate.min.js"></script>

<script type="text/javascript">
$(function() {
    pikadayResponsive($('#date'));
});
</script>

<div id="buy" v-cloak>
	<div class="page-body">
		<div class="row">
			<div class="page-title col s6">
				<i class="material-icons">playlist_add</i> 新增訂單
			</div>
			<div class="page-btnBox col s6">
				<div class="right">
					<a onclick="location.reload()" class=" modal-close waves-effect btn-flat" title="關閉">關閉<i class="material-icons left">clear</i></a>
					<a class="waves-effect waves-light btn deep-orange" @click="orderUpdate" title="儲存">送出<i class="material-icons left">save</i></a>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-title">訂購人資訊</div>
			<div class="row">
				<div class="input-field col s6">
					<input type="text" value="<?php echo $orderNum;?>" class="disabled">
					<label class="active">訂單編號</label>
				</div>
				<div class="input-field col s6">
					<input id="date" type="date" value="<?php echo date('Y-m-d')?>">
					<label class="active">訂單日期</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s4">
					<input type="text" id="name" name="name"  v-model="name" v-validate="'required'">
					<label for="name">購買人</label>
					<span v-show="errors.has('name')">請輸入購買人</span>
				</div>
				<div class="input-field col s4">
					<input type="tel" id="phone" v-model="phone" name="phone" v-validate="'required'">
					<label for="phone">電話</label>
					<span v-show="errors.has('phone')">請輸入電話</span>
				</div>
				<div class="input-field col s4">
					<input type="text" v-model="idCard">
					<label>身分證</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s1">
					<label>寄件地址</label>
				</div>
				<div class="input-field col s11">
					<div id="twzipcode" class="select-field">
						<div class="col s2">
							<div data-role="county" data-name="county"></div>
						</div>
						<div class="col s2">
							<div data-role="district" data-name="district"></div>
						</div>
						<div class="col s1">
							<div data-role="zipcode" data-name="zipcode"></div>
						</div>
						<div class="col s7">
							<input type="text" v-model="addressDetail" placeholder="詳細地址">
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s12">
					<textarea id="textarea" class="materialize-textarea" name="remark" v-model="remark"></textarea>
					<label for="textarea">備註欄</label>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-title">訂單資訊</div>
			<div class="row">
				<div class="input-field col s6">
					<input type="number" v-model="pre_money" @change="productSum">
					<label for="textarea">預付款(美金)</label>
				</div>
				<div class="input-field col s6">
					<input type="number" v-model="rate" @change="productSum">
					<label for="textarea">匯率</label>
				</div>
			</div>
			<div class="card-title">新增商品</div>
			<div class="row select-field">
				<div class="input-field col s1"><label>選擇商品</label></div>
				<div class="input-field col s6">
					<select id="productSelect">
						<option>請選擇</option>
						<option v-for="(product, name) in onlineProduct" :value="product.name">{{ product.name }}</option>
					</select>
				</div>
				<div class="input-field col s3">
					<select id="warehouseSelect" @change="changeWareHouse">
						<option value="">倉庫選擇</option>
						<option v-for="(warehouse, key) in warehouseSelect" :value="warehouse">{{ warehouse }}</option>
					</select>
				</div>
				<div class="input-field col s1">
					<input type="text" :value="'庫存量: '+ amount" class="disabled">
				</div>
				<div class="input-field col s1 center-align">
					<a class="waves-effect waves-light btn" @click="addProduct">新增</a>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s4">
					<input type="number" number v-model="discount">
					<label>折扣(%)</label>
				</div>
				<div class="input-field col s4">
					<input type="number" number v-model="price"></br>
					<label>售價(美金)</label>
				</div>
			</div>

			<div class="card-title">商品列表</div>
			<div class="material-table">
				<div class="noPro">請新增商品</div>
				<table>
					<tr>
						<th>名稱</th>
						<th>售價</th>
						<th>數量</th>
						<th>折扣(%)</th>
						<th>重量(g)</th>
						<th>所在倉庫</th>
						<th>庫存量</th>
						<th>功能</th>
					</tr>
					<tr v-for="(product, key) in productGroup">
						<td>{{ product.name }}</td>
						<td><input type="number" number v-model="product.price" @change="productSum"></td>
						<td><input type="number" number v-model="productCount[key]" @change="changeProductNum(productCount[key], product.amount, key)"></td>
						<td><input type="number" number v-model="product.discount" @change="productSum"></td>
						<td><input type="number" number v-model="product.weight" @change="productSum"></td>
						<td>{{ product.warehouse }}</td>
						<td>{{ product.amount }}</td>
						<td><a href="#" @click="deleteProduct(key, product.name)">刪除</a></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="card-footer row">
		<div class="left">
			<ul class="listTotal">
				<li>
					<label>商品總金額(美金/台幣)</label>
					USD {{ costTotalSumUs }} / NT 台幣123
				</li>
				<li>
					<label>運費</label>
					{{ totalFare }}
				</li>
				<li class="red-text">
					<label>預付款(美金)</label>
					{{ (pre_money == 0 ) ? pre_money : - pre_money }}
				</li>
			</ul>
		</div>
		<div class="right">
			<div class="totalFare">
				<div class="totalFare-title left">
					總金額 (商品總金額+運費(台幣))
				</div>
				<div class="totalFare-num right teal-text">
					{{ costTotalSumNt }}
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var orderNum = <?php echo $orderNum;?>;
</script>
<script src="<?php echo base_url(); ?>assets/js/jquery.twzipcode.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/buy.js?v=5"></script>
<script>
	$('#twzipcode').twzipcode();
	$('#productSelect').select2().on('change', function (e) {
		buy.changeProduct(e.target.value);
	});
</script>