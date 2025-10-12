<?php

namespace Larawise\Hookify;

use BackedEnum;
use Illuminate\Contracts\Foundation\Application;
use Larawise\Hookify\Contracts\HookifyContract;

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
class Hookify implements HookifyContract
{
    /**
     * Registered action listeners.
     *
     * @var array<string, array>
     */
    protected $actions = [];

    /**
     * Registered filter listeners.
     *
     * @var array<string, array>
     */
    protected $filters = [];

    /**
     * Tag-based listener grouping.
     *
     * @var array<string, array>
     */
    protected $tags = [];

    /**
     * Create a new hookify instance.
     *
     * @param Application $app
     *
     * @return void
     */
    public function __construct(
        protected Application $app,
    ) { }

    /**
     * Begin a new hook listener definition.
     *
     * @param string|BackedEnum $hook
     * @param HookifyType $type
     *
     * @return HookifyBuilder
     */
    public function for($hook, HookifyType $type)
    {
        $builder = new HookifyBuilder($this);

        return $builder
            ->hook($hook instanceof BackedEnum ? $hook->value : $hook)
            ->type($type->value);
    }


    /**
     * Start a new hook listener definition using fluent builder syntax.
     *
     * @return HookifyBuilder
     */
    public function builder(): HookifyBuilder
    {
        return new HookifyBuilder($this);
    }


}
