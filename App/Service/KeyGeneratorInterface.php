<?php

namespace Bolge\App\Service;

interface KeyGeneratorInterface
{
    /**
     * Generate license key and check if not exists in database
     *
     * @param integer $numSegments
     * @param integer $segmentChars
     * @param string $chars
     * @return string
     */
    public function generate(int $numSegments = 4, int $segmentChars = 6, string $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789'): string;
}