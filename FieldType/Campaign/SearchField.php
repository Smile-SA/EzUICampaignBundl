<?php

namespace Smile\EzUICampaignBundle\FieldType\Campaign;

use eZ\Publish\SPI\Persistence\Content\Field;
use eZ\Publish\SPI\Persistence\Content\Type\FieldDefinition;
use eZ\Publish\SPI\FieldType\Indexable;
use eZ\Publish\SPI\Search;
use Smile\EzUICampaignBundle\Search\FieldType\CampaignField;

class SearchField implements Indexable
{
    public function getIndexData(Field $field, FieldDefinition $fieldDefinition)
    {
        return array(
            new Search\Field(
                'value',
                $field->value->data,
                new CampaignField()
            ),
            new Search\Field(
                'fulltext',
                $field->value->data,
                new Search\FieldType\FullTextField()
            ),
        );
    }

    public function getIndexDefinition()
    {
        return array(
            'value' => new CampaignField(),
        );
    }

    public function getDefaultMatchField()
    {
        return 'value';
    }

    public function getDefaultSortField()
    {
        return $this->getDefaultMatchField();
    }
}
