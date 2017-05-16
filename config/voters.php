<?php
/**
 * @author Maksim Khodyrev<maximkou@gmail.com>
 * 12.05.17
 */
return [
    /**
     * Available out of the box strategies: affirmative, unanimous, consensus.
     * You can use custom voting strategy by registering service with name 'simple_voters.strategies.{strategy_name}'
     */
    'strategy' => 'unanimous',

    /**
     * If pro and contra votes count is equal, or all voters abstain, used this value
     */
    'is_granted_by_default' => true,

    /**
     * Class for resolve current authenticated user, by default, using Laravel Auth Manager
     */
    'user_resolver' => 'Maximkou\SimpleVoters\UserResolvers\LaravelAuthResolver',

    /**
     * List of Voter classes
     */
    'voters' => [],
];
