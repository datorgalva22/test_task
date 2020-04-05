var app = new Vue({
    el: '#test_task',
    data: {

        loading: true,
        currentChannelId: null,
        info: {},
        infoBox: false,
        channels: {},
        guide: {},
    },

    methods: {

        getData: function (action, arg = null) {
            var self = this;
            self.loading = true;

            var data = {};
            var link = '/get' + action;

            if (action == 'renewGuide') {
                link = action;
            }

            if (action == 'guide' || action == 'info') {
                var param = '/' + arg;
            } else {
                param = '';
            }

            this.$http.get(link + param, data).then(function (response) {
                self.loading = false;

                if (response.status == 200) {

                    self[action] = response.data;
                    self.errors = {};

                    if (action == 'renewGuide') {
                        self.getData("guide", self.currentChannelId);
                    }

                } else if (response.data.error) {
                    self.errors = response.data.errors;
                } else {
                    self.errors = {global: 'Servisa kļūda'};
                }
            }, function (response) {
                self.loading = false;
                self.errors = {global: 'Servisa kļūda'};
            });
        },

        showInfo: function (guid) {
            
            this.getData("info", guid);
            this.infoBox = true;
        },
    },

    mounted: function () {

        this.getData("channels");
    },
})