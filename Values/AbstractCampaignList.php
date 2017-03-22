<?php

namespace Smile\EzUICampaignBundle\Values;

use eZ\Publish\API\Repository\Values\ValueObject;

abstract class AbstractCampaignList extends ValueObject
{
    protected $id;

    protected $name;
}
