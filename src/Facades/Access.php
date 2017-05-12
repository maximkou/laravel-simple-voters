<?php
/**
 * @author Maksim Khodyrev<maximkou@gmail.com>
 * 12.05.17
 */

namespace Maximkou\SimpleVoters\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Access
 * @package Maximkou\SimpleVoters\Facades
 */
class Access extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'simple_voters.checker';
    }
}
