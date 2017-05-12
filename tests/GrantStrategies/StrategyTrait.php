<?php
/**
 * @author Maksim Khodyrev<maximkou@gmail.com>
 * 12.05.17
 */

namespace Maximkou\SimpleVoters\Tests\GrantStrategies;

use Maximkou\SimpleVoters\AbstractVoter;
use Mockery as m;

trait StrategyTrait
{
    private function createVoter(array $options)
    {
        return m::mock(
            AbstractVoter::class.'[supports,isGranted]',
            function (m\MockInterface $mock) use ($options) {
                $mock->shouldAllowMockingProtectedMethods();

                foreach ($options as $action => $settings) {
                    $mock->shouldReceive('supports')
                        ->with(null, $action)
                        ->andReturn($settings['supports']);
                    $mock->shouldReceive('isGranted')
                        ->with($action, null, null)
                        ->andReturn($settings['granted']);
                }
            }
        );
    }
}