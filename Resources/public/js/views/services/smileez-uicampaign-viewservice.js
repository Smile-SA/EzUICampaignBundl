YUI.add('smileez-uicampaign-viewservice', function (Y) {
    Y.namespace('smileEzUICampaign');

    Y.smileEzUICampaign.ViewService = Y.Base.create('smileezuicampaignViewService', Y.eZ.ServerSideViewService, [], {
        initializer: function () {
console.log('campaign view service initializer');
            this.on('*:navigateTo', function (e) {
                this.get('app').navigateTo(
                    e.routeName,
                    e.routeParams
                );
            });
        },

        _load: function (callback) {
console.log('campaign view service _load');
            uri = this.get('app').get('apiRoot') + 'campaign/campaigns/tab';

            Y.io(uri, {
                method: 'GET',
                on: {
                    success: function (tId, response) {
console.log('campaign view service _load : response');
console.log(response);
                        this._parseResponse(response);
                        callback(this);
                    },
                    failure: this._handleLoadFailure
                },
                context: this
            });
        }
    });
});
