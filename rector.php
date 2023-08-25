<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\Node\RemoveNonExistingVarAnnotationRector;
use Rector\Php70\Rector\StaticCall\StaticCallOnNonStaticToInstanceCallRector;
use Rector\Php80\Rector\FuncCall\ClassOnObjectRector;
use Rector\Php81\Rector\Array_\FirstClassCallableRector;
use Rector\Php81\Rector\MethodCall\SpatieEnumMethodCallToEnumConstRector;
use Rector\Php82\Rector\Class_\ReadOnlyClassRector;
use Rector\Privatization\Rector\Class_\ChangeReadOnlyVariableWithDefaultValueToConstantRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use RectorLaravel\Set\LaravelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__.'/app',
        __DIR__.'/config',
        /**
         * @todo Try to uncomment and see if it still gets stuck in infinite loop (since 0.15.10)
         */
        // __DIR__ . "/database",
        __DIR__.'/lang',
        __DIR__.'/resources/views',
        __DIR__.'/routes',
        __DIR__.'/tests',
    ]);

    $rectorConfig->skip([
        ClassOnObjectRector::class,
        StaticCallOnNonStaticToInstanceCallRector::class,
        FirstClassCallableRector::class,
        RemoveNonExistingVarAnnotationRector::class,
        RemoveLastReturnRector::class,
        ChangeReadOnlyVariableWithDefaultValueToConstantRector::class,

        __DIR__.'/database/migrations/*',
        ReadOnlyClassRector::class => [
            __DIR__.'/app/Events', // Because Laravel trait "InteractsWithSockets" have non read only property.
            __DIR__.'/app/Jobs', // Because Laravel trait "InteractsWithQueue" have non read only property.
        ],
        SpatieEnumMethodCallToEnumConstRector::class,
    ]);

    // define sets of rules
    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_82,
        SetList::DEAD_CODE,
        //SetList::PRIVATIZATION,
        SetList::EARLY_RETURN,
        SetList::TYPE_DECLARATION,
        LaravelSetList::LARAVEL_90,
        LaravelSetList::LARAVEL_CODE_QUALITY,
        LaravelSetList::LARAVEL_LEGACY_FACTORIES_TO_CLASSES,
    ]);
};
