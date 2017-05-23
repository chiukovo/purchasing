<script type="text/javascript">
$(function() {
    pikadayResponsive($('#date'));
});
</script>
<div id="keyIn">
	<div class="page-body">
		<div class="purchase-title col">
			<div class="row">
				<div class="page-title col s6">
					<i class="material-icons">playlist_play</i> 編輯進貨單
				</div>
				<div class="page-btnBox col s6">
				<div class="right">
					<a onclick="location.reload()" class=" modal-close waves-effect btn-flat" title="關閉">關閉<i class="material-icons left">clear</i></a>
					<a class="waves-effect waves-light btn deep-orange" @click="insert()" title="儲存">送出<i class="material-icons left">save</i></a>
				</div>
			</div>
			</div>
			<div class="card">
				<div class="card-title">進貨單資訊</div>
				<div class="row">
					<div class="input-field col s6">
						<input id="date" type="date" value="<?php echo $date;?>">
						<label class="active">訂單日期</label>
					</div>
					<div class="input-field col s6">
						<input type="text" v-model="productOrder.idCard">
						<label>信用卡名稱</label>
					</div>
				</div>

				<div class="row">
					<div class="input-field col s4">
						<label>本單匯率</label>
						<input type="text" v-model="productOrder.rate" @change="sumNT">
					</div>
					<div class="input-field col s4">
						<input type="text" v-model="productOrder.total_cost_us" @change="sumNT">
						<label>進貨總成本(US)</label>
					</div>
					<div class="input-field col s4">
						<label>進貨總成本(NT)</label>
						<input type="text" v-model="productOrder.total_cost_nt">
					</div>
				</div>
			</div>
		</div>
		<div class="purchase-add">
			<div class="card">
				<div class="card-title">新增項目</div>
				<div class="row">
					<div class="input-field col s4">
						<label class="form-label">品名</label>
						<input type="text" class="autocomplete" v-model="keyInProduct.name" data-model="keyInProduct" data-key="" />
					</div>
					<div class="input-field col s1">
						<label class="form-label">規格</label>
						<input type="text" v-model="keyInProduct.standard" >
					</div>
					<div class="input-field col s1">
						<label class="form-label">數量</label>
						<input type="number" v-model="keyInProduct.amount">
					</div>
					<div class="input-field col s1">
						<label class="form-label">重量</label>
						<input type="number" v-model="keyInProduct.weight">
					</div>
					<div class="input-field col s1">
						<label class="form-label">金額(US)</label>
						<input type="number" v-model="keyInProduct.money_us" @change="sumNTAdd('active')">
					</div>
					<div class="input-field col s1">
						<label class="form-label">金額(NT)</label>
						<input type="number" v-model="keyInProduct.money_nt">
					</div>
					<!-- <div class="input-field col s1">
						<label class="form-label">追蹤代碼</label>
						<input type="number" v-model="keyInProduct.tracking_code">
					</div> -->
					<!--<div class="input-field col s1">
						<label class="form-label">存放倉庫</label>
						<select v-model="keyInProduct.warehouse">
							<?php foreach ($warehouse as $name) { ?>
							<option value="<?php echo $name;?>"><?php echo $name;?></option>
							<?php } ?>
						</select>
					</div>
					<div class="input-field col s1">
						<label class="form-label">貨運單位</label>
						<select v-model="keyInProduct.freight">
							<?php foreach ($freight as $name) { ?>
							<option value="<?php echo $name;?>"><?php echo $name;?></option>
							<?php } ?>
						</select>
					</div>
					<div class="input-field col s1">
						<label class="form-label">收貨人</label>
						<select v-model="keyInProduct.receiver">
							<?php foreach ($receiver as $name) { ?>
							<option value="<?php echo $name;?>"><?php echo $name;?></option>
							<?php } ?>
						</select>
					</div>-->
					<div class="input-field col s2">
						<label class="form-label">備註</label>
						<input type="text" v-model="keyInProduct.remark">
					</div>
					<div class="input-field col s1">
						<a class="waves-effect waves-light btn" @click="addProduct">新增</a>
					</div>
				</div>
				<div class="material-table">
					<table class="table">
						<tr>
							<th>品名</th>
							<th>規格</th>
							<th>數量</th>
							<th>重量(lb)</th>
							<th>金額(US)</th>
							<th>金額(NT)</th>
							<!--<th>追蹤代碼</th>
							<th>存放倉庫</th>
							<th>貨運單位</th>
							<th>收貨人</th>-->
							<th>備註</th>
							<th class="center-align">功能</th>
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
								<span v-show="info.isEdit"><input type="number" v-model="info.money_us" @change="sumNTEdit(key)" /></span>
							</td>
							<td>
								<span v-show="info.isDefault">{{ info.money_nt }}</span>
								<span v-show="info.isEdit"><input type="number" v-model="info.money_nt" /></span>
							</td>
							<!--<td>
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
							</td>-->
							<td>
								<span v-show="info.isDefault">{{ info.remark }}</span>
								<span v-show="info.isEdit">
								<input type="text" v-model="info.remark">
								</span>
							</td>
							<td  class="center-align">
								<a href="#" class="btn btn-flat btn-edit" v-show="info.isDefault" @click="changeMethod(key, 'edit')">修改</a>

								<a href="#" class="btn btn-flat btn-del" v-show="info.isEdit" @click="changeMethod(key, 'delete')">刪除</a>
								<a href="#" class="btn btn-flat btn-submit" v-show="info.isEdit" @click="changeMethod(key, 'enter')">確認</a>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var code = <?php echo $code;?>
</script>
<script src="<?php echo base_url(); ?>assets/js/productEdit.js?v=4"></script>