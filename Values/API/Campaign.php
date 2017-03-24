<?php

namespace Smile\EzUICampaignBundle\Values\API;

use eZ\Publish\API\Repository\Values\ValueObject;

abstract class Campaign extends ValueObject
{
    protected $id;

    protected $name;
}
