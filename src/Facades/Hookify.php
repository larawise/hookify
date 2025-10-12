<?php

namespace Larawise\Hookify\Facades;

use Illuminate\Support\Facades\Facade;

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
 *
 * @see \Larawise\Hookify\Hookify
 *
 * @method static \Larawise\Hookify\HookifyBuilder for(string|\BackedEnum $hook, \Larawise\Hookify\HookifyType $type)
 * @method static bool exists(string|\BackedEnum $hook, \Larawise\Hookify\HookifyType $type)
 * @method static array listeners(string|\BackedEnum $hook, \Larawise\Hookify\HookifyType $type)
 * @method static void push(array $definition)
 * @method static void fire(string|\BackedEnum $hook, array $arguments = [])
 * @method static void fireTag(string $tag, array $arguments = [])
 * @method static mixed filter(string $hook, array $arguments = [])
 * @method static mixed filterTag(string $tag, array $arguments = [])
 * @method static void forget(string|\BackedEnum $hook, \Larawise\Hookify\HookifyType $type)
 * @method static void forgetTag(string $tag, \Larawise\Hookify\HookifyType $type)
 * @method static array dump(\Larawise\Hookify\HookifyType $type, string|\BackedEnum|null $hook = null)
 * @method static array dumpTag(string $tag)
 * @method static array snapshot()
 * @method static void restore(array $state)
 * @method static callable|bool resolve(mixed $callback)
 *
 * @see \Larawise\Hookify\Hookify
 */
class Hookify extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'hookify';
    }
}
