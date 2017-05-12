<?php
/**
 * @author Maksim Khodyrev<maximkou@gmail.com>
 * 12.05.17
 */

namespace Maximkou\SimpleVoters\Contracts;

/**
 * Interface GrantStrategy
 * @package Maximkou\SimpleVoters\Contracts
 */
interface GrantStrategy
{
    /**
     * @param $actions
     * @param $object
     * @param $user
     * @return bool
     */
    public function isGranted($actions, $object, $user) : bool;
}
