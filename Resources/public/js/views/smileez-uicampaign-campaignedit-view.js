YUI.add('smileez-uicampaign-campaignedit-view', function (Y) {
    Y.namespace('smileEzUICampaign');
    var onEdit = false,
        DEFAULT_HEADERS = {'X-PJAX': 'true'};;

    Y.smileEzUICampaign.CampaignEditView = Y.Base.create('smileezuicampaignCampaignEditView', Y.eZ.ServerSideView, [], {
        events: {
        },

        initializer: function () {
            this.containerTemplate = '<div class="ez-view-smileezuicampaignview"/>';

            Y.one('body').addClass('yui3-skin-sam');
console.log('ZZZ2');
        },

        render: function () {
            this.get('container').setContent(this.get('html'));

console.log(this.get('container').one('#smilecampaign_campaign_edit_recipients_list_id'));

            var list = this.get('container').one('#smilecampaign_campaign_edit_recipients_list_id');
            if (list) {
                list.plug(Y.Plugin.AutoComplete, {
                    resultHighlighter: 'phraseMatch',
                    source: ['foo', 'bar', 'baz']
                });
            }
            return this;
        },
    });
});
