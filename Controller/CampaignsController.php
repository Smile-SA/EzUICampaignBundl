<?php

namespace Smile\EzUICampaignBundle\Controller;

use Smile\EzUICampaignBundle\Service\CampaignsFolderService;
use Smile\EzUICampaignBundle\Service\CampaignsService;
use Symfony\Component\HttpFoundation\Request;

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

    public function newAction()
    {
        return $this->render('SmileEzUICampaignBundle:campaign:campaigns/new.html.twig', []);
    }

    public function folderNewAction(Request $request)
    {

    }
}
