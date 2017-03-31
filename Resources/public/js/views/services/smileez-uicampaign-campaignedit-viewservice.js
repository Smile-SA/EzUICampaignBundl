YUI.add('smileez-uicampaign-campaignedit-viewservice', function (Y) {
    Y.namespace('smileEzUICampaign');

    Y.smileEzUICampaign.CampaignEditViewService = Y.Base.create('smileezuicampaignCampaignEditViewService', Y.eZ.ServerSideViewService, [], {
        initializer: function () {
            this.on('*:navigateTo', function (e) {
                this.get('app').navigateTo(
                    e.routeName,
                    e.routeParams
                );
            });
        },

        _load: function (callback) {
            uri = this.get('app').get('apiRoot') + 'campaign/campaign/edit';

            Y.io(uri, {
                method: 'GET',
                on: {
                    success: function (tId, response) {
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
