<?php

namespace Smile\EzUICampaignBundle\Values;

use eZ\Publish\API\Repository\Values\ValueObject;

abstract class AbstractCampaign extends ValueObject
{
    protected $id;

    protected $settings;

    protected $recipients;
}
