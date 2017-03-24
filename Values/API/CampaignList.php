<?php

namespace Smile\EzUICampaignBundle\Values\API;

use eZ\Publish\API\Repository\Values\ValueObject;

abstract class CampaignList extends ValueObject
{
    protected $id;

    protected $name;

    protected $company;

    protected $address;

    protected $city;

    protected $state;

    protected $zip;

    protected $country;

    protected $campaign;
}
