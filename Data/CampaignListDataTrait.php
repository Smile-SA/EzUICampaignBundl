<?php

namespace Smile\EzUICampaignBundle\Data;

use Smile\EzUICampaignBundle\Values\CampaignList;

trait CampaignListDataTrait
{
    /**
     * @var CampaignList $campaignList
     */
    protected $campaignList;

    public function setCampaignList(CampaignList $campaignList)
    {
        $this->campaignList = $campaignList;
    }

    public function getId()
    {
        return $this->campaignList ? $this->campaignList->id : null;
    }
}
