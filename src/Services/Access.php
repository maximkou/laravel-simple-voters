<?php
/**
 * @author Maksim Khodyrev<maximkou@gmail.com>
 * 12.05.17
 */

namespace Maximkou\SimpleVoters\Services;

use Illuminate\Support\Facades\Auth;
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
     * Access constructor.
     * @param GrantStrategy $strategy
     */
    public function __construct(GrantStrategy $strategy)
    {
        $this->strategy = $strategy;
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
            $user = Auth::user();
        }

        return $this->strategy->isGranted($actions, $object, $user);
    }
}