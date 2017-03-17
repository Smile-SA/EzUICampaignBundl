<?php

namespace Smile\EzUICampaignBundle\Controller;

use Smile\EzUICampaignBundle\Service\ListsFolderService;
use Smile\EzUICampaignBundle\Service\ListsService;
use Symfony\Component\HttpFoundation\Request;

class ListsController extends AbstractCampaignController
{
    /** @var ListsService $listsService */
    protected $listsService;

    /** @var ListsFolderService $listsFolderService */
    protected $listsFolderService;

    public function __construct(
        ListsService $listsService,
        ListsFolderService $listsFolderService
    )
    {
        $this->listsService = $listsService;
        $this->listsFolderService = $listsFolderService;
    }

    public function newAction()
    {
        return $this->render('SmileEzUICampaignBundle:campaign:lists/new.html.twig', []);
    }

    public function folderNewAction(Request $request)
    {

    }
}
