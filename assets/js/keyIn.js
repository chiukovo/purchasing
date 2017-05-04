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
        date: '',
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
        }
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

    $.ajax({
        type: "POST",
        url: "keyInUpdate",
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