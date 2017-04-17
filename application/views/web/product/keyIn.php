<div id="keyIn">
	<div>
		<button @click="addProduct">新增產品</button>
	</div>
	<ul>
		<li v-for="(info, key) in product">
			名稱: <input type="text" name="name" v-model="info.name" />
			售價: <input type="number" name="money" v-model="info.money" />
			折扣: <input type="number" name="discount" v-model="info.discount" />
			重量: <input type="text" name="weight" v-model="info.weight" />
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
		<button type="button" @click="formPost">送出</button>
		<input id="csrf" type="hidden" name="chiuko_o_token" value="<?php echo $this->security->get_csrf_hash(); ?>" />
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/keyIn.js?v=1"></script>