<?php

namespace Smile\EzUICampaignBundle\Data;

use EzSystems\RepositoryForms\Data\NewnessCheckable;

class CampaignCreateData extends CampaignCreateStruct implements NewnessCheckable
{
    use CampaignDataTrait;

    public function isNew()
    {
        return true;
    }
}
