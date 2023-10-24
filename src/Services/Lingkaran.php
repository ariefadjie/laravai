<?php

namespace Ariefadjie\Laravai\Services;

class Lingkaran
{
    public function luas($r)
    {
        return pi() * pow($r, 2);
    }

    public function keliling($r)
    {
        return 2 * pi() * $r;
    }
}
