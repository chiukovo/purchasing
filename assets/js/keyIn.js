var keyIn = new Vue({
    el: '#keyIn',
    data: {
        productOrder: {
            date: '',
            idCard: '',
            rate: 0,
            total_cost_us: 0,
            total_cost_nt: 0,
        },
        allProduct: [],
        allProductName: [],
        keyInProduct: [],
        listProduct: [],
        idCard: '',
        isDefault: true,
        isEdit: false,
        csrf_value: $('#csrf').attr('content'),
    },
    mounted: function () {
        autoSearch();
    },
    methods: {
        addProduct: function () {
            this.listProduct.push({
                name: this.keyInProduct.name,
                weight: this.keyInProduct.weight,
                amount: this.keyInProduct.amount,
                money_us: this.keyInProduct.money_us,
                money_nt: this.keyInProduct.money_nt,
                remark: this.keyInProduct.remark,
                tracking_code: this.keyInProduct.tracking_code,
                warehouse: this.keyInProduct.warehouse,
                freight: this.keyInProduct.freight,
                receiver: this.keyInProduct.receiver,
                standard: this.keyInProduct.standard,
                isDefault: true,
                isEdit: false,
            });
            //emtpy this ヽ(ຈل͜ຈ)ﾉ
            this.keyInProduct = [];
        },
        keyInPost: function () {
            ajaxKeyInPost();
        },
        changeMethod: function (nowKey, type) {
            switch (type) {
                case 'edit':
                case 'enter':
                    changeMethod(nowKey);
                    break;
                case 'delete':
                    this.deleteCheck(nowKey);
                    break;
            }
        },
        deleteCheck: function (nowKey) {
            var thisName = keyIn.listProduct[nowKey].name;
            thisName = (typeof thisName == "undefined") ? '' : thisName;

            swal({
                title: "注意",
                text: "您確定要刪除" + thisName + "嗎？",
                showCancelButton: true,
                cancelButtonText: "取消",
                type: "warning"
            },
            function () {
                keyIn.listProduct.splice(nowKey, 1);
            });
        },
        insert: function () {
            ajaxKeyInPost();
        },
        sumNT: function () {
            keyIn.productOrder.total_cost_nt = parseFloat(this.productOrder.rate) * parseInt(this.productOrder.total_cost_us);
            this.sumNTAdd('noActive');
            this.sumNTEdit('all');
        },
        sumNTAdd: function (type) {
            keyIn.keyInProduct.money_nt = parseFloat(this.productOrder.rate) * parseInt(this.keyInProduct.money_us);

            if (type != 'noActive') {
                $('.ntAdd').next().addClass('active');
            }
        },
        sumNTEdit: function (key) {
            if (key == 'all') {
                keyIn.listProduct = keyIn.listProduct.map(function (product, key) {
                    product.money_nt = parseFloat(keyIn.productOrder.rate) * parseInt(product.money_us);

                    return product;
                });
            } else {
                var result = parseFloat(this.productOrder.rate) * parseInt(keyIn.listProduct[key].money_us);

                keyIn.listProduct[key].money_nt = result;
            }
        },
    }
});

function changeMethod(nowKey)
{
    keyIn.listProduct = keyIn.listProduct.map(function (product, key) {
        if (nowKey == key) {
            product.isDefault = ! product.isDefault;
            product.isEdit = ! product.isEdit;
        }

        return product;
    });
}

function ajaxKeyInPost()
{
    //array remove empty data
    keyIn.listProduct = keyIn.listProduct.filter(function (info) {
        if (typeof info.name != "undefined") {
            return info;
        }
    });

    //setting date
    keyIn.productOrder.date = $('#date').val();

    $.ajax({
        type: "POST",
        url: "keyInUpdate",
        data: {
            listProduct: keyIn.listProduct,
            productOrder: keyIn.productOrder,
            chiuko_o_token: keyIn.csrf_value,
        },
        success: function(response) {
            location.href = "/purchasing/product/list";
        },
    });
}

function autoSearch()
{
    $.ajax({
        type: "get",
        url: "getAllProduct",
        success: function(response) {

            keyIn.allProduct = JSON.parse(response);

            //add autocomplete
            keyIn.allProduct.map(function (value) {
                keyIn.allProductName.push({
                    value: value.name,
                });
            });
        },
    });
}

$(document).on('keydown.autocomplete', '.autocomplete', function() {
    $('.autocomplete').autocomplete({
        lookup: keyIn.allProductName,
        onSelect: function (suggestion) {
            var modelName = $(this).attr('data-model');
            var modelKey = $(this).attr('data-key');

            switch (modelName) {
                case 'keyInProduct':
                    keyIn.keyInProduct.name = suggestion.value;
                    break;
                case 'listProduct':
                    keyIn.listProduct[modelKey].name = suggestion.value;
            }
        }
    });
});