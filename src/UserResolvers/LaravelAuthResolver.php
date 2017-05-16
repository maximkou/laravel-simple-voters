<?php
/**
 * @author Maksim Khodyrev<maximkou@gmail.com>
 * 16.05.17
 */

namespace Maximkou\SimpleVoters\UserResolvers;

use Maximkou\SimpleVoters\Contracts\AuthenticatedUserResolver;
use Illuminate\Auth\AuthManager;

/**
 * Fetch current user using Laravel Auth Manager
 * Class LaravelAuthResolver
 * @package App\UserResolvers
 */
class LaravelAuthResolver implements AuthenticatedUserResolver
{
    private $manager;

    /**
     * LaravelAuthResolver constructor.
     * @param AuthManager $manager
     */
    public function __construct(AuthManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Resolve current authenticated user
     * @return mixed
     */
    public function resolve()
    {
        return $this->manager->user();
    }
}