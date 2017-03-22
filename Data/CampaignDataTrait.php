<?php

namespace Smile\EzUICampaignBundle\Data;

use Smile\EzUICampaignBundle\Values\Campaign;

trait CampaignDataTrait
{
    /**
     * @var Campaign $campaign
     */
    protected $campaign;

    public function setCampaign(Campaign $campaign)
    {
        $this->campaign = $campaign;
    }

    public function getId()
    {
        return $this->campaign ? $this->campaign->id : null;
    }
}
