YUI.add('smileezuicampaign-view', function (Y) {
    "use strict";
    Y.namespace('SmileEzUICampaign');

    Y.SmileEzUICampaign.CampaignView = Y.Base.create('campaignView', Y.eZ.FieldView, [], {
        _isFieldEmpty: function () {
            return (this.get('field').fieldValue === null);
        },

        _getName: function () {
            return Y.SmileEzUICampaign.CampaignView.NAME;
        },
    });

    Y.eZ.FieldView.registerFieldView('smileezuicampaign', Y.SmileEzUICampaign.CampaignView);
});
