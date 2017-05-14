<script src="<?php echo base_url(); ?>assets/js/jquery.autocomplete.min.js"></script>
<script type="text/javascript">
$(function() {
    pikadayResponsive($('#date'));
});
</script>
<div id="keyIn">
	<div class="page-body">
		<div class="purchase-infor col">
			<div class="row">
				<div class="purchase-title col s6">
				<i class="material-icons">playlist_add</i> 新增進貨單
				</div>
				<div class="modal-footer col s6">
					<a class="waves-effect waves-light btn deep-orange" @click="insert()" title="儲存">儲存<i class="material-icons left">save</i></a>
					<a onclick="location.reload()" class=" modal-close waves-effect btn-flat" title="關閉">關閉<i class="material-icons left">clear</i></a>
				</div>
			</div>
			<div class="card">
				<div class="card-title">進貨單資訊</div>
				<div class="row">
					<div class="input-field col s6">
						<input id="date" type="date" class="validate">
						<label class="active">訂單日期</label>
					</div>
					<div class="input-field col s6">
						<input type="text" class="validate"
						v-model="productOrder.idCard">
						<label>信用卡名稱</label>
					</div>
				</div>
				
				<div class="row">
					<div class="input-field col s4">
						<label>本單匯率</label>
						<input class="form-input" type="text" v-model="productOrder.rate">
					</div>
					<div class="input-field col s4">
						<label>進貨總成本(US)</label>
							<input class="form-input" type="text" v-model="productOrder.total_cost_us">
					</div>
					<div class="input-field col s4">
						<label>進貨總成本(NT)</label>
							<input class="form-input" type="text" v-model="productOrder.total_cost_nt">
					</div>
				</div>
			</div>
		</div>
		<div class="purchase-add">
			<div class="card">
				<div class="card-title">新增項目</div>
				<div class="row">
					<div class="input-field col s4">
						<input type="text" class="autocomplete" v-model="keyInProduct.name" data-model="keyInProduct" data-key="" />
						<label>品名</label>
					</div>
					<div class="input-field col s1">
						<input class="form-input" type="text" v-model="keyInProduct.standard" >
						<label>規格</label>
					</div>
					<div class="input-field col s1">
						<input class="form-input" type="number" v-model="keyInProduct.amount">
						<label>數量</label>
					</div>
					<div class="input-field col s1">
						<input class="form-input" type="number" v-model="keyInProduct.weight">
						<label>重量</label>
					</div>
					<div class="input-field col s1">
						<input class="form-input" type="number" v-model="keyInProduct.money_us">
						<label>金額(US)</label>
					</div>
					<div class="input-field col s1">
						<input class="form-input" type="number" v-model="keyInProduct.money_nt">
						<label>金額(NT)</label>
					</div>
					<div class="input-field col s2">
						<input class="form-input" type="text" v-model="keyInProduct.remark">
						<label>備註</label>
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
							<th>備註</th>
							<th class="centered">功能</th>
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
							<td class="centered">
								<button class="btn btn-edit" v-show="info.isDefault" @click="changeMethod(key, 'edit')">修改</button>

								<button class="btn btn-del" v-show="info.isEdit" @click="changeMethod(key, 'delete')">刪除</button>
								<button class="btn btn-submit" v-show="info.isEdit" @click="changeMethod(key, 'enter')">確認</button>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/keyIn.js?v=14"></script>