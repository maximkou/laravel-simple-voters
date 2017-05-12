<?php
/**
 * @author Maksim Khodyrev<maximkou@gmail.com>
 * 12.05.17
 */

namespace Maximkou\SimpleVoters\Tests\GrantStrategies;

use Maximkou\SimpleVoters\GrantStrategies\Unanimous;
use Maximkou\SimpleVoters\Tests\BasicTestCase;
use Mockery as m;

/**
 * Class UnanimousTest
 * @package Maximkou\SimpleVoters\Tests\GrantStrategies
 * @see Unanimous
 */
class UnanimousTest extends BasicTestCase
{
    use StrategyTrait;

    // least one voter vote "contra"
    public function testHaveOneContraVoter()
    {
        $strategy = new Unanimous([
            $this->createVoter([
                'edit' => [
                    'supports' => true,
                    'granted' => true
                ],
                'remove' => [
                    'supports' => true,
                    'granted' => true
                ]
            ]),
            $this->createVoter([
                'edit' => [
                    'supports' => true,
                    'granted' => true
                ],
                'remove' => [
                    'supports' => false,
                    'granted' => false
                ]
            ]),
            $this->createVoter([
                'edit' => [
                    'supports' => true,
                    'granted' => false
                ],
                'remove' => [
                    'supports' => false,
                    'granted' => false
                ]
            ]),
        ]);

        self::assertFalse($strategy->isGranted(['edit', 'remove'], null, null));
    }

    // all voters vote "pro"
    public function testHaveOnlyProVoters()
    {
        $strategy = new Unanimous([
            $this->createVoter([
                'edit' => [
                    'supports' => true,
                    'granted' => true
                ],
                'remove' => [
                    'supports' => true,
                    'granted' => true
                ]
            ]),
            $this->createVoter([
                'edit' => [
                    'supports' => false,
                    'granted' => false
                ],
                'remove' => [
                    'supports' => true,
                    'granted' => true
                ]
            ]),
        ]);

        self::assertTrue($strategy->isGranted(['edit', 'remove'], null, null));
    }

    // all voters abstain
    public function testAbstainAllVoters()
    {
        $strategyDefFalse = new Unanimous([
            $this->createVoter([
                'edit' => [
                    'supports' => false,
                    'granted' => false
                ],
            ]),
            $this->createVoter([
                'edit' => [
                    'supports' => false,
                    'granted' => false
                ],
            ]),
        ], false);

        $strategyDefTrue = new Unanimous([
            $this->createVoter([
                'edit' => [
                    'supports' => false,
                    'granted' => false
                ],
            ]),
            $this->createVoter([
                'edit' => [
                    'supports' => false,
                    'granted' => false
                ],
            ]),
        ], true);

        self::assertFalse($strategyDefFalse->isGranted('edit', null, null));
        self::assertTrue($strategyDefTrue->isGranted('edit', null, null));
    }
}