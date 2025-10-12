<?php

namespace Larawise\Hookify;

use Closure;
use Larawise\Hookify\Contracts\BuilderContract;

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
    public function hook(string $hook)
    {
        $this->hook = $hook;

        return $this;
    }

    /**
     * Set the type of the hook: action or filter.
     *
     * @param HookifyType $type
     *
     * @return $this
     */
    public function type(HookifyType $type)
    {
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
    public function priority(int $priority)
    {
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
    public function arguments(int $arguments)
    {
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
    public function tag(string $tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Finalize the listener registration by providing the callback.
     *
     * @param Closure|string|array $callback
     *
     * @return $this
     */
    public function callback($callback)
    {
        $this->callback = $callback;

        $this->hookify->push($this->toArray());

        return $this;
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
