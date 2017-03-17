<?php

namespace Smile\EzUICampaignBundle\Controller;

use Smile\EzUICampaignBundle\Service\ListsService;
use Symfony\Component\HttpFoundation\Request;

class ListController extends AbstractCampaignController
{
    /** @var ListsService $listsService */
    protected $listsService;

    /**
     * CampaignController constructor.
     *
     * @param string[] $tabItems tab item names
     */
    public function __construct(
        ListsService $listsService
    )
    {
        $this->listsService = $listsService;
    }

    public function viewAction(Request $request, $id)
    {

    }
}
