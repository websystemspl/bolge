<?php

namespace Bolge\App\Service;

class KeyGenerator implements KeyGeneratorInterface
{
    /**
     * Generate key and check if not exists in database
     *
     * @param integer $numSegments
     * @param integer $segmentChars
     * @param string $chars
     * @return string
     */
    public function generate(int $numSegments = 4, int $segmentChars = 6, string $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789'): string
    {
        $licenseString = '';

        for ($i = 0; $i < $numSegments; $i++) {
            $segment = '';
            for ($j = 0; $j < $segmentChars; $j++) {
                $segment .= $chars[rand(0, strlen($chars)-1)];
            }
            $licenseString .= $segment;
            if ($i < ($numSegments - 1)) {
                $licenseString .= '-';
            }
        }

        return $licenseString;
    }
}