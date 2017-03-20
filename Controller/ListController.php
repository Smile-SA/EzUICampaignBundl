<?php

namespace Smile\EzUICampaignBundle\Controller;

use Smile\EzUICampaignBundle\Service\ListService;

class ListController extends AbstractCampaignController
{
    /** @var ListService $listService */
    protected $listService;

    public function __construct(
        ListService $listService
    )
    {
        $this->listService = $listService;
    }

    public function viewAction($id)
    {
        return $this->render('SmileEzUICampaignBundle:campaign:list/view.html.twig', [
            'campaign' => $this->listService->get($id)
        ]);
    }
}
