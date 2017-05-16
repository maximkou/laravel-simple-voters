<?php
/**
 * @author Maksim Khodyrev<maximkou@gmail.com>
 * 16.05.17
 */

namespace Maximkou\SimpleVoters\Contracts;

/**
 * Interface AuthenticatedUserResolver
 * @package Maximkou\SimpleVoters\Contracts
 */
interface AuthenticatedUserResolver
{
    /**
     * Resolve current authenticated user
     * @return mixed
     */
    public function resolve();
}