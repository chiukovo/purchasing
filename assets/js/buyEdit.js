Vue.use(VeeValidate);

var buy = new Vue({
    el: '#buy',
    data: {
        onlineProduct: [],
        productGroup: [],
        warehouseSelect: [],
        nowProduct: '',
        nowWareHouse: '',
        amount: 0,
        lb_price: lb_price,
        name: name,
        county: county,
        district: district,
        zipcode: zipcode,
        addressDetail: addressDetail,
        phone: phone,
        date: date,
        idCard: idCard,
        remark: remark,
        pre_money: pre_money,
        rate: rate,
        discount: 0,
        price: 0,
        fare: 0,
        costTotalSumUs: total_cost_us,
        costTotalSumNt: total_cost_nt,
        totalFare: fare,
        id: id,
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

            if ( ! buy.nowWareHouse) {
                swal(
                    '注意!',
                    '請選擇所在倉庫',
                    'warning'
                );
            } else {
                //檢查是否已被加入
                this.productGroup.map(function(product) {
                    if (product.name == productSelect && product.warehouse == buy.nowWareHouse) {
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
                                amount: buy.amount,
                                warehouse: buy.nowWareHouse,
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
            }
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
            var weight = 0;
            var boxWeight = 0;
            var group = this.productGroup;
            var count = this.productCount;

            group.map(function(product, key) {
                sumUs += ( parseInt(product.price) * parseInt(count[key]) );

                if ( parseInt(product.discount) > 0 ) {
                    sumUs = sumUs * ( (100 - parseInt(product.discount)) / 100 );
                }
                //總重量
                weight += parseInt(product.weight);
                //混合箱
                boxWeight += parseInt(product.boxWeight);
            });
            //扣掉預付
            sumUs = sumUs - parseInt(this.pre_money);
            //乘匯率
            sumNt = sumUs * this.rate;

            //運費的計算
            this.totalFare = Math.round(weight + (boxWeight * this.lb_price));

            this.costTotalSumUs = Math.round(sumUs);
            this.costTotalSumNt = Math.round(sumNt) + this.totalFare;
        },
        validateBeforeSubmit: function(updateData) {
            this.$validator.validateAll().then(() => {
                orderUpdate(updateData);
            }).catch(() => {
                //
            });
        },
        orderUpdate: function() {
            var county = $('select[name=county]').val();
            var district = $('select[name=district]').val();
            var zipcode = $('input[name=zipcode]').val();

            var updateData = {
                orderNum: orderNum,
                buyer: this.name,
                county: county,
                district: district,
                zipcode: zipcode,
                addressDetail: this.addressDetail,
                phone: this.phone,
                idCard: this.idCard,
                remark: this.remark,
                date: $('#date').val(),
                productInfo: JSON.stringify(this.productGroup),
                productCount: JSON.stringify(this.productCount),
                pre_money: this.pre_money,
                rate: this.rate,
                fare: this.totalFare,
                total_cost_nt: this.costTotalSumNt,
                total_cost_us: this.costTotalSumUs,
            };

            this.validateBeforeSubmit(updateData);
        },
        changeProduct: function(name) {
            this.nowProduct = name;

            if (name == '') {
                buy.amount = 0;
                buy.warehouseSelect = [];
            } else {
                this.onlineProduct.map(function(info, key) {
                    if (info.name == name) {
                       buy.warehouseSelect = info.warehouse;
                       buy.amount = info.amount[info.warehouse[0]];
                       buy.nowWareHouse = info.warehouse[0];
                    }
                });
            }
        },
        changeWareHouse: function(e) {
            var selected = e.target.value;
            this.nowWareHouse = selected;

            this.onlineProduct.map(function(info, key) {
                if (info.name == buy.nowProduct) {
                   buy.amount = info.amount[selected];
                }
            });
        },
        deleteProduct: function(key, thisName) {
            swal({
                title: "注意",
                text: "您確定要刪除" + thisName + "嗎？",
                showCancelButton: true,
                cancelButtonText: "取消",
                type: "warning"
            },
            function () {
                buy.productGroup.splice(key, 1);

                buy.productSum();
            });
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

            //add edit product
            buy.productGroup = JSON.parse(productInfo);

            buy.productCount = buy.productGroup.map(function(info) {
                return info.amount;
            });

            buy.onlineProduct.map(function(info) {
                buy.productGroup.map(function(detail, key) {
                    if (info.name == detail.name) {
                        buy.productGroup[key]['amount'] = info.amount[detail.warehouse];
                    }
                });
            });
        },
    });
}


function orderUpdate(updateData)
{
    $.ajax({
        type: "post",
        url: "orderEditUpdate",
        data: {
            id: id,
            updateData: updateData,
            chiuko_o_token: buy.csrf_value,
        },
        success: function(response) {
            if (response == '') {
                swal({
                    title: "成功",
                    text: '修改成功',
                    type: "success"
                },
                function(){
                   location.reload();
                });
            } else {
                swal({
                    title: "失敗",
                    text: response,
                    type: "warning"
                },
                function(){
                });
            }

        },
    });
}