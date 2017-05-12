<?php
/**
 * @author Maksim Khodyrev<maximkou@gmail.com>
 * 12.05.17
 */

namespace Maximkou\SimpleVoters\GrantStrategies;

use Maximkou\SimpleVoters\Contracts\Voter;

/**
 * Class StrategyTrait
 * @package Maximkou\SimpleVoters\GrantStrategies
 */
trait StrategyTrait
{
    /**
     * @var Voter[]
     */
    private $voters;

    /**
     * If all voters abstain or no voters
     * @var bool
     */
    private $isDefaultGranted;

    /**
     * StrategyTrait constructor.
     * @param array $voters
     * @param bool $isDefaultGranted
     */
    public function __construct(array $voters, $isDefaultGranted = true)
    {
        $this->voters = $voters;
        $this->isDefaultGranted = $isDefaultGranted;
    }
}
