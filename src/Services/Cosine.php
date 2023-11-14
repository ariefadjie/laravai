<?php

namespace Ariefadjie\Laravai\Services;

class Cosine
{
    public function dot($vector_a, $vector_b) // dot product
    {
        $product = 0;
        $length = count($vector_a);
        for ($i = 0; $i < $length; $i++) {
            $product += $vector_a[$i] * $vector_b[$i];
        }
        return $product;
    }

    public function norm($vector) // euclidean norm
    {
        $norm = 0.0;
        $length = count($vector);
        for ($i = 0; $i < $length; $i++) {
            $norm += $vector[$i] * $vector[$i];
        }

        return sqrt($norm);
    }

    public function similarity($vector_a, $vector_b)
    {
        $dot_product = $this->dot($vector_a, $vector_b);
        $norm_a = $this->norm($vector_a);
        $norm_b = $this->norm($vector_b);

        $similarity = $dot_product / ($norm_a * $norm_b);

        return $similarity;
    }
}
