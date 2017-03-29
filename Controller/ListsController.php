<?php

namespace Smile\EzUICampaignBundle\Controller;

use Smile\EzUICampaignBundle\Service\ListsService;

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
}
