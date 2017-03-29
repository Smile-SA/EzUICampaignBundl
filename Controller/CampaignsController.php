<?php

namespace Smile\EzUICampaignBundle\Controller;

use Smile\EzUICampaignBundle\Service\CampaignFoldersService;
use Smile\EzUICampaignBundle\Service\CampaignsService;

class CampaignsController extends AbstractCampaignController
{
    /** @var CampaignsService $campaignsService */
    protected $campaignsService;

    /** @var CampaignFoldersService $campaignFoldersService */
    protected $campaignFoldersService;

    public function __construct(
        CampaignsService $campaignsService,
        CampaignFoldersService $campaignFoldersService
    )
    {
        $this->campaignsService = $campaignsService;
        $this->campaignFoldersService = $campaignFoldersService;
    }

    public function searchAction($query)
    {
        $campaigns = $this->campaignsService->search($query);

        return json_encode($campaigns['results']);
    }
}
