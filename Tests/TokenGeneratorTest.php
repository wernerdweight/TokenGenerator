<?php
declare(strict_types=1);

namespace WernerDweight\TokenGenerator\Tests;

use PHPUnit\Framework\TestCase;
use WernerDweight\TokenGenerator\TokenGenerator;

/**
 * Token generator tests.
 */
class TokenGeneratorTest extends TestCase
{
    /**
     * @var TokenGenerator
     */
    protected $tokenGenerator;

    /**
     * @return TokenGenerator
     */
    protected function getTokenGenerator(): TokenGenerator
    {
        if (null === $this->tokenGenerator) {
            $this->tokenGenerator = new TokenGenerator();
        }
        return $this->tokenGenerator;
    }

    /**
     * Test return type.
     */
    public function testReturnType(): void
    {
        $this->assertInternalType('string', $this->getTokenGenerator()->generate());
    }

    /**
     * Test token generation.
     */
    public function testGenerate(): void
    {
        $this->assertTrue(32 === strlen($this->getTokenGenerator()->generate()));
        $this->assertTrue(32 === strlen($this->getTokenGenerator()->generate(32)));
        $this->assertTrue(1 === strlen($this->getTokenGenerator()->generate(1)));
        $this->assertTrue(256 === strlen($this->getTokenGenerator()->generate(256)));
        $this->assertTrue(0 === strlen($this->getTokenGenerator()->generate(0)));
    }
}
