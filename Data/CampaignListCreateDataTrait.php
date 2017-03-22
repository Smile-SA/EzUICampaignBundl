<?php

namespace Smile\EzUICampaignBundle\Data;

use EzSystems\RepositoryForms\Data\NewnessCheckable;
use Smile\EzUICampaignBundle\Values\CampaignListCreateStruct;

class CampaignListCreateDataTrait extends CampaignListCreateStruct implements NewnessCheckable
{
    use CampaignListDataTrait;

    public function isNew()
    {
        return true;
    }
}
