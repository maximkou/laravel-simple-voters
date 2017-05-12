<?php
/**
 * @author Maksim Khodyrev<maximkou@gmail.com>
 * 12.05.17
 */

namespace Maximkou\SimpleVoters\GrantStrategies;

use Maximkou\SimpleVoters\Contracts\GrantStrategy;
use Maximkou\SimpleVoters\Contracts\Voter;

/**
 * If least one positive vote - allow access
 * Class Affirmative
 * @package Maximkou\SimpleVoters\GrantStrategies
 */
class Affirmative implements GrantStrategy
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
        $denyVotesCount = 0;

        foreach ($this->voters as $voter) {
            $vote = $voter->vote($actions, $object, $user);

            if ($vote === Voter::VOTE_ABSTAIN) {
                continue;
            }

            if ($vote === Voter::VOTE_ALLOW) {
                return true;
            }

            $denyVotesCount++;
        }

        if ($denyVotesCount > 0) {
            return false;
        }

        return $this->isDefaultGranted;
    }
}
