<?php
declare(strict_types=1);

namespace WernerDweight\TokenGenerator;

/**
 * Simple random token generator.
 */
class TokenGenerator
{
    /**
     * @var string
     */
    private const ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_-';

    /**
     * @var int
     */
    private const DEFAULT_TOKEN_LENGTH = 32;

    /**
     * @var string
     */
    private $alphabet;

    public function __construct(string $alphabet = self::ALPHABET)
    {
        $this->alphabet = $alphabet;
    }

    public function generate(int $length = self::DEFAULT_TOKEN_LENGTH): string
    {
        $token = '';

        $alphabetLength = strlen($this->alphabet);
        for ($index = 0; $index < $length; $index++) {
            $token .= $this->alphabet[$this->getRandomNumberFromRange(0, $alphabetLength)];
        }

        return $token;
    }

    private function getRandomNumberFromRange(int $min, int $max): int
    {
        $range = $max - $min;

        // not so random, just for sure
        if ($range < 0) {
            return $min;
        }

        $log = log($range, 2);
        // length in bytes
        $bytes = (int)($log / 8) + 1;
        // length in bits
        $bits = (int)$log + 1;
        // set all lower bits to 1
        $filter = (1 << $bits) - 1;

        do {
            $randomBytes = (string)openssl_random_pseudo_bytes($bytes);
            $randomHexBytes = bin2hex($randomBytes);
            $rnd = hexdec($randomHexBytes);
            // discard irrelevant bits
            $rnd = $rnd & $filter;
        } while ($rnd >= $range);

        return $min + $rnd;
    }
}
