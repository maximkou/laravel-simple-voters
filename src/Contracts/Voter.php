<?php
/**
 * @author Maksim Khodyrev<maximkou@gmail.com>
 * 12.05.17
 */

namespace Maximkou\SimpleVoters\Contracts;

interface Voter
{
    const VOTE_ALLOW = 1;
    const VOTE_DENY = 2;
    const VOTE_ABSTAIN = 3;

    /**
     * Vote for actions
     * @param array|string $actions
     * @param object $object
     * @param object $user
     * @return int
     */
    public function vote($actions, $object, $user) : int;
}
