<?php

namespace Smile\EzUICampaignBundle\Controller;

use Smile\EzUICampaignBundle\Service\CampaignsFolderService;
use Smile\EzUICampaignBundle\Service\CampaignsService;

class CampaignsController extends AbstractCampaignController
{
    /** @var CampaignsService $campaignsService */
    protected $campaignsService;

    /** @var CampaignsFolderService $campaignsFolderService */
    protected $campaignsFolderService;

    public function __construct(
        CampaignsService $campaignsService,
        CampaignsFolderService $campaignsFolderService
    )
    {
        $this->campaignsService = $campaignsService;
        $this->campaignsFolderService = $campaignsFolderService;
    }
}
