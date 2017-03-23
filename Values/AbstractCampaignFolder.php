<?php

namespace Smile\EzUICampaignBundle\Values;

use eZ\Publish\API\Repository\Values\ValueObject;

abstract class AbstractCampaignFolder extends ValueObject
{
    protected $id;

    protected $name;
}
