YUI.add('smile-campaign-view', function (Y) {
    "use strict";
    Y.namespace('Smile');

    var CAMPAIGN_JSONP_URI = '/campaign/campaign/';

    Y.Smile.CampaignView = Y.Base.create('campaignView', Y.eZ.FieldView, [], {
        _isFieldEmpty: function () {
            return (this.get('field').fieldValue === null);
        },

        _getName: function () {
            return Y.Smile.CampaignView.NAME;
        },

        _getFieldValue: function () {
            var value = this.get('field').fieldValue,
                container = this.get('container');

            Y.on('io:complete', this._viewCampaign, Y, [container, value]);

            var request = Y.io(CAMPAIGN_JSONP_URI + value + '/ajax');

            return value;
        },

        _viewCampaign: function(id, o, args) {
            var data = JSON.parse(o.responseText),
                container = args[0],
                value = args[1];
console.log('ZZZ0');

            container.one('.ez-fieldview-value-content').setHTML(data.settings.title + ' [' + value + ']');
        },

    });

    Y.eZ.FieldView.registerFieldView('smilecampaign', Y.Smile.CampaignView);
});
