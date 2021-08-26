<?php
/**
 * Copyright © Lucid Modules. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'LucidModules_CustomerGuard',
    __DIR__
);
