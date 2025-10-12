<?php

namespace Larawise\Hookify;

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
enum HookifyType: string
{
    /**
     * Executes listeners for side effects.
     */
    case ACTION = 'action';

    /**
     * Executes listeners to transform data.
     */
    case FILTER = 'filter';
}
