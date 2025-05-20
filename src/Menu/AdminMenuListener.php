<?php

/*
 * This file is part of Monsieur Biz's Sylius Cms Block Plugin for Sylius.
 * (c) Monsieur Biz <sylius@monsieurbiz.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MonsieurBiz\SyliusCmsBlockPlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: 'sylius.menu.admin.main')]
final class AdminMenuListener
{
    public function __invoke(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        if (!$content = $menu->getChild('monsieurbiz-cms')) {
            $content = $menu
                ->addChild('monsieurbiz-cms')
                ->setLabel('monsieurbiz_cms_block.ui.cms_content')
                ->setLabelAttribute('icon', 'tabler:file')
                ->setExtra('always_open', true)
            ;
        }

        $content
            ->addChild('monsieurbiz-cms-block', ['route' => 'monsieurbiz_cms_block_admin_block_index', 'extras' => ['routes' => [
                'monsieurbiz_cms_block_admin_block_create',
                'monsieurbiz_cms_block_admin_block_update',
            ]]])
            ->setLabel('monsieurbiz_cms_block.ui.blocks')
            ->setLabelAttribute('icon', 'tabler:blocks')
        ;
    }
}
