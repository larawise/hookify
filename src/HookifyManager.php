<?php

namespace Larawise\Hookify;

use Illuminate\Contracts\Foundation\Application;

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
class HookifyManager
{
    /**
     * Create a new hookify manager instance.
     *
     * @param Application $app
     *
     * @return void
     */
    public function __construct(
        protected Application $app
    ) { }
}
