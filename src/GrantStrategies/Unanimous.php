<?php
/**
 * @author Maksim Khodyrev<maximkou@gmail.com>
 * 12.05.17
 */

namespace Maximkou\SimpleVoters\GrantStrategies;

use Maximkou\SimpleVoters\Contracts\GrantStrategy;
use Maximkou\SimpleVoters\Contracts\Voter;

/**
 * If least one negative vote - deny access
 * Class Unanimous
 * @package Maximkou\SimpleVoters\GrantStrategies
 */
class Unanimous implements GrantStrategy
{
    use StrategyTrait;

    /**
     * @param $actions
     * @param $object
     * @param $user
     * @return bool
     */
    public function isGranted($actions, $object, $user): bool
    {
        $allowVotesCount = 0;

        foreach ($this->voters as $voter) {
            $vote = $voter->vote($actions, $object, $user);

            if ($vote === Voter::VOTE_ABSTAIN) {
                continue;
            }

            if ($vote === Voter::VOTE_DENY) {
                return false;
            }

            $allowVotesCount++;
        }

        if ($allowVotesCount > 0) {
            return true;
        }

        return $this->isDefaultGranted;
    }
}
