<!-- Include Date Range Picker -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/daterangepicker.css" />
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
<div id="page-header"></div>
<div id="page-container">
	<div class="page-body">
        <div>
            <form>
                <input type="text" class="date" name="start" value="<?php echo $start;?>" /> ~
                <input type="text" class="date" name="end" value="<?php echo $end;?>" />
                <button type="submit">查詢</button>
            </form>
        </div>
        進貨單列表
        <table id="list">
            <tr>
                <th>訂單日期</th>
                <th>信用卡</th>
                <th>本單匯率</th>
                <th>總成本(US)</th>
                <th>總成本(NT)</th>
                <th>產品項目</th>
                <th>功能</th>
            </tr>
            <?php foreach($product as $key => $info) { ?>
            <tbody>
            <tr>
                <td><?php echo $info['date'];?></td>
                <td><?php echo $info['idCard'];?></td>
                <td><?php echo $info['rate'];?></td>
                <td><?php echo $info['total_cost_us'];?></td>
                <td><?php echo $info['total_cost_nt'];?></td>
                <td><a href="<?php echo base_url(); ?>product/productEdit?code=<?php echo $info['code'];?>">edit</a></td>
                <td>
                    <a onclick="deleteCode('<?php echo $info['code'];?>', '<?php echo $info['date'];?>')">刪除</a>
                </td>
                <td><button type="button" @click='checkShow("<?php echo $key;?>")'>展開</button></td>
            </tr>
            <td colspan="5" v-show='showProduct["<?php echo $key;?>"]'>
                <table>
                    <tr>
                        <th>品名</th>
                        <th>數量</th>
                        <th>規格</th>
                        <th>進貨金額(US)</th>
                        <th>進貨金額(NT)</th>
                        <th>備註</th>
                    </tr>
                    <?php foreach($info['product'] as $productInfo) { ?>
                    <tr>
                        <td><?php echo $productInfo['name']?></td>
                        <td><?php echo $productInfo['amount']?></td>
                        <td><?php echo $productInfo['standard']?></td>
                        <td><?php echo $productInfo['money_us']?></td>
                        <td><?php echo $productInfo['money_nt']?></td>
                        <td><?php echo $productInfo['remark']?></td>
                    </tr>
                    <?php } ?>
                </table>
            </td>
            </tbody>
            <?php } ?>
        </table>
	</div>
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
