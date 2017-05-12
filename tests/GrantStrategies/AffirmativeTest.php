<?php
/**
 * @author Maksim Khodyrev<maximkou@gmail.com>
 * 12.05.17
 */

namespace Maximkou\SimpleVoters\Tests\GrantStrategies;

use Maximkou\SimpleVoters\GrantStrategies\Affirmative;
use Maximkou\SimpleVoters\Tests\BasicTestCase;
use Mockery as m;

/**
 * Class AffirmativeTest
 * @package Maximkou\SimpleVoters\Tests\GrantStrategies
 * @see Affirmative
 */
class AffirmativeTest extends BasicTestCase
{
    use StrategyTrait;

    // least one voter vote "pro"
    public function testHaveOneProVoter()
    {
        $strategy = new Affirmative([
            $this->createVoter([
                'edit' => [
                    'supports' => true,
                    'granted' => true
                ],
                'remove' => [
                    'supports' => true,
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

        self::assertTrue($strategy->isGranted(['edit', 'remove'], null, null));
    }

    // all voters vote "contra"
    public function testHaveNoProVoter()
    {
        $strategy = new Affirmative([
            $this->createVoter([
                'edit' => [
                    'supports' => true,
                    'granted' => false
                ],
                'remove' => [
                    'supports' => true,
                    'granted' => false
                ]
            ]),
            $this->createVoter([
                'edit' => [
                    'supports' => true,
                    'granted' => false
                ],
                'remove' => [
                    'supports' => true,
                    'granted' => false
                ]
            ]),
        ]);

        self::assertFalse($strategy->isGranted(['edit', 'remove'], null, null));
    }

    // all voters abstain
    public function testAbstainAllVoters()
    {
        $strategyDefFalse = new Affirmative([
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

        $strategyDefTrue = new Affirmative([
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