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
					<label class="form-label">信用卡</label>
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
					<input type="text" id="autocomplete"/>
				</div>
				<div class="form-group">
					<label class="form-label">規格</label>
					<input class="form-input" type="text">
				</div>
				<div class="form-group">
					<label class="form-label">數量</label>
					<input class="form-input" type="text">
				</div>
				<div class="form-group">
					<label class="form-label">重量</label>
					<input class="form-input" type="text">
				</div>
				<div class="form-group">
					<label class="form-label">金額</label>
					<input class="form-input" type="text">
				</div>
				<div class="form-group">
					<label class="form-label">備註</label>
					<textarea class="form-textarea"></textarea>
				</div>
			</div>
			<div class="purchase-button">
				<button class="btn btn-add">新增</button>
			</div>
			<table class="table">
				<tr>
					<th>品名</th>
					<th>規格</th>
					<th>數量</th>
					<th>重量(lb)</th>
					<th>金額(US)</th>
					<th>成本(NT)</th>
					<th>備註</th>
					<th>功能</th>
				</tr>
				<tr>
					<td>產品名稱1</td>
					<td>S</td>
					<td>5</td>
					<td>1.2</td>
					<td>20</td>
					<td>3154</td>
					<td></td>
					<td>
						<button class="btn btn-edit">修改</button>
						<!-- 點編輯後轉換
						<button class="btn btn-del">刪除</button>
						<button class="btn btn-submit">確認</button>
						-->
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div id="page-footer"></div>
</div>

<script src="<?php echo base_url(); ?>assets/js/keyIn.js?v=2"></script>