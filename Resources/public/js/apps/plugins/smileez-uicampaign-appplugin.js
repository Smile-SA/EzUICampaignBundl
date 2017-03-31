YUI.add('smileez-uicampaign-appplugin', function (Y) {
    Y.namespace('smileEzUICampaign.Plugin');

    Y.smileEzUICampaign.Plugin.AppPlugin = Y.Base.create('smileezuicampaignAppPlugin', Y.Plugin.Base, [], {
        initializer: function () {
            var app = this.get('host');

            app.views.smileezuicampaignView = {
                type: Y.smileEzUICampaign.View
            };

            app.views.smileezuicampaignCampaignEditView = {
                type: Y.smileEzUICampaign.CampaignEditView
            };

            app.route({
                name: "smileezuiCampaignNavigation",
                path: "/campaign/campaigns/tab",
                view: "smileezuicampaignView",
                service: Y.smileEzUICampaign.ViewService,
                sideViews: {'navigationHub': true, 'discoveryBar': false},
                callbacks: ['open', 'checkUser', 'handleSideViews', 'handleMainView'],
            });

            app.route({
                name: "smileezuiCampaignCampaignEditNavigation",
                path: "/admin/campaign/campaign/edit",
                view: "smileezuicampaignCampaignEditView",
                service: Y.smileEzUICampaign.CampaignEditViewService,
                sideViews: {'navigationHub': true, 'discoveryBar': false},
                callbacks: ['open', 'checkUser', 'handleSideViews', 'handleMainView'],
            });

        }
    }, {
        NS: 'smileezuicampaignTypeApp'
    });

    Y.eZ.PluginRegistry.registerPlugin(
        Y.smileEzUICampaign.Plugin.AppPlugin, ['platformuiApp']
    );
});
