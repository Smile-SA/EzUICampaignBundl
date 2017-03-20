<?php

namespace Smile\EzUICampaignBundle\Controller;

use Smile\EzUICampaignBundle\Service\ListsService;
use Symfony\Component\HttpFoundation\Request;

class ListsController extends AbstractCampaignController
{
    /** @var ListsService $listsService */
    protected $listsService;

    public function __construct(
        ListsService $listsService
    )
    {
        $this->listsService = $listsService;
    }

    public function newAction()
    {
        return $this->render('SmileEzUICampaignBundle:campaign:lists/new.html.twig', []);
    }

    public function folderNewAction(Request $request)
    {

    }
}
