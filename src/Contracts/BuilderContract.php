<?php

namespace Larawise\Hookify\Contracts;

use Illuminate\Contracts\Support\Arrayable;

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
interface BuilderContract extends Arrayable
{
    /**
     * Set the execution priority for the listener.
     *
     * @param int $priority
     *
     * @return $this
     */
    public function priority(int $priority);

    /**
     * Set the number of arguments the listener expects.
     *
     * @param int $arguments
     *
     * @return $this
     */
    public function arguments(int $arguments);

    /**
     * Assign a tag to the listener for grouping and bulk operations.
     *
     * @param string $tag
     *
     * @return $this
     */
    public function tag(string $tag);

    /**
     * Finalize the listener registration by providing the callback.
     *
     * @param Closure|string|array $callback
     *
     * @return $this
     */
    public function callback($callback);
}
