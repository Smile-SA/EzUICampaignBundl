YUI.add('smile-campaign-editview', function (Y) {
    "use strict";
    Y.namespace('Smile');

    var L = Y.Lang,
        FIELDTYPE_IDENTIFIER = 'smilecampaign';

    Y.Smile.CampaignEditView = Y.Base.create('campaignEditView', Y.eZ.FieldEditView, [], {
        events: {
            '.smile-campaign-input-ui input': {
                'blur': 'validate',
                'valuechange': 'validate'
            }
        },

        validate: function () {
            var validity = this._getInputValidity(),
                config = this._variables();

            if ( validity.valueMissing ) {
                this.set('errorStatus', 'This field is required');
            } else {
                this.set('errorStatus', false);
            }
        },

        _variables: function () {
            var def = this.get('fieldDefinition');

            return {
                "isRequired": def.isRequired
            };
        },

        _getInputValidity: function () {
            return this.get('container').one('.smile-campaign-input-ui input').get('validity');
        },

        _getFieldValue: function () {
            return this.get('container').one('.smile-campaign-input-ui input').get('value');
        }
    });

    Y.eZ.FieldEditView.registerFieldEditView(
        FIELDTYPE_IDENTIFIER, Y.Smile.CampaignEditView
    );
});
