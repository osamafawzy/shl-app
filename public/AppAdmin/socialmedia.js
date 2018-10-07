var SocialMedia = new Vue({
    el: '#SocialMedia',
    data: {
        SoicalMedia: [],
        baseurl: 'http://admin.shl-app.com/',
        loading: false

    },
    mounted: function () {
        var self = this;
        self.GetSocail();
    },
    methods: {
        GetSocail: function () {
            var self = this;
            self.loading = true;
            axios.get(self.baseurl + 'socialmedia?')
                .then(function (response) {
                    console.log(response.data);
                    self.SoicalMedia = response.data;
                    self.loading = false
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        UpdateSocialMedia: function (social_meidea) {
            var self = this;
            self.loading = true;
            axios.put(self.baseurl + 'updatesoicamedia/' + social_meidea.socialmeida_id, social_meidea)
                .then(function (response) {
                    console.log(response.data);
                    self.loading = false;
                    self.$notify({
                        title: '    ',
                        message: 'تم التعديل بنجاح   ',
                        type: 'success'
                    });
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

    }
});