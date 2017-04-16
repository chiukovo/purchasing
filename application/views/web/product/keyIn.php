<div id="keyIn">
	<div>
		<button @click="addProduct">新增</button>
	</div>
	<ul>
		<li v-for="info in product">
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
		</li>
	</ul>
</div>

<script src="<?php echo base_url(); ?>assets/js/keyIn.js"></script>