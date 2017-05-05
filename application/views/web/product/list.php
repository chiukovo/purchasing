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
        <table>
            <tr>
                <th>訂單日期</th>
                <th>信用卡</th>
                <th>本單匯率</th>
                <th>總成本(US)</th>
                <th>總成本(NT)</th>
                <th>功能</th>
                <th>產品項目</th>
            </tr>
            <?php foreach($product as $info) { ?>
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
            </tr>
            <?php } ?>
        </table>
	</div>
</div>
<div id="page-footer"></div>

<script type="text/javascript">

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
