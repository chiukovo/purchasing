<div id="page-header"></div>
<div id="page-container">
	<div class="page-body" id="warehouse_setting">
		<div class="warehouse-set">
			<h3 class="warehouse-set-ttl">倉儲設定</h3>
			<div class="form-group">
				<label class="form-label">倉庫名稱</label>
				<input type="form-input" v-model="addName">
				<button class="form-btn btn btn-add" @click="addSetting(addName, 'name')">新增</button>
				<ul>
					<li v-for="(info, key) in name">
						<span>{{ info }}</span>
						<button type="button" class="btn-icon btn-icon-del" @click="deleteCheck(key, 'name')">x</button>
					</li>
				</ul>
			</div>
		</div>
		<div class="warehouse-set">
			<h3 class="warehouse-set-ttl">收貨人設定</h3>
			<div class="form-group">
				<label class="form-label">收貨人</label>
				<input type="form-input" v-model="addReceiver">
				<button class="form-btn btn btn-add" @click="addSetting(addReceiver, 'receiver')">新增</button>
				<ul>
					<li v-for="(info, key) in receiver">
						<span>{{ info }}</span>
						<button type="button" class="btn-icon btn-icon-del" @click="deleteCheck(key, 'receiver')">x</button>
					</li>
				</ul>
			</div>
		</div>
		<div class="warehouse-set">
			<h3 class="warehouse-set-ttl">貨運單位</h3>
			<div class="form-group">
				<label class="form-label">貨運名稱</label>
				<input type="form-input" v-model="addFreight">
				<button class="form-btn btn btn-add" @click="addSetting(addFreight, 'freight')">新增</button>
				<ul>
					<li v-for="(info, key) in freight">
						<span>{{ info }}</span>
						<button type="button" class="btn-icon btn-icon-del" @click="deleteCheck(key, 'freight')">x</button>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url(); ?>assets/js/warehouseSetting.js?v=1"></script>