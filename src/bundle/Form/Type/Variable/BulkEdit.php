<?php

namespace ContextualCode\EzPlatformContentVariablesBundle\Form\Type\Variable;

use ContextualCode\EzPlatformContentVariables\Variable\Value\Processor;
use ContextualCode\EzPlatformContentVariablesBundle\Form\Data\VariableValues;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BulkEdit extends AbstractType
{
    /** @var Processor */
    protected $callbackProcessor;

    public function __construct(Processor $callbackProcessor)
    {
        $this->callbackProcessor = $callbackProcessor;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $callbacks = $this->callbackProcessor->getCallbackChoices();

        $builder
            ->add('valueStatic', CollectionType::class, [
                'label' => false,
                'entry_options' => [
                    'label' => false,
                ],
            ]);

        if (count($callbacks) > 0) {
            $builder
                ->add('valueCallback', CollectionType::class, [
                    'entry_type' => ChoiceType::class,
                    'label' => false,
                    'entry_options' => [
                        'label' => false,
                        'choices' => $callbacks,
                    ],
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VariableValues::class,
            'translation_domain' => 'forms',
        ]);
    }
}
