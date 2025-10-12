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
     * Dump the current listeners for a given hook type.
     *
     * @param HookifyType $type
     * @param string|BackedEnum|null $hook
     *
     * @return array
     */
    public function dump(HookifyType $type, $hook = null)
    {
        if ($hook instanceof BackedEnum) {
            $hook = $hook->value;
        }

        return $hook ? ($this->{$type->value}[$hook] ?? []) : $this->{$type->value};
    }

    /**
     * Take a snapshot of the current hook system state.
     *
     * @return array<string, array>
     */
    public function snapshot()
    {
        return [
            'actions' => $this->actions,
            'filters' => $this->filters,
            'tags'    => $this->tags,
        ];
    }

    /**
     * Restore a previously captured hook system state.
     *
     * @param array<string, array> $state
     *
     * @return void
     */
    public function restore($state)
    {
        $this->actions = $state['actions'] ?? [];
        $this->filters = $state['filters'] ?? [];
        $this->tags    = $state['tags'] ?? [];
    }
}
