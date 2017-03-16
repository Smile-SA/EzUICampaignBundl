YUI.add('smileez-uicampaign-navigationplugin', function (Y) {
    Y.namespace('smileEzUICampaign.Plugin');

    Y.smileEzUICampaign.Plugin.NavigationPlugin = Y.Base.create('smileezuicampaignNavigationPlugin', Y.eZ.Plugin.ViewServiceBase, [], {
        initializer: function () {
            var service = this.get('host'); // the plugged object is called host

            service.addNavigationItem({
                Constructor: Y.eZ.NavigationItemView,
                config: {
                    title: Y.eZ.trans('smileezuicampaign.navigationhub.campaign.title', {}, 'smileeznavigationhub'),
                    identifier: "smileez-uicampaign",
                    route: {
                        name: "smileezuiCampaignNavigation"
                    }
                }
            }, 'admin');
        },
    }, {
        NS: 'smileezuiCampaignNavigation'
    });

    Y.eZ.PluginRegistry.registerPlugin(
        Y.smileEzUICampaign.Plugin.NavigationPlugin, ['navigationHubViewService']
    );
});