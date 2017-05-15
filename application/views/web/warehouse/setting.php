<div class="page-body" id="warehouse_setting">
	<ul class="collapsible" data-collapsible="accordion">
	    <li>
	        <div class="collapsible-header active grey lighten-5"><i class="material-icons">dashboard</i>倉儲設定</div>
	        <div class="collapsible-body white">
	        	<div class="warehouse-set">
					<div class="row">
						<div class="input-field col s4">
							<input type="text" v-model="addName">
							<label class="active">倉庫名稱</label>
						</div>
						<div class="col s8">
							<button class="form-btn btn btn-add" @click="addSetting(addName, 'name')">新增</button>
						</div>
					</div>
					<div class="row">
						<ul class="page-ul">
							<li v-for="(info, key) in name">
								<span>{{ info }}</span>
								<button type="button" class="waves-effect waves-light btn-flat" @click="deleteCheck(key, 'name', info)"><i class="material-icons">close</i></button>
							</li>
						</ul>
					</div>
				</div>
	        </div>
	    </li>
	    <li>
	        <div class="collapsible-header grey lighten-5"><i class="material-icons">accessibility</i>收貨人設定</div>
	        <div class="collapsible-body white">
	        	<div class="warehouse-set">
					<div class="card-title"></div>
					<div class="row">
						<div class="input-field col s4">
							<input type="text" v-model="addReceiver">
							<label>收貨人</label>
						</div>
						<div class="col s8">
							<button class="form-btn btn btn-add" @click="addSetting(addReceiver, 'receiver')">新增</button>
						</div>
					</div>
					<div class="row">
						<ul class="page-ul">
							<li v-for="(info, key) in receiver">
								<span>{{ info }}</span>
								<button type="button" class="waves-effect waves-light btn-flat" @click="deleteCheck(key, 'receiver', info)"><i class="material-icons">close</i></button>
							</li>
						</ul>
					</div>
				</div>
	        </div>
	    </li>
	    <li>
	        <div class="collapsible-header grey lighten-5"><i class="material-icons">swap_calls</i>貨運單位</div>
	        <div class="collapsible-body white">
	        	<div class="warehouse-set">
					<div class="row">
						<div class="input-field col s4">
							<input type="text" v-model="addFreight">
							<label class="active">貨運名稱</label>
						</div>
						<div class="col s8">
							<button class="form-btn btn btn-add" @click="addSetting(addFreight, 'freight')">新增</button>
						</div>
					</div>
					<div class="row">
						<ul class="page-ul">
							<li v-for="(info, key) in freight">
								<span>{{ info }}</span>
								<button type="button" class="waves-effect waves-light btn-flat" @click="deleteCheck(key, 'freight', info)"><i class="material-icons">close</i></button>
							</li>
						</ul>
					</div>
				</div>
	        </div>
	    </li>
	</ul>
</div>
<script src="<?php echo base_url(); ?>assets/js/warehouseSetting.js?v=2"></script>