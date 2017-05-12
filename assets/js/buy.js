Vue.use(VeeValidate);

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
        date: '',
        idCard: '',
        remark: '',
        pre_money: 0,
        rate: 1,
        discount: 0,
        price: 0,
        fare: 0,
        costTotalSumUs: 0,
        costTotalSumNt: 0,
        totalFare: 0,
        productCount: [],
        csrf_value: $('#csrf').attr('content'),
    },
    mounted: function() {
        getProduct();
    },
    methods: {
        addProduct: function() {
            var productSelect = $('#productSelect').val();
            var checkAdd = true;

            //檢查是否已被加入
            this.productGroup.map(function(product) {
                if (product.name == productSelect) {
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
                    if (info.name == productSelect) {
                        buy.productGroup.push({
                            name: info.name,
                            realName: info.realName,
                            fare: buy.fare,
                            amount: info.amount,
                            price: buy.price,
                            discount: buy.discount,
                            weight: info.weight,
                            standard: info.standard,
                        });
                        //default 1
                        buy.productCount.push(1);
                    }
                });

                this.price = 0;
                this.discount = 0;
                this.fare = 0;
            }

            this.productSum();
        },
        changeProductNum: function(num, amount, key) {
            if (parseInt(num) > parseInt(amount)) {
                buy.productCount[key] = amount;

                swal(
                  '注意!',
                  '超過可購買最大數量',
                  'warning'
                );
            } else {
                buy.productCount[key] = num;
            }

            this.productSum();
        },
        productSum: function() {
            var sumUs = 0;
            var sumNt = 0;
            var fire = 0;
            var group = this.productGroup;
            var count = this.productCount;

            group.map(function(product, key) {
                sumUs += ( parseInt(product.price) * parseInt(count[key]) );

                if ( parseInt(product.discount) > 0 ) {
                    sumUs = sumUs * ( (100 - parseInt(product.discount)) / 100 );
                }
                //運費
                fire += parseInt(product.fare);
            });
            //扣掉預付
            sumUs = sumUs - parseInt(this.pre_money);
            //乘匯率
            sumNt = sumUs * this.rate;

            this.totalFare = Math.round(fire);
            this.costTotalSumUs = Math.round(sumUs);
            this.costTotalSumNt = Math.round(sumNt) + this.totalFare;
        },
        validateBeforeSubmit: function(insertData) {
            this.$validator.validateAll().then(() => {
                orderInsert(insertData);
            }).catch(() => {
                //
            });
        },
        orderUpdate: function() {
            var county = $('select[name=county]').val();
            var district = $('select[name=district]').val();
            var zipcode = $('input[name=zipcode]').val();

            var insertData = {
                orderNum: orderNum,
                buyer: this.name,
                county: county,
                district: district,
                zipcode: zipcode,
                addressDetail: this.addressDetail,
                phone: this.phone,
                idCard: this.idCard,
                remark: this.remark,
                date: this.date,
                productInfo: JSON.stringify(this.productGroup),
                productCount: JSON.stringify(this.productCount),
                pre_money: this.pre_money,
                rate: this.rate,
                fare: this.totalFare,
                total_cost_nt: this.costTotalSumNt,
                total_cost_us: this.costTotalSumUs,
            };

            this.validateBeforeSubmit(insertData);
        },
    }
});

function getProduct()
{
    $.ajax({
        type: "GET",
        url: "getProductNotRepeat",
        success: function(product) {
            buy.onlineProduct = JSON.parse(product);
        },
    });
}


function orderInsert(insertData)
{
    $.ajax({
        type: "POST",
        url: "orderUpdate",
        data: {
            insertData: insertData,
            chiuko_o_token: buy.csrf_value,
        },
        success: function(response) {
            swal({
                title: "成功",
                text: '新增成功',
                type: "success"
            },
            function(){
               location.reload();
            });
        },
    });
}