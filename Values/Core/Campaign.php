<?php

namespace Smile\EzUICampaignBundle\Values\Core;

class Campaign extends \Smile\EzUICampaignBundle\Values\API\Campaign
{
    public function getRecipients()
    {
        return $this->recipients;
    }

    public function getSettings()
    {
        return $this->settings;
    }
}
