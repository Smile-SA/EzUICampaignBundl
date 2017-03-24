<?php

namespace Smile\EzUICampaignBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CampaignListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'campaign.list.name'])
            ->add('campaign', \Smile\EzUICampaignBundle\Form\Type\Field\CampaignType::class, ['label' => 'campaign.list.campaign'])
            ->add(
                $builder->create('contact', 'form', array('virtual' => true))
                    ->add('company', TextType::class, ['label' => 'campaign.list.company'])
                    ->add('address', TextType::class, ['label' => 'campaign.list.address'])
                    ->add('city', TextType::class, ['label' => 'campaign.list.city'])
                    ->add('state', TextType::class, ['label' => 'campaign.list.state'])
                    ->add('zip', IntegerType::class, ['label' => 'campaign.list.zip'])
                    ->add('country', CountryType::class, ['label' => 'campaign.list.country'])
            )
            ->add('save', SubmitType::class, ['label' => 'campaign.save']);
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }

    public function getBlockPrefix()
    {
        return 'smilecampaign_list_edit';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => '\Smile\EzUICampaignBundle\Values\CampaignListStruct',
            'translation_domain' => 'smileezuicampaign',
        ]);
    }
}
