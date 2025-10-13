<?php

namespace Larawise\Hookify;

use BackedEnum;
use Closure;
use Illuminate\Contracts\Foundation\Application;
use Larawise\Hookify\Contracts\HookifyContract;
use Larawise\Hookify\Exceptions\HookifyException;
use Throwable;

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
     * @param string|HookifyType $type
     *
     * @return HookifyBuilder
     */
    public function for($hook, $type)
    {
        $builder = new HookifyBuilder($this);

        return $builder
            ->hook($this->normalizeHook($hook))
            ->type($type->value);
    }

    /**
     * Check if any listeners exist for a given hook.
     *
     * @param string|BackedEnum $hook
     * @param string|HookifyType $type
     *
     * @return bool
     */
    public function exists($hook, $type)
    {
        $name = $this->normalizeHook($hook);
        $type = $this->normalizeType($type);

        return ! empty($this->{$type}[$name]);
    }

    /**
     * Get all listeners registered for a given hook.
     *
     * @param string|BackedEnum $hook
     * @param string|HookifyType $type
     *
     * @return array
     */
    public function listeners($hook, $type)
    {
        return $this->dump($type, $this->normalizeHook($hook));
    }

    /**
     * Register a listener definition.
     *
     * @param array<string, mixed> $definition
     *
     * @return void
     */
    public function push($definition)
    {
        $type = $definition['type'];
        $hook = $definition['hook'];
        $priority = $definition['priority'];

        while (isset($this->{$type}[$hook][$priority])) {
            $priority++;
        }

        $this->{$type}[$hook][$priority] = [
            'callback'  => $definition['callback'],
            'arguments' => $definition['arguments'],
            'tag'       => $definition['tag'],
        ];

        if (! empty($definition['tag'])) {
            $tag = $definition['tag'];

            if (! in_array($hook, $this->tags[$tag][$type] ?? [], true)) {
                $this->tags[$tag][$type][] = $hook;
            }
        }
    }

    /**
     * Fire all action listeners for a given hook.
     *
     * @param string|BackedEnum $hook
     * @param array $arguments
     *
     * @return void
     */
    public function fire($hook, $arguments = [])
    {
        $listeners = $this->actions[$hook] ?? [];
        krsort($listeners, SORT_NUMERIC);

        foreach ($listeners as $listener) {
            $parameters = array_slice($arguments, 0, $listener['arguments']);
            $resolved = $this->resolve($listener['callback']);

            if (! is_callable($resolved)) {
                report(new HookifyException("Invalid callback for hook [$hook]"));
                continue;
            }

            try {
                call_user_func_array($resolved, $parameters);
            } catch (Throwable $exception) {
                report($exception);
            }
        }
    }

    /**
     * Fire all action listeners associated with a given tag.
     *
     * @param string $tag
     * @param array $arguments
     *
     * @return void
     */
    public function fireTag($tag, $arguments = [])
    {
        $hooks = $this->tags[$tag][HookifyType::ACTION->value] ?? [];

        array_map(fn ($hook) => $this->fire($hook, $arguments), $hooks);
    }

    /**
     * Apply all filter listeners to a given hook.
     *
     * @param string $hook
     * @param array $arguments
     *
     * @return mixed
     */
    public function filter($hook, $arguments = [])
    {
        $value = $arguments[0] ?? null;
        $listeners = $this->filters[$hook] ?? [];
        ksort($listeners, SORT_NUMERIC);

        foreach ($listeners as $listener) {
            $params = [$value];
            for ($i = 1; $i < $listener['arguments']; $i++) {
                if (isset($arguments[$i])) {
                    $params[] = $arguments[$i];
                }
            }

            $resolved = $this->resolve($listener['callback']);

            if (! is_callable($resolved)) {
                report(new HookifyException("Invalid callback for hook [$hook]"));
                continue;
            }

            try {
                $value = call_user_func_array($resolved, $params);
            } catch (Throwable $exception) {
                report($exception);
            }
        }

        return $value;
    }

    /**
     * Apply all filter listeners associated with a given tag.
     *
     * @param string $tag
     * @param array $arguments
     *
     * @return mixed
     */
    public function filterTag($tag, $arguments = [])
    {
        $hooks = $this->tags[$tag][HookifyType::FILTER->value] ?? [];
        $value = $arguments[0] ?? null;

        return array_reduce($hooks, function ($carry, $hook) use (&$arguments) {
            $arguments[0] = $carry;
            return $this->filter($hook, $arguments);
        }, $value);
    }

    /**
     * Remove all listeners for a specific hook.
     *
     * @param string|BackedEnum $hook
     * @param string|HookifyType $type
     *
     * @return void
     */
    public function forget($hook, $type)
    {
        $name = $this->normalizeHook($hook);

        unset($this->{$type->value}[$name]);
    }

    /**
     * Remove all listeners associated with a specific tag.
     *
     * @param string $tag
     * @param string|HookifyType $type
     *
     * @return void
     */
    public function forgetTag($tag, $type)
    {
        $type = $this->normalizeType($type);
        $hooks = $this->tags[$tag][$type] ?? [];

        foreach ($hooks as $hook) {
            unset($this->{$type}[$hook]);
        }

        unset($this->tags[$tag][$type]);
    }

    /**
     * Dump the current listeners for a given hook type.
     *
     * @param string|HookifyType $type
     * @param string|BackedEnum|null $hook
     *
     * @return array
     */
    public function dump($type, $hook = null)
    {
        $name = $this->normalizeHook($hook);
        $type = $this->normalizeType($type);

        return $name ? ($this->{$type}[$name] ?? []) : $this->{$type};
    }

    /**
     * Dump all hooks registered under a given tag.
     *
     * @param string $tag
     *
     * @return array<string, array<string>>
     */
    public function dumpTag($tag)
    {
        return $this->tags[$tag] ?? [];
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
            'tags' => $this->tags,
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
        $this->tags = $state['tags'] ?? [];
    }

    /**
     * Resolve a given callback into a valid callable.
     *
     * @param mixed $callback
     *
     * @return callable|bool
     */
    public function resolve($callback)
    {
        // Laravel-style "Class@method"
        if (is_string($callback) && str_contains($callback, '@')) {
            [$class, $method] = explode('@', $callback);

            if (! class_exists($class) || ! method_exists($class, $method)) {
                return null;
            }

            try {
                $instance = $this->app->make($class);
                return [$instance, $method];
            } catch (Throwable $exception) {
                return null;
            }
        }

        // Invokable class name
        if (is_string($callback) && class_exists($callback)) {
            $instance = $this->app->make($callback);
            return method_exists($instance, '__invoke') ? $instance : false;
        }

        // Global function
        if (is_string($callback) && function_exists($callback)) {
            return $callback;
        }

        // Static method array
        if (is_array($callback) && is_string($callback[0]) && method_exists($callback[0], $callback[1])) {
            return $callback;
        }

        // Invokable object
        if (is_object($callback) && method_exists($callback, '__invoke')) {
            return $callback;
        }

        // Closure or callable
        if ($callback instanceof Closure || is_callable($callback)) {
            return $callback;
        }

        return false;
    }

    /**
     * Normalize a hook name to its string representation.
     *
     * @param string|BackedEnum $hook
     *
     * @return string
     */
    protected function normalizeHook($hook)
    {
        return $hook instanceof BackedEnum ? $hook->value : $hook;
    }

    /**
     * Normalize a type value to its string representation.
     *
     * @param HookifyType $type
     *
     * @return string
     */
    protected function normalizeType($type)
    {
        return $type->value;
    }
}
