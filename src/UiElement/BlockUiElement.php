<?php

/*
 * This file is part of Monsieur Biz's Sylius Cms Block Plugin for Sylius.
 * (c) Monsieur Biz <sylius@monsieurbiz.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MonsieurBiz\SyliusCmsBlockPlugin\UiElement;

use Doctrine\ORM\NonUniqueResultException;
use MonsieurBiz\SyliusCmsBlockPlugin\Entity\BlockInterface;
use MonsieurBiz\SyliusCmsBlockPlugin\Repository\BlockRepositoryInterface;
use MonsieurBiz\SyliusRichEditorPlugin\UiElement\UiElementInterface;
use MonsieurBiz\SyliusRichEditorPlugin\UiElement\UiElementTrait;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Resource\Translation\Provider\TranslationLocaleProviderInterface;

final class BlockUiElement implements UiElementInterface
{
    use UiElementTrait;

    public function __construct(
        private BlockRepositoryInterface $blockRepository,
        private LocaleContextInterface $localeContext,
        private TranslationLocaleProviderInterface $translationLocaleProvider,
    ) {
    }

    public function getBlock(string $identifier): ?BlockInterface
    {
        try {
            return $this->blockRepository->findOneEnabledByIdentifier(
                $identifier,
                $this->localeContext->getLocaleCode(),
                $this->translationLocaleProvider->getDefaultLocaleCode()
            );
        } catch (NonUniqueResultException) {
            return null;
        }
    }
}
