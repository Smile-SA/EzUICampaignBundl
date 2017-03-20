<?php

namespace Smile\EzUICampaignBundle\Controller;

use Smile\EzUICampaignBundle\Service\CampaignFoldersService;
use Smile\EzUICampaignBundle\Service\CampaignsService;
use Symfony\Component\HttpFoundation\Request;

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

    public function newAction()
    {
        return $this->render('SmileEzUICampaignBundle:campaign:campaigns/new.html.twig', []);
    }

    public function folderNewAction(Request $request)
    {
        return $this->render('SmileEzUICampaignBundle:campaign:campaignFolders/new.html.twig', []);
    }
}
