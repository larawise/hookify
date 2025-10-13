<?php

namespace Larawise\Hookify;

use Closure;
use Larawise\Hookify\Contracts\BuilderContract;
use Larawise\Hookify\Exceptions\HookifyException;

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
class HookifyBuilder implements BuilderContract
{
    /**
     * The name of the hook this listener will be registered under.
     *
     * @var string
     */
    protected $hook;

    /**
     * The type of the hook: action or filter.
     *
     * @var HookifyType
     */
    protected $type;

    /**
     * The execution priority of the listener.
     *
     * @var int
     */
    protected $priority = 10;

    /**
     * Number of arguments expected by the callback.
     *
     * @var int
     */
    protected $arguments = 1;

    /**
     * Optional tag used to group listeners for bulk operations.
     *
     * @var string|null
     */
    protected $tag = null;

    /**
     * The callback to be executed when the hook is fired.
     *
     * @var Closure|string|array
     */
    protected $callback;

    /**
     * Create a new hookify builder instance.
     *
     * @param Hookify $hookify
     *
     * @return void
     */
    public function __construct(
        protected Hookify $hookify,
    ) {}

    /**
     * Set the hook name this listener will be registered under.
     *
     * @param string $hook
     *
     * @return $this
     */
    public function hook($hook)
    {
        if (empty($this->hook)) {
            throw new HookifyException('Hook name cannot be empty.');
        }

        $this->hook = $hook;

        return $this;
    }

    /**
     * Set the type of the hook: action or filter.
     *
     * @param string $type
     *
     * @return $this
     */
    public function type($type)
    {
        if (! in_array($this->type, [HookifyType::ACTION->value, HookifyType::FILTER->value], true)) {
            throw new HookifyException("Invalid hook type: {$this->type}");
        }

        $this->type = $type;

        return $this;
    }

    /**
     * Set the execution priority for the listener.
     *
     * @param int $priority
     *
     * @return $this
     */
    public function priority($priority)
    {
        if (! is_int($this->priority) || $this->priority < 0) {
            throw new HookifyException('Priority must be a non-negative integer.');
        }

        $this->priority = $priority;

        return $this;
    }

    /**
     * Set the number of arguments the listener expects.
     *
     * @param int $arguments
     *
     * @return $this
     */
    public function arguments($arguments)
    {
        if (! is_int($this->arguments) || $this->arguments < 0) {
            throw new HookifyException('Arguments must be a non-negative integer.');
        }

        $this->arguments = $arguments;

        return $this;
    }

    /**
     * Assign a tag to the listener for grouping and bulk operations.
     *
     * @param string $tag
     *
     * @return $this
     */
    public function tag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Set the callback for the hook.
     *
     * @param Closure|string|array $callback
     *
     * @return $this
     */
    public function callback($callback)
    {
        if (! is_callable($this->callback) && ! is_string($this->callback) && ! is_array($this->callback)) {
            throw new HookifyException('Callback must be a Closure, string, or array.');
        }

        $this->callback = $callback;

        return $this;
    }

    /**
     * Finalize and register the hook.
     *
     * @return void
     */
    public function push()
    {
        $this->hookify->push($this->toArray());
    }

    /**
     * Get the instance as an array.
     *
     * @return array<string, mixed>
     */
    public function toArray()
    {
        return [
            'hook' => $this->hook,
            'type' => $this->type,
            'priority' => $this->priority,
            'arguments' => $this->arguments,
            'tag' => $this->tag,
            'callback' => $this->callback,
        ];
    }
}
