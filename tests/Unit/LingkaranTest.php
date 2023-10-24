<?php

namespace Ariefadjie\Laravai\Tests\Unit;

use Ariefadjie\Laravai\Tests\TestCase;
use Ariefadjie\Laravai\Facades\Lingkaran;

class LingkaranTest extends TestCase
{
    public function test_luas()
    {
        $result = Lingkaran::luas(3);
        $expect = 28.274333882308;

        $this->assertEquals(round($result, 2), round($expect, 2));
    }

    public function test_keliling()
    {
        $result = Lingkaran::keliling(3);
        $expect = 18.849555921539;

        $this->assertEquals(round($result, 2), round($expect, 2));
    }
}
