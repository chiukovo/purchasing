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
        pre_money: 0,
        rate: USA,
        productCount: [],
        csrf_value: $('#csrf').attr('content'),
    },
    mounted: function() {
        getOnlineProduct();
    },
    methods: {
        addProduct: function() {
            var productSelect = $('#productSelect').val();
            var checkAdd = true;

            //檢查是否已被加入
            buy.productGroup.map(function(product) {
                if (product.id == productSelect) {
                    checkAdd = false;
                    swal(
                        '注意!',
                        '此產品已被加入',
                        'warning'
                    );
                }
            });

            if (productSelect != '' && checkAdd) {
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
            if (parseInt(num) > parseInt(amount)) {
                console.log('in');
                buy.productCount[key] = amount;

                swal(
                  '注意!',
                  '超過可購買最大數量',
                  'warning'
                );
            } else {
                buy.productCount[key] = num;
            }
        },
        productSum: function() {
            var sum = 0;
            var group = this.productGroup;
            var count = this.productCount;
            
            group.map(function(product, key) {
                sum += ( parseInt(product.money) * parseInt(count[key]) );

                if ( parseInt(product.discount) > 0 ) {
                    sum = sum * ( (100 - parseInt(product.discount)) / 100 );
                }
            });

            //扣掉預付
            sum = sum - parseInt(this.pre_money);
            //乘匯率
            sum = sum * this.rate;
            return Math.round(sum);
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