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
        },

        render: function () {
            this.get('container').setContent(this.get('html'));

            var items = this.get('container').all('input[type="search"]');
            items.each(function(item) {
                item.plug(Y.Plugin.AutoComplete, {
                    resultHighlighter: 'phraseMatch',
                    maxResults: 10,
                    source: item.getData('action') + '/{query}'
                });
            });
            return this;
        },
    });
});
