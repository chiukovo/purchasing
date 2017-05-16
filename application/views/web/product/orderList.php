<!-- Include Date Range Picker -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/daterangepicker.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/pikaday-package.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/pikaday-responsive-modernizr.js"></script>
<script src="<?php echo base_url(); ?>assets/js/pikaday.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/pikaday-responsive.js"></script>

<script type="text/javascript">
$(function() {
    pikadayResponsive($('#start'));
    pikadayResponsive($('#end'));
});
</script>

<div class="page-body">
    <div class="card material-table">
        <div class="table-header">
            <span class="table-title">訂單列表</span>
            <div class="actions">
                <a href="#modalAdd" class="modal-trigger waves-effect btn-flat" data-type="add"><i class="material-icons">add_circle</i></a>
                <a href="#" class="search-toggle waves-effect btn-flat"><i class="material-icons">search</i></a>
            </div>
        </div>
        <div class="hiddensearch" style="display: none">
            <div id="datatable_filter" class="dataTables_filter col s6">
                <form>
                <div class="row">
                    <div class="input-field col">
                        <input id="start" type="text" name="start" class="date" value="<?php echo $start;?>" />
                    </div>
                    <div class="input-field col">
                        <input id="end" type="text" name="end" class="date" value="<?php echo $end;?>">
                    </div>
                    <div class="col"><a onclick="document.forms[0].submit()" class="waves-effect waves-light btn">搜尋</a></div>
                </div>
                </form>
            </div>
        </div>
        <table class="table" id="list" v-cloak>
            <thead>
                <tr>
                    <th>訂單日期</th>
                    <th>購買人</th>
                    <th>商品總金額(美金)</th>
                    <th>商品總金額(台幣)</th>
                    <th  class="center-align">功能</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($orderList as $key => $info) { ?>
            <tr class="product">
                <td><?php echo $info['date'];?></td>
                <td><?php echo $info['buyer'];?></td>
                <td><?php echo $info['total_cost_us'];?></td>
                <td><?php echo $info['total_cost_nt'];?></td>
                <td  class="center-align">
                    <a href="#modalEdit" class="waves-effect btn-flat" data-type="a-model" data-type="edit" data-id="<?php echo $info['id'];?>">
                        <i class="material-icons" data-type="a-model">mode_edit</i>
                    </a>
                    <a onclick="deleteOrder('<?php echo $info['id'];?>', '<?php echo $info['buyer'];?>')" class="waves-effect btn-flat" data-type="delete">
                        <i class="material-icons" data-type="delete">close</i>
                      </a>
                </td>
            </tr>
            <tr class="expand">
                <td colspan="6">
                    <div style="display: none">
                        <table>
                            <tr>
                                <th>品名</th>
                                <th>數量</th>
                                <th>規格</th>
                                <th>重量</th>
                                <th>存放倉庫</th>
                                <th>售價</th>
                                <th>折扣</th>
                            </tr>
                            <?php foreach($info['productInfo'] as $productInfo) { ?>
                            <tr>
                                <td><?php echo $productInfo['name']?></td>
                                <td><?php echo $productInfo['amount']?></td>
                                <td><?php echo $productInfo['standard']?></td>
                                <td><?php echo $productInfo['weight']?></td>
                                <td><?php echo $productInfo['warehouse']?></td>
                                <td><?php echo $productInfo['price']?></td>
                                <td><?php echo $productInfo['discount']?></td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>
                </td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>


<!-- Modal edit -->
<div id="modalEdit" class="modal modal-full">
    <div class="modal-content" id="inlineAjaxEdit">
    </div>
</div>

<div id="modalAdd" class="modal modal-full">
    <div class="modal-content" id="inlineAjaxAdd">
    </div>
</div>

<script type="text/javascript">
$('.modal').modal({
    dismissible: false, // Modal can be dismissed by clicking outside of the modal
    opacity: .5, // Opacity of modal background
    startingTop: '0', // Starting top style attribute
    endingTop: '0', // Ending top style attribute
    ready: function(modal, trigger) {
        var id = $(trigger).attr('data-id');
        var type = $(trigger).attr('data-type');

        if (type == 'add') {
            $("#inlineAjaxAdd").load("<?php echo base_url(); ?>product/order");
        } else {
            $("#inlineAjaxEdit").load("<?php echo base_url(); ?>product/orderEdit?id=" + id);
        }
    },
    complete: function() {
    } 
});

var list = new Vue({
    el: '#list',
    data: {
        count: <?php echo count($orderList);?>,
        showOrder: [],
    },
    mounted: function () {
        for(num = 0; num < this.count; num++) {
            this.showOrder.push(false);
        }
    },
    methods: {
        checkShow: function (key) {
            Vue.set(this.showOrder, key, !this.showOrder[key]);
        }
    }
});

function deleteOrder(id, buyer, product)
{
    swal({
        title: "注意",
        text: "您確定要刪除" + buyer + "嗎？",
        showCancelButton: true,
        cancelButtonText: "取消",
        type: "warning"
    },
    function () {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>product/deleteOrder",
            data: {
                id: id,
                chiuko_o_token: $('#csrf').attr('content'),
            },
            success: function(response) {
                location.reload();
            },
        });
    });
}

$('.product').click(function(e) {
    var type = e.target.getAttribute('data-type');

    if (type != 'a-model' && type != 'delete') {
        var target = $(this).next();
        target.find("div").slideToggle();
    }
});

$('.search-toggle').click(function() {
  if ($('.hiddensearch').css('display') == 'none')
    $('.hiddensearch').slideDown();
  else
    $('.hiddensearch').slideUp();
});
</script>
