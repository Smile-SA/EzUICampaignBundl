<?php

namespace Smile\EzUICampaignBundle;

use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\EzPublishCoreExtension;
use Smile\EzUICampaignBundle\DependencyInjection\Security\PolicyProvider\UICampaignPolicyProvider;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SmileEzUICampaignBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        /** @var EzPublishCoreExtension $eZExtension */
        $eZExtension = $container->getExtension('ezpublish');
        $eZExtension->addPolicyProvider(new UICampaignPolicyProvider($this->getPath()));
    }
}
