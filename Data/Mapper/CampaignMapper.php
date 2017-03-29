<?php

namespace Smile\EzUICampaignBundle\Data\Mapper;

use eZ\Publish\API\Repository\Values\ValueObject;
use EzSystems\RepositoryForms\Data\Mapper\FormDataMapperInterface;
use Smile\EzUICampaignBundle\Data\CampaignCreateData;
use Smile\EzUICampaignBundle\Data\CampaignUpdateData;
use Smile\EzUICampaignBundle\Values\API\Campaign;

class CampaignMapper implements FormDataMapperInterface
{
    /**
     * Maps a ValueObject from eZ content repository to a data usable as underlying form data (e.g. create/update struct).
     *
     * @param ValueObject|Campaign $campaign
     * @param array $params
     *
     * @return CampaignCreateData|CampaignUpdateData
     */
    public function mapToFormData(ValueObject $campaign, array $params = [])
    {
        if (!$this->isCampaignNew($campaign)) {
            $data = new CampaignUpdateData([
                'id' => $campaign->id,
                'list_id' => $campaign->list_id,
                'subject_line' => $campaign->subject_line,
                'title' => $campaign->title,
                'from_name' => $campaign->from_name,
                'reply_to' => $campaign->reply_to,
                'folder_id' => $campaign->folder_id
            ]);
        } else {
            $data = new CampaignCreateData(['campaign' => $campaign]);
        }

        return $data;
    }

    private function isCampaignNew(Campaign $campaign)
    {
        return $campaign->id === null;
    }
}
