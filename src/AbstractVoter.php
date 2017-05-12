<?php
/**
 * @author Maksim Khodyrev<maximkou@gmail.com>
 * 12.05.17
 */

namespace Maximkou\SimpleVoters;

use Maximkou\SimpleVoters\Contracts\Voter;

/**
 * Class AbstractVoter
 * @package Maximkou\SimpleVoters
 */
abstract class AbstractVoter implements Voter
{
    /**
     * @inheritdoc
     */
    public function vote($actions, $object, $user) : int
    {
        $actions = array_filter((array)$actions, function ($action) use ($object) {
            return $this->supports($object, $action);
        });

        if (empty($actions)) {
            // if nothing supported actions, abstain
            return self::VOTE_ABSTAIN;
        }

        foreach ($actions as $action) {
            // grant access, if at least one positive vote
            if ($this->isGranted($action, $object, $user)) {
                return self::VOTE_ALLOW;
            }
        }

        // deny access by default
        return self::VOTE_DENY;
    }

    /**
     * Check this voter is applicable to object
     * @param $object
     * @param $action
     * @return bool
     */
    abstract protected function supports($action, $object) : bool;

    /**
     * Check access to single action
     * @param $action
     * @param $object
     * @param $user
     * @return bool
     */
    abstract protected function isGranted($action, $object, $user) : bool;
}
