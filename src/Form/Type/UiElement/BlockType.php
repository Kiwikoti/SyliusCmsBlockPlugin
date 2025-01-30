<?php

/*
 * This file is part of Monsieur Biz's Sylius Cms Block Plugin for Sylius.
 * (c) Monsieur Biz <sylius@monsieurbiz.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MonsieurBiz\SyliusCmsBlockPlugin\Form\Type\UiElement;

use MonsieurBiz\SyliusCmsBlockPlugin\Entity\Block;
use MonsieurBiz\SyliusCmsBlockPlugin\Entity\BlockInterface;
use MonsieurBiz\SyliusCmsBlockPlugin\Repository\BlockRepository;
use MonsieurBiz\SyliusCmsBlockPlugin\Repository\BlockRepositoryInterface;
use Sylius\Bundle\ResourceBundle\Form\DataTransformer\ResourceToIdentifierTransformer;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Resource\Translation\Provider\TranslationLocaleProviderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\ReversedTransformer;
use Symfony\Component\Validator\Constraints as Assert;

final class BlockType extends AbstractType
{
    public function __construct(
        private BlockRepositoryInterface $blockRepository,
        private LocaleContextInterface $localeContext,
        private TranslationLocaleProviderInterface $translationLocaleProvider,
    ) {
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('block', EntityType::class, [
                'label' => 'monsieurbiz_cms_block.ui.block',
                'required' => true,
                'getter' => function (array $data) {
                    // Retrieve the entity with our repository to avoid 500 if we try to load a deleted one
                    // In this case it will return null if not found with the given code instead of an exception.
                    return $this->blockRepository->find($data['block']);
                },
                'class' => Block::class,
                'multiple' => false,
                'choice_label' => fn (BlockInterface $block): string => \sprintf('[%s] %s', $block->getCode(), $block->getName()),
                'query_builder' => function (BlockRepository $blockRepository) {
                    return $blockRepository->createListQueryBuilder($this->localeContext->getLocaleCode(), $this->translationLocaleProvider->getDefaultLocaleCode())
                        ->addOrderBy('o.code', 'ASC')
                    ;
                },
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
        ;

        $reversedTransformer = new ReversedTransformer(new ResourceToIdentifierTransformer($this->blockRepository, 'code'));
        $builder->get('block')->addModelTransformer($reversedTransformer);
    }
}
