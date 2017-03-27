<?php

namespace Smile\EzUICampaignBundle\Values\Core;

class CampaignList extends \Smile\EzUICampaignBundle\Values\API\CampaignList
{
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getState()
    {
        return $this->state;
    }

    public function getZip()
    {
        return $this->zip;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function getCampaign()
    {
        return $this->campaign;
    }
}
