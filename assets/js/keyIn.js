var keyIn = new Vue({
    el: '#keyIn',
    data: {
        product: [{
            name: '',
            weight: '',
            money: '',
            discount: '',
            remark: '',
            status: 1,
        }],
        csrf_value: $('#csrf').attr('content'),
        allProduct: []
    },
    mounted: function () {
        getALLNowProduct()
    },
    methods: {
        addProduct: function () {
            this.product.push({
                name: '',
                weight: '',
                money: '',
                discount: '',
                remark: '',
                status: 1,
            });
        },
        removeProduct: function (key) {
            this.product.splice(key, 1);
        },
        keyInPost: function () {
            ajaxKeyInPost();
        },
        editUpdate: function (product, key) {
            editUpdate(product, key);
        },
        getStatusCn: function (status) {
            if ( status == 1 ) {
                return '上架';
            } else if ( status == 2 ) {
                return '下架';
            }
        },
        checkSeleted: function (status, source) {
            if (status == source) {
                return "selected";
            }
        },
        changeMethod: function (nowKey) {
            keyIn.allProduct = keyIn.allProduct.map(function (product, key) {
                if (nowKey == key) {
                    product.checkText = ! product.checkText;
                    product.checkInput = ! product.checkInput;
                }

                return product;
            });
        },
        deleteCheck: function (name, id, key) {
            swal({
                title: "注意",
                text: "您確定要刪除" + name + "嗎？",
                showCancelButton: true,
                cancelButtonText: "取消",
                type: "warning"
            },
            function () {
                deleteById(id, key);
            });
        }
    }
});

function ajaxKeyInPost()
{
    //array remove empty data
    keyIn.product = keyIn.product.filter(function (info) {
        if (info.name != '') {
            return info;
        }
    });

    $.ajax({
        type: "POST",
        url: "keyInUpdate",
        data: {
            product: keyIn.product,
            chiuko_o_token: keyIn.csrf_value,
        },
        success: function(response) {
            location.reload();
        },
    });
}

function editUpdate(updateProduct, updateKey)
{
    $.ajax({
        type: "POST",
        url: "editUpdate",
        data: {
            product: updateProduct,
            chiuko_o_token: keyIn.csrf_value,
        },
        success: function(response) {
            keyIn.csrf_value = response;

            keyIn.allProduct = keyIn.allProduct.map(function (product, key) {
                if (updateKey == key) {
                    updateProduct.checkText = ! updateProduct.checkText;
                    updateProduct.checkInput = ! updateProduct.checkInput;

                    return updateProduct;
                }

                return product;
            });
        },
    });
}


function deleteById(id, key)
{
    $.ajax({
        type: "POST",
        url: "deleteById",
        data: {
            id: id,
            chiuko_o_token: keyIn.csrf_value,
        },
        success: function(response) {
            keyIn.csrf_value = response;

            keyIn.allProduct.splice(key, 1);
        },
    });
}

function getALLNowProduct()
{
    $.ajax({
        type: "get",
        url: "getAllProduct",
        success: function(response) {
            keyIn.allProduct = JSON.parse(response);

            //add check show
            keyIn.allProduct.map(function (value) {
                value.checkText = true;
                value.checkInput = false;

                return value;
            });
        },
    });
}