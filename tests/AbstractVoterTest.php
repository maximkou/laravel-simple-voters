<?php
/**
 * @author Maksim Khodyrev<maximkou@gmail.com>
 * 12.05.17
 */

namespace Maximkou\SimpleVoters\Tests;

use Maximkou\SimpleVoters\AbstractVoter;
use Maximkou\SimpleVoters\Contracts\Voter;
use Mockery as m;

/**
 * Class AbstractVoterTest
 * @package Maximkou\SimpleVoters\Tests
 * @see AbstractVoter
 */
class AbstractVoterTest extends BasicTestCase
{
    // nothing supported voters for this object/action
    public function testNoSupportedVoters()
    {
        $voter = m::mock(
            AbstractVoter::class.'[supports]',
            function (m\MockInterface $mock) {
                $mock->shouldAllowMockingProtectedMethods();

                $mock->shouldReceive('supports')
                    ->andReturn(false);
            }
        );

        // multiple action
        self::assertEquals(Voter::VOTE_ABSTAIN, $voter->vote(['edit'], null, null));
    }

    // if have allowed action in check list
    public function testOneActionIsAllowed()
    {
        $voter = m::mock(
            AbstractVoter::class.'[supports,isGranted]',
            function (m\MockInterface $mock) {
                $mock->shouldAllowMockingProtectedMethods();

                $mock->shouldReceive('supports')
                    ->andReturn(true);
                $mock->shouldReceive('isGranted')
                    ->with('test', null, null)
                    ->andReturn(true);
                $mock->shouldReceive('isGranted')
                    ->with('edit', null, null)
                    ->andReturn(false);
            }
        );

        // multiple action
        self::assertEquals(Voter::VOTE_ALLOW, $voter->vote(['edit', 'test'], null, null));
    }

    // if nothing allowed actions in check list
    public function testAllActionsDenied()
    {
        $voter = m::mock(
            AbstractVoter::class.'[supports,isGranted]',
            function (m\MockInterface $mock) {
                $mock->shouldAllowMockingProtectedMethods();

                $mock->shouldReceive('supports')
                    ->andReturn(true);
                $mock->shouldReceive('isGranted')
                    ->with('test', null, null)
                    ->andReturn(false);
                $mock->shouldReceive('isGranted')
                    ->with('edit', null, null)
                    ->andReturn(false);
            }
        );

        // multiple action
        self::assertEquals(Voter::VOTE_DENY, $voter->vote(['edit', 'test'], null, null));
    }
}
