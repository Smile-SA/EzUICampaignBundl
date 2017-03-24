<?php

namespace Smile\EzUICampaignBundle\Data;

use EzSystems\RepositoryForms\Data\NewnessCheckable;
use Smile\EzUICampaignBundle\Values\CampaignCreateStruct;

class CampaignCreateData extends CampaignCreateStruct implements NewnessCheckable
{
    use CampaignDataTrait;

    public function isNew()
    {
        return true;
    }
}
