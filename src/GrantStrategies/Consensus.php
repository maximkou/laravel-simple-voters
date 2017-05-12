<?php
/**
 * @author Maksim Khodyrev<maximkou@gmail.com>
 * 12.05.17
 */

namespace Maximkou\SimpleVoters\GrantStrategies;

use Maximkou\SimpleVoters\Contracts\GrantStrategy;
use Maximkou\SimpleVoters\Contracts\Voter;

/**
 * Allow, if positive votes more, than negative
 * Class Consensus
 * @package Maximkou\SimpleVoters\GrantStrategies
 */
class Consensus implements GrantStrategy
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
        $votes = [
            Voter::VOTE_ABSTAIN => 0,
            Voter::VOTE_ALLOW => 0,
            Voter::VOTE_DENY => 0
        ];

        foreach ($this->voters as $voter) {
            $vote = $voter->vote($actions, $object, $user);
            $votes[$vote]++;
        }

        if ($votes[Voter::VOTE_ALLOW] > $votes[Voter::VOTE_DENY]) {
            return true;
        }

        if ($votes[Voter::VOTE_ALLOW] < $votes[Voter::VOTE_DENY]) {
            return false;
        }

        return $this->isDefaultGranted;
    }
}
