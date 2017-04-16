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
        }
    }
})