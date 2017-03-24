<?php

namespace Smile\EzUICampaignBundle\Form\ActionDispatcher;

use EzSystems\RepositoryForms\Form\ActionDispatcher\AbstractActionDispatcher;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CampaignListActionDispatcher extends AbstractActionDispatcher
{
    /**
     * @param OptionsResolver $resolver
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('name');
    }

    /**
     * @return string
     */
    protected function getActionEventBaseName()
    {
        return 'smilecampaign_list';
    }
}
