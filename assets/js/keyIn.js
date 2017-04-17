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
        csrf_value: $('#csrf').val(),
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
        formPost: function () {
            ajaxformPost();
        }
    }
});

function ajaxformPost()
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

        },
    });

}