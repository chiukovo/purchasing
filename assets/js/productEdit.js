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
        allProductName: {},
        keyInProduct: [],
        listProduct: [],
        idCard: '',
        isDefault: true,
        isEdit: false,
        csrf_value: $('#csrf').attr('content'),
    },
    mounted: function () {
        autoSearch();
        getEditData();
    },
    methods: {
        addProduct: function () {
            if( ! this.keyInProduct.money_us) {
                this.keyInProduct.money_us = 0;
            }
            if( ! this.keyInProduct.money_nt) {
                this.keyInProduct.money_nt = 0;
            }
            this.listProduct.push({
                name: this.keyInProduct.name,
                weight: this.keyInProduct.weight,
                amount: this.keyInProduct.amount,
                money_us: this.keyInProduct.money_us,
                money_nt: this.keyInProduct.money_nt,
                remark: this.keyInProduct.remark,
                standard: this.keyInProduct.standard,
                isDefault: true,
                isEdit: false,
            });

            $('.purchase-add .card .row label').removeClass('active');

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
            if( ! this.productOrder.rate) {
                keyIn.productOrder.rate = 0;
            }

            if( ! this.productOrder.total_cost_us) {
                keyIn.productOrder.total_cost_us = 0;
            }
            keyIn.productOrder.total_cost_nt = parseInt(parseFloat(this.productOrder.rate) * parseInt(this.productOrder.total_cost_us));
            this.sumNTAdd('noActive');
            this.sumNTEdit('all');
        },
        sumNTAdd: function (type) {
            keyIn.keyInProduct.money_nt = parseInt(parseFloat(this.productOrder.rate) * parseInt(this.keyInProduct.money_us));

            if (type != 'noActive') {
                $('.ntAdd').next().addClass('active');
            }
        },
        sumNTEdit: function (key) {
            if (key == 'all') {
                keyIn.listProduct = keyIn.listProduct.map(function (product, key) {
                    if(typeof product.money_us == "undefined") {
                        product.money_us = 0;
                    }

                    product.money_nt = parseInt(parseFloat(keyIn.productOrder.rate) * parseInt(product.money_us));

                    return product;
                });
            } else {
                var result = parseInt(parseFloat(this.productOrder.rate) * parseInt(keyIn.listProduct[key].money_us));

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

    if (keyIn.listProduct.length == 0) {
        swal(
            '注意!',
            '請至少選擇一個產品',
            'warning'
        );
    } else {
        $.ajax({
            type: "POST",
            url: "productEditUpdate",
            data: {
                listProduct: keyIn.listProduct,
                productOrder: keyIn.productOrder,
                chiuko_o_token: keyIn.csrf_value,
            },
            success: function(response) {
                location.reload();
            },
        });
    }
}

function getEditData()
{
    $.ajax({
        type: "get",
        url: "getProductByCode",
        data: {code: code},
        success: function(response) {
            var decode = JSON.parse(response);

            keyIn.listProduct = decode.product;
            keyIn.listProduct.map(function (value) {
                value.isDefault = true;
                value.isEdit = false;

                return value;
            });

            delete decode['product'];

            keyIn.productOrder = decode;

            $('#date').val(decode.date);
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
                keyIn.allProductName[value.name] = null;
            });
        },
    });
}

$(document).ready(function() {
    $('input.autocomplete').autocomplete({
        data: keyIn.allProductName,
        onAutocomplete: function(val) {
            var modelName = $(this).attr('data-model');
            var modelKey = $(this).attr('data-key');
            switch (modelName) {
                case 'keyInProduct':
                    keyIn.keyInProduct.name = val.value;
                    break;
                case 'listProduct':
                    keyIn.listProduct[modelKey].name = val.value;
            }
        },
        minLength: 1, // The minimum length of the input for the autocomplete to start. Default: 1.
    });
});
