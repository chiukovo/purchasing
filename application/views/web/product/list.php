<!-- Include Date Range Picker -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/daterangepicker.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/table.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/daterangepicker.js"></script>
<script type="text/javascript">
$(function() {
    $('.date').daterangepicker({
        singleDatePicker: true,
        locale: {
          format: 'YYYY-MM-DD'
        }
    });
});
</script>

<div class="page-body">
    <div>
        <form>
            <input type="text" class="date" name="start" value="<?php echo $start;?>" /> ~
            <input type="text" class="date" name="end" value="<?php echo $end;?>" />
            <button type="submit">查詢</button>
        </form>

        <a href="<?php echo base_url(); ?>product/keyIn"><button type="button">新增進貨</button></a>
    </div>
    進貨單列表
    <table class="table table-hover table-mc-light-blue" id="list">
        <thead>
            <tr>
                <th>訂單日期</th>
                <th>信用卡</th>
                <th>本單匯率</th>
                <th>總成本(US)</th>
                <th>總成本(NT)</th>
                <th>功能</th>
            </tr>
        </thead>
        <?php foreach($product as $key => $info) { ?>
        <tbody>
        <tr @click='checkShow("<?php echo $key;?>")'>
            <td><?php echo $info['date'];?></td>
            <td><?php echo $info['idCard'];?></td>
            <td><?php echo $info['rate'];?></td>
            <td><?php echo $info['total_cost_us'];?></td>
            <td><?php echo $info['total_cost_nt'];?></td>
            <td>
                <a href="<?php echo base_url(); ?>product/productEdit?code=<?php echo $info['code'];?>">edit</a>
                <a onclick="deleteCode('<?php echo $info['code'];?>', '<?php echo $info['date'];?>')">刪除</a>
            </td>
        </tr>
        <tr class="expand" v-show='showProduct["<?php echo $key;?>"]'>
            <td colspan="5">
                <div class="expand">
                    <table>
                        <tr>
                            <th>品名</th>
                            <th>數量</th>
                            <th>規格</th>
                            <th>進貨金額(US)</th>
                            <th>進貨金額(NT)</th>
                            <th>追蹤代碼</th>
                            <th>存放倉庫</th>
                            <th>貨運單位</th>
                            <th>收貨人</th>
                            <th>備註</th>
                        </tr>
                        <?php foreach($info['product'] as $productInfo) { ?>
                        <tr>
                            <td><?php echo $productInfo['name']?></td>
                            <td><?php echo $productInfo['amount']?></td>
                            <td><?php echo $productInfo['standard']?></td>
                            <td><?php echo $productInfo['money_us']?></td>
                            <td><?php echo $productInfo['money_nt']?></td>
                            <td><?php echo $productInfo['tracking_code']?></td>
                            <td><?php echo $productInfo['warehouse']?></td>
                            <td><?php echo $productInfo['freight']?></td>
                            <td><?php echo $productInfo['receiver']?></td>
                            <td><?php echo $productInfo['remark']?></td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            </td>
        </tr>
        </tbody>
        <?php } ?>
    </table>
</div>


<script type="text/javascript">
var list = new Vue({
    el: '#list',
    data: {
        count: <?php echo count($product);?>,
        showProduct: [],
    },
    mounted: function () {
        for(num = 0; num < this.count; num++) {
            this.showProduct.push(false);
        }
    },
    methods: {
        checkShow: function (key) {
            Vue.set(this.showProduct, key, !this.showProduct[key]);
        }
    }
});

function deleteCode(code, date)
{
    swal({
        title: "注意",
        text: "您確定要刪除" + date + "嗎？",
        showCancelButton: true,
        cancelButtonText: "取消",
        type: "warning"
    },
    function () {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>product/deleteByCode",
            data: {
                code: code,
                chiuko_o_token: $('#csrf').attr('content'),
            },
            success: function(response) {
                location.reload();
            },
        });
    });
}
</script>
