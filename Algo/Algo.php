<?php

declare(strict_types=1);

namespace Algo;

class Algo
{
    public function display(int $n): void
    {
        for ($i = 1; $i <= $n; $i++) {
            var_dump($this->displayFromNumber($i));
        }
    }

    private function displayFromNumber(int $number): string
    {
        $display = '';
        if ($number % 3 === 0) {
            $display = 'Fizz';
        }

        if ($number % 5 === 0) {
            $display .= 'Buzz';
        }

        if ($display === '') {
            $display = (string) $number;
        }

        return $display;
    }
}
