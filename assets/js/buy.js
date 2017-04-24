var buy = new Vue({
    el: '#buy',
    data: {
        onlineProduct: [],
        productGroup: [],
        name: '',
        county: '',
        district: '',
        zipcode: '',
        addressDetail: '',
        phone: '',
        idCard: '',
        remark: '',
        productCount: [],
        csrf_value: $('#csrf').attr('content'),
    },
    mounted: function() {
        getOnlineProduct();
    },
    methods: {
        addProduct: function() {
            var productSelect = $('#productSelect').val();

            if (productSelect != '') {
                this.onlineProduct.filter(function(info) {
                    if (info.id == productSelect) {
                        buy.productGroup.push(info);
                        //default 1
                        buy.productCount.push(1);

                    }
                });
            }
        },
        changeProductNum: function(num, amount, key) {
            console.log(num);
            if (num > amount) {
                buy.productCount[key] = amount;

                swal(
                  '注意!',
                  '超過可購買最大數量',
                  'warning'
                );
            } else {
                buy.productCount[key] = num;
            }
        }
    }
});

function getOnlineProduct()
{
    $.ajax({
        type: "GET",
        url: "getOnlineProduct",
        success: function(product) {
            buy.onlineProduct = JSON.parse(product);
        },
    });
}