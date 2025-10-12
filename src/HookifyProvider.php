<?php

namespace Larawise\Hookify;

use Larawise\Packagify\Packagify;
use Larawise\Packagify\PackagifyProvider;

/**
 * Srylius - The ultimate symphony for technology architecture!
 *
 * @package     Larawise
 * @subpackage  Hookify
 * @version     v1.0.0
 * @author      Selçuk Çukur <hk@selcukcukur.com.tr>
 * @copyright   Srylius Teknoloji Limited Şirketi
 *
 * @see https://docs.larawise.com/ Larawise : Docs
 */
class HookifyProvider extends PackagifyProvider
{
    /**
     * Configure the packagify package.
     *
     * @param Packagify $package
     *
     * @return void
     */
    public function configure(Packagify $package)
    {
        // Set the packagify package name.
        $package->name('hookify');

        // Set the packagify package description.
        $package->description('A fluent, taggable, testable hook system for Laravel. Register listeners with clarity, fire actions with precision, and filter data with confidence — all in one elegant package.');

        $package->hasSingletons([
            'hookify' => fn ($app) => new HookifyManager($app),
        ]);
    }
}
