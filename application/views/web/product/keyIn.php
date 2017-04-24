<div id="keyIn" v-cloak>
	<div>
		<button @click="addProduct">新增產品</button>
	</div>
	<ul>
		<li v-for="(info, key) in product">
			名稱: <input type="text" name="name" v-model="info.name" />
			售價: <input type="number" name="money" v-model="info.money" />
			數量: <input type="number" name="amount" v-model="info.amount" />
			折扣(%): <input type="number" name="discount" v-model="info.discount" />
			重量(g): <input type="number" name="weight" v-model="info.weight" />
			商品狀態:
			<select v-model="info.status">
				<option value="1">上架</option>
				<option value="2">下架</option>
			</select>
			備註: <textarea name="remark" :value="info.remark" ></textarea>
			<button type="button" v-if="key != 0" @click="removeProduct(key)">刪除此列</button>
		</li>
	</ul>

	<div>
		<button type="button" @click="keyInPost">送出</button>
	</div>

	<h1>目前商品</h1>
	<table width="100%">
		<tr>
			<th>名稱</th>
			<th>售價</th>
			<th>數量</th>
			<th>折扣(%)</th>
			<th>重量(g)</th>
			<th>商品狀態</th>
			<th>新增時間</th>
			<th>操作</th>
		</tr>

		<tr v-for="(product, key) in allProduct">
			<td>
				<span v-show="product.checkText">{{ product.name }}</span>
				<input v-show="product.checkInput" type="text" v-model="product.name">
			</td>
			<td>
				<span v-show="product.checkText">{{ product.money }}</span>
				<input v-show="product.checkInput" type="number" v-model="product.money">
			</td>
			<td>
				<span v-show="product.checkText">{{ product.amount }}</span>
				<input v-show="product.checkInput" type="number" v-model="product.amount">
			</td>
			<td>
				<span v-show="product.checkText">{{ product.discount }}</span>
				<input v-show="product.checkInput" type="number" v-model="product.discount">
			</td>
			<td>
				<span v-show="product.checkText">{{ product.weight }}</span>
				<input v-show="product.checkInput" type="number" v-model="product.weight">
			</td>
			<td>
				<span v-show="product.checkText">{{ getStatusCn(product.status) }}</span>
				<select v-show="product.checkInput" v-model="product.status">
					<option value="1" :selected="product.status == 1" >上架</option>
					<option value="2" :selected="product.status == 2" >下架</option>
				</select>
			</td>
			<td>{{ product.created_at }}</td>
			<td>
				<div v-show="product.checkText">
					<button type="button" @click="deleteCheck(product.name, product.id, key)">刪除</button>
					<button type="button" @click="changeMethod(key)">修改</button>
				</div>
				<div v-show="product.checkInput">
					<button type="button" @click="changeMethod(key)">取消</button>
					<button type="button" @click="editUpdate(product, key)">送出</button>
				</div>
			</td>
		</tr>
	</table>
</div>
<script src="<?php echo base_url(); ?>assets/js/keyIn.js?v=4"></script>