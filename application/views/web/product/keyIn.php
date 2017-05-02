<script src="<?php echo base_url(); ?>assets/js/jquery.autocomplete.min.js"></script>

<div id="keyIn">
	<div id="page-header"></div>
	<div id="page-container">
		<div class="page-body">
			<div class="purchase-infor">
				<div class="form-group">
					<label class="form-label">訂單日期</label>
					<input type="date" value="">
				</div>
				<div class="form-group">
					<label class="form-label">信用卡名稱</label>
					<input class="form-input" type="text" value="">
				</div>
				<div class="form-group">
					<label class="form-label">本單匯率</label>
					<input class="form-input" type="text" value="">
				</div>
				<div class="form-group">
					<label class="form-label">進貨總成本(US)</label>
						<input class="form-input" type="text" value="">
				</div>
				<div class="form-group">
					<label class="form-label">進貨總成本(NT)</label>
						<input class="form-input" type="text" value="">
				</div>
			</div>
			<div class="purchase-add">
				<h3 class="purchase-add-ttl">
					新增項目
				</h3>
				<div class="form-group">
					<label class="form-label">品名</label>
					<input type="text" class="autocomplete" v-model="keyInProduct.name" />
				</div>
				<div class="form-group">
					<label class="form-label">規格</label>
					<input class="form-input" type="text" v-model="keyInProduct.standard" >
				</div>
				<div class="form-group">
					<label class="form-label">數量</label>
					<input class="form-input" type="number" v-model="keyInProduct.amount">
				</div>
				<div class="form-group">
					<label class="form-label">重量</label>
					<input class="form-input" type="number" v-model="keyInProduct.weight">
				</div>
				<div class="form-group">
					<label class="form-label">金額</label>
					<input class="form-input" type="number" v-model="keyInProduct.money">
				</div>
				<div class="form-group">
					<label class="form-label">備註</label>
					<textarea class="form-textarea" v-model="keyInProduct.remark"></textarea>
				</div>
			</div>
			<div class="purchase-button">
				<button class="btn btn-add" @click="addProduct">新增</button>
			</div>
			<table class="table">
				<tr>
					<th>品名</th>
					<th>規格</th>
					<th>數量</th>
					<th>重量(lb)</th>
					<th>金額(US)</th>
					<th>備註</th>
					<th>功能</th>
				</tr>
				<tr v-for="(info, key) in listProduct">
					<td>
						<span v-show="info.isDefault">{{ info.name }}</span>
						<span v-show="info.isEdit"><input type="text" class="autocomplete" v-model="info.name" /></span>
					</td>
					<td>
						<span v-show="info.isDefault">{{ info.standard }}</span>
						<span v-show="info.isEdit"><input type="text" v-model="info.standard" /></span>
					</td>
					<td>
						<span v-show="info.isDefault">{{ info.amount }}</span>
						<span v-show="info.isEdit"><input type="number" v-model="info.amount" /></span>
					</td>
					<td>
						<span v-show="info.isDefault">{{ info.weight }}</span>
						<span v-show="info.isEdit"><input type="number" v-model="info.weight" /></span>
					</td>
					<td>
						<span v-show="info.isDefault">{{ info.money }}</span>
						<span v-show="info.isEdit"><input type="number" v-model="info.money" /></span>
					</td>
					<td>
						<span v-show="info.isDefault">{{ info.remark }}</span>
						<span v-show="info.isEdit"><textarea class="form-textarea" v-model="keyInProduct.remark"></textarea></span>
					</td>
					<td>
						<button class="btn btn-edit" v-show="info.isDefault" @click="changeMethod(key, 'edit')">修改</button>

						<button class="btn btn-del" v-show="info.isEdit" @click="changeMethod(key, 'delete')">刪除</button>
						<button class="btn btn-submit" v-show="info.isEdit" @click="changeMethod(key, 'enter')">確認</button>

					</td>
				</tr>
			</table>
		</div>
	</div>
	<div id="page-footer"></div>
</div>

<script src="<?php echo base_url(); ?>assets/js/keyIn.js?v=4"></script>