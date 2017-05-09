<script src="<?php echo base_url(); ?>assets/js/jquery.autocomplete.min.js"></script>

<div id="page-header"></div>
<div id="page-container">
	<div id="keyIn">
		<div class="page-body">
			<div class="purchase-infor">
				<div class="form-group">
					<label class="form-label">訂單日期</label>
					<input type="date" data-date-format="DD-YYYY-MM" v-model="productOrder.date">
				</div>
				<div class="form-group">
					<label class="form-label">信用卡名稱</label>
					<input class="form-input" type="text" v-model="productOrder.idCard">
				</div>
				<div class="form-group">
					<label class="form-label">本單匯率</label>
					<input class="form-input" type="text" v-model="productOrder.rate">
				</div>
				<div class="form-group">
					<label class="form-label">進貨總成本(US)</label>
						<input class="form-input" type="text" v-model="productOrder.total_cost_us">
				</div>
				<div class="form-group">
					<label class="form-label">進貨總成本(NT)</label>
						<input class="form-input" type="text" v-model="productOrder.total_cost_nt">
				</div>
			</div>
			<div class="purchase-add">
				<h3 class="purchase-add-ttl">
					新增項目
				</h3>
				<div class="form-group">
					<label class="form-label">品名</label>
					<input type="text" class="autocomplete" v-model="keyInProduct.name" data-model="keyInProduct" data-key="" />
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
					<label class="form-label">金額(US)</label>
					<input class="form-input" type="number" v-model="keyInProduct.money_us">
				</div>
				<div class="form-group">
					<label class="form-label">金額(NT)</label>
					<input class="form-input" type="number" v-model="keyInProduct.money_nt">
				</div>
				<div class="form-group">
					<label class="form-label">追蹤代碼</label>
					<input class="form-input" type="text" v-model="keyInProduct.tracking_code">
				</div>
				<div class="form-group">
					<label class="form-label">存放倉庫</label>
					<select v-model="keyInProduct.warehouse">
						<?php foreach ($warehouse as $name) { ?>
						<option value="<?php echo $name;?>"><?php echo $name;?></option>
						<?php } ?>
					</select>
				</div>
				<div class="form-group">
					<label class="form-label">貨運單位</label>
					<select v-model="keyInProduct.freight">
						<?php foreach ($freight as $name) { ?>
						<option value="<?php echo $name;?>"><?php echo $name;?></option>
						<?php } ?>
					</select>
				</div>
				<div class="form-group">
					<label class="form-label">收貨人</label>
					<select v-model="keyInProduct.receiver">
						<?php foreach ($receiver as $name) { ?>
						<option value="<?php echo $name;?>"><?php echo $name;?></option>
						<?php } ?>
					</select>
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
					<th>金額(NT)</th>
					<th>追蹤代碼</th>
					<th>存放倉庫</th>
					<th>貨運單位</th>
					<th>收貨人</th>
					<th>備註</th>
					<th>功能</th>
				</tr>
				<tr v-for="(info, key) in listProduct">
					<td>
						<span v-show="info.isDefault">{{ info.name }}</span>
						<span v-show="info.isEdit"><input type="text" class="autocomplete" v-model="info.name" data-model="listProduct" :data-key="key" /></span>
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
						<span v-show="info.isDefault">{{ info.money_us }}</span>
						<span v-show="info.isEdit"><input type="number" v-model="info.money_us" /></span>
					</td>
					<td>
						<span v-show="info.isDefault">{{ info.money_nt }}</span>
						<span v-show="info.isEdit"><input type="number" v-model="info.money_nt" /></span>
					</td>
					<td>
						<span v-show="info.isDefault">{{ info.tracking_code }}</span>
						<span v-show="info.isEdit"><input type="text" v-model="info.tracking_code"></span>
					</td>
					<td>
						<span v-show="info.isDefault">{{ info.warehouse }}</span>
						<span v-show="info.isEdit">
						<select v-model="info.warehouse">
							<?php foreach ($warehouse as $name) { ?>
							<option value="<?php echo $name;?>"
							:selected="info.warehouse == '<?php echo $name?>' ? 'selected' : ''"><?php echo $name;?></option>
							<?php } ?>
						</select>
						</span>
					</td>
					<td>
						<span v-show="info.isDefault">{{ info.freight }}</span>
						<span v-show="info.isEdit">
						<select v-model="info.freight">
							<?php foreach ($freight as $name) { ?>
							<option value="<?php echo $name;?>" :selected="info.freight == '<?php echo $name?>' ? 'selected' : ''"><?php echo $name;?></option>
							<?php } ?>
						</select>
						</span>
					</td>
					<td>
						<span v-show="info.isDefault">{{ info.receiver }}</span>
						<span v-show="info.isEdit">
						<select v-model="info.receiver">
							<?php foreach ($receiver as $name) { ?>
							<option value="<?php echo $name;?>" :selected="info.receiver == '<?php echo $name?>' ? 'selected' : ''"><?php echo $name;?></option>
							<?php } ?>
						</select>
						</span>
					</td>
					<td>
						<span v-show="info.isDefault">{{ info.remark }}</span>
						<span v-show="info.isEdit"><textarea class="form-textarea" v-model="info.remark"></textarea></span>
					</td>
					<td>
						<button class="btn btn-edit" v-show="info.isDefault" @click="changeMethod(key, 'edit')">修改</button>

						<button class="btn btn-del" v-show="info.isEdit" @click="changeMethod(key, 'delete')">刪除</button>
						<button class="btn btn-submit" v-show="info.isEdit" @click="changeMethod(key, 'enter')">確認</button>
					</td>
				</tr>
			</table>
			<div>
				<button @click="insert()">送出儲存</button>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url(); ?>assets/js/keyIn.js?v=14"></script>