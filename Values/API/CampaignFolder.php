<?php

namespace Smile\EzUICampaignBundle\Values\API;

use eZ\Publish\API\Repository\Values\ValueObject;

abstract class CampaignFolder extends ValueObject
{
    protected $id;

    protected $name;
}
