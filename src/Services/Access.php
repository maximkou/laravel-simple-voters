<?php
/**
 * @author Maksim Khodyrev<maximkou@gmail.com>
 * 12.05.17
 */

namespace Maximkou\SimpleVoters\Services;

use Illuminate\Support\Facades\Auth;
use Maximkou\SimpleVoters\Contracts\AuthenticatedUserResolver;
use Maximkou\SimpleVoters\Contracts\GrantStrategy;

/**
 * Service help checking access
 * Class Access
 * @package Maximkou\SimpleVoters\Services
 */
class Access
{
    /**
     * @var GrantStrategy
     */
    private $strategy;

    /**
     * @var AuthenticatedUserResolver
     */
    private $userResolver;

    /**
     * Access constructor.
     * @param GrantStrategy $strategy
     * @param AuthenticatedUserResolver $userResolver
     */
    public function __construct(GrantStrategy $strategy, AuthenticatedUserResolver $userResolver)
    {
        $this->strategy = $strategy;
        $this->userResolver = $userResolver;
    }

    /**
     * @param $actions
     * @param null $object
     * @param null $user
     * @return bool
     */
    public function isGranted($actions, $object = null, $user = null) : bool
    {
        if (null === $user) {
            $user = $this->userResolver->resolve();
        }

        return $this->strategy->isGranted($actions, $object, $user);
    }
}
