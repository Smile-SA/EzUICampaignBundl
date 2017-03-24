<?php

namespace Smile\EzUICampaignBundle\Form\Type\Field;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;

class CampaignType extends AbstractType
{
    public function getParent()
    {
        return SearchType::class;
    }
}
