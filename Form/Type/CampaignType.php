<?php

namespace Smile\EzUICampaignBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CampaignType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                $builder->create('recipients', 'form', array('virtual' => true))
                    ->add('list_id', \Smile\EzUICampaignBundle\Form\Type\Field\CampaignListType::class, ['label' => 'campaign.campaign.list'])
            )
            ->add(
                $builder->create('settings', 'form', array('virtual' => true))
                    ->add('subject_line', TextType::class, ['label' => 'campaign.campaign.subject_line'])
                    ->add('title', TextType::class, ['label' => 'campaign.campaign.title'])
                    ->add('fromName', TextType::class, ['label' => 'campaign.campaign.fromName'])
                    ->add('reply_to', EmailType::class, ['label' => 'campaign.campaign.reply_to'])
                    ->add('folder_id', \Smile\EzUICampaignBundle\Form\Type\Field\CampaignFolderType::class, ['label' => 'campaign.campaign.folder'])
            )
            ->add('save', SubmitType::class, ['label' => 'campaign.save']);
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }

    public function getBlockPrefix()
    {
        return 'smilecampaign_campaign_edit';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => '\Smile\EzUICampaignBundle\Values\CampaignStruct',
            'translation_domain' => 'smileezuicampaign',
        ]);
    }
}
