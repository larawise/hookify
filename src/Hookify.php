<?php

namespace Larawise\Hookify;

use BackedEnum;
use Illuminate\Contracts\Foundation\Application;
use Larawise\Hookify\Contracts\HookifyContract;
use Larawise\Support\Enums\Hook;
use Larawise\Support\Enums\Hooks;

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
     * Register one or more listeners to a hook.
     *
     * @param string|Hooks|array $hooks
     * @param string|array|Closure $callback
     * @param int $priority
     * @param int $arguments
     * @param Hook $type
     * @param string|null $tag
     *
     * @return static
     */
    public function push($hooks, $callback, $priority = 20, $arguments = 1, Hook $type = Hook::ACTION, $tag = null)
    {
        foreach ((array) $hooks as $hook) {
            while (isset($this->{$type->value}[$hook][$priority])) {
                $priority++;
            }

            $this->{$type->value}[$hook][$priority] = compact('callback', 'arguments', 'tag');

            if ($tag) {
                $this->tags[$tag][$type->value][] = $hook;
            }
        }

        return $this;
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
