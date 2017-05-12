<?php
/**
 * @author Maksim Khodyrev<maximkou@gmail.com>
 * 12.05.17
 */

namespace Maximkou\SimpleVoters\Tests;

use PHPUnit\Framework\TestCase;
use Mockery as m;

/**
 * Class BasicTestCase
 * @package Maximkou\SimpleVoters\Tests
 */
class BasicTestCase extends TestCase
{
    public function tearDown() {
        m::close();
    }
}