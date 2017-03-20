YUI.add('smile-campaign-view', function (Y) {
    "use strict";
    Y.namespace('Smile');

    Y.Smile.CampaignView = Y.Base.create('campaignView', Y.eZ.FieldView, [], {
        _isFieldEmpty: function () {
            return (this.get('field').fieldValue === null);
        },

        _getName: function () {
            return Y.Smile.CampaignView.NAME;
        },
    });

    Y.eZ.FieldView.registerFieldView('smilecampaign', Y.Smile.CampaignView);
});
