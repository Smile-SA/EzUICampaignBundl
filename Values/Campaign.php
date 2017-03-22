<?php

namespace Smile\EzUICampaignBundle\Values;

class Campaign extends AbstractCampaign
{
    protected $settings;

    protected $recipients;

    public function getSettings()
    {
        return $this->settings;
    }

    public function getRecipients()
    {
        return $this->recipients;
    }
}
