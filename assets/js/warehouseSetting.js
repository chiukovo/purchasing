var setting = new Vue({
    el: '#warehouse_setting',
    data: {
        name: [],
        receiver: [],
        freight: [],
        addFreight: '',
        addReceiver: '',
        addName: '',
        csrf_value: $('#csrf').attr('content'),
    },
    mounted: function () {
        getEditData();
    },
    methods: {
        addSetting: function (data, type) {
            if (data == '') {
                swal({
                    title: "注意",
                    text: "數值不得為空",
                    type: "warning"
                });
            } else {
                var updateData;

                switch (type)
                {
                    case 'name':
                        this.name.push(data);
                        this.addName = [];
                        break;
                    case 'receiver':
                        this.receiver.push(data);
                        this.addReceiver = [];
                        break;
                    case 'freight':
                        this.freight.push(data);
                        this.addFreight = [];
                        break;
                }

                doUpdate();
            }
        },
        deleteCheck: function (key, type, info) {
            var updateData;

            swal({
                title: "注意",
                text: "您確定要刪除" + info + "嗎？",
                showCancelButton: true,
                cancelButtonText: "取消",
                type: "warning"
            },
            function () {
                switch (type)
                {
                    case 'name':
                        setting.name.splice(key, 1);
                        break;
                    case 'receiver':
                        setting.receiver.splice(key, 1);
                        break;
                    case 'freight':
                        setting.freight.splice(key, 1);
                        break;
                }

                doUpdate();
            });
        },
    }
});

function getEditData()
{
    $.ajax({
        type: "get",
        url: "getAllSetting",
        success: function(response) {
            var result = JSON.parse(response);
            setting.name = JSON.parse(result.name);
            setting.receiver = JSON.parse(result.receiver);
            setting.freight = JSON.parse(result.freight);
        },
    });
}

function doUpdate()
{
    $.ajax({
        type: "POST",
        url: "doUpdate",
        data: {
            name: setting.name,
            receiver: setting.receiver,
            freight: setting.freight,
            chiuko_o_token: setting.csrf_value,
        },
        success: function(csrf) {
            setting.csrf_value = csrf;
        },
    });
}