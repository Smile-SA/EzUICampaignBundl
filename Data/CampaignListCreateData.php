<?php

namespace Smile\EzUICampaignBundle\Data;

use EzSystems\RepositoryForms\Data\NewnessCheckable;
use Smile\EzUICampaignBundle\Values\CampaignListCreateStruct;

class CampaignListCreateData extends CampaignListCreateStruct implements NewnessCheckable
{
    use CampaignListDataTrait;

    public function isNew()
    {
        return true;
    }
}
