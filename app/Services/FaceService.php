<?php

namespace App\Services;

class FaceService
{
    public static function cosineDistance(array $a, array $b): float
    {
        $dot = 0;
        $normA = 0;
        $normB = 0;

        $length = min(count($a), count($b));

        for ($i = 0; $i < $length; $i++) {
            $dot += $a[$i] * $b[$i];
            $normA += $a[$i] ** 2;
            $normB += $b[$i] ** 2;
        }

        if ($normA == 0 || $normB == 0) {
            return 1; // paling jauh
        }

        return 1 - ($dot / (sqrt($normA) * sqrt($normB)));
    }
}
