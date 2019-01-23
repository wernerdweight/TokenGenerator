<?php
declare(strict_types=1);

namespace WernerDweight\TokenGenerator;

/**
 * Simple random token generator.
 */
class TokenGenerator
{
    /** @var string */
    private const ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_-';
    /** @var int */
    private const DEFAULT_TOKEN_LENGTH = 32;

    /** @var string */
    private $alphabet;

    /**
     * TokenGenerator constructor.
     * @param string $alphabet
     */
    public function __construct(string $alphabet = self::ALPHABET)
    {
        $this->alphabet = $alphabet;
    }

    /**
     * @param int $min
     * @param int $max
     *
     * @return int
     */
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
            $rnd = hexdec(bin2hex($randomBytes));
            // discard irrelevant bits
            $rnd = $rnd & $filter;
        } while ($rnd >= $range);

        return $min + $rnd;
    }

    /**
     * @param int $length
     *
     * @return string
     */
    public function generate(int $length = self::DEFAULT_TOKEN_LENGTH): string
    {
        $token = '';

        for ($i = 0; $i < $length; $i++) {
            $token .= $this->alphabet[$this->getRandomNumberFromRange(0, strlen($this->alphabet))];
        }

        return $token;
    }
}
