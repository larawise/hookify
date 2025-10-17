<?php

use Larawise\Hookify\Facades\Hookify;
use Larawise\Hookify\HookifyType;

if (! function_exists('push_action')) {
    /**
     * Push an action hook.
     *
     * @param string|BackedEnum $hook
     * @param string|array|Closure $callback
     * @param int $priority
     * @param int $arguments
     *
     * @return void
     */
    function push_action($hook, $callback, int $priority = 20, int $arguments = 1): void
    {
        Hookify::for($hook, HookifyType::ACTION)
            ->priority($priority)
            ->arguments($arguments)
            ->callback($callback);
    }
}

if (! function_exists('push_filter')) {
    /**
     * Push a filter hook.
     *
     * @param string|BackedEnum $hook
     * @param string|array|Closure $callback
     * @param int $priority
     * @param int $arguments
     *
     * @return void
     */
    function push_filter($hook, $callback, int $priority = 20, int $arguments = 1): void
    {
        Hookify::for($hook, HookifyType::FILTER)
            ->priority($priority)
            ->arguments($arguments)
            ->callback($callback);
    }
}

if (! function_exists('forget_action')) {
    /**
     * Forget an action hook.
     *
     * @param string|BackedEnum $hook The name of the action hook.
     *
     * @return void
     */
    function forget_action(string|BackedEnum $hook): void
    {
        Hookify::forget($hook, HookifyType::ACTION);
    }
}

if (! function_exists('forget_filter')) {
    /**
     * Forget a filter hook.
     *
     * @param string|BackedEnum $hook
     *
     * @return void
     */
    function forget_filter(string|BackedEnum $hook): void
    {
        Hookify::forget($hook, HookifyType::FILTER);
    }
}

if (! function_exists('do_action')) {
    /**
     * Execute all callbacks for an action hook.
     *
     * @param mixed ...$args The hook name followed by parameters.
     *
     * @return void
     */
    function do_action(...$args): void
    {
        Hookify::fire(array_shift($args), $args);
    }
}

if (! function_exists('apply_filters')) {
    /**
     * Apply all filters to a value.
     *
     * @param mixed ...$args The hook name followed by the value and parameters.
     *
     * @return mixed The filtered value.
     */
    function apply_filters(...$args): mixed
    {
        return Hookify::filter(array_shift($args), $args);
    }
}
