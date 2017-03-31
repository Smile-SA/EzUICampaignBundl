YUI.add('smileez-uicampaign-view', function (Y) {
    Y.namespace('smileEzUICampaign');
    var onEdit = false,
        DEFAULT_HEADERS = {'X-PJAX': 'true'};;

    Y.smileEzUICampaign.View = Y.Base.create('smileezuicampaignView', Y.eZ.ServerSideView, [], {
        events: {
            '.ez-button': {
                'tap': '_navigateToLocation'
            }
        },

        initializer: function () {
            this.containerTemplate = '<div class="ez-view-smileezuicampaignview"/>';
            Y.eZ.trans('smileezuicampaign.tab.campaigns.title', {}, 'smileezuicampaign');
            Y.eZ.trans('smileezuicampaign.tab.lists.title', {}, 'smileezuicampaign');
        },

        _navigateToLocation: function (e) {
            var link = e.target;

            e.preventDefault(); // don't want the normal link behavior

            this.fire('navigateTo', {
                route: {
                    name: link.getData('route-name')
                }
            });
        },
    });
});
