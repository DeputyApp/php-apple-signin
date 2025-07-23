<?php

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;

return RectorConfig::configure()
    ->withPaths([__DIR__ . '/../src', __DIR__ . '/../tests'])
    ->withSets([SetList::PHP_80, SetList::PHP_81, SetList::PHP_82, SetList::PHP_83, SetList::PHP_84])
    ->withSkip([
        //\Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector::class
    ]);
