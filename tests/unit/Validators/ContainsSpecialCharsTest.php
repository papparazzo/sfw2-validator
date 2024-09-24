<?php

/**
 *  SFW2 - SimpleFrameWork
 *
 *  Copyright (C) 2024  Stefan Paproth
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as
 *  published by the Free Software Foundation, either version 3 of the
 *  License, or (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program. If not, see <http://www.gnu.org/licenses/agpl.txt>.
 *
 */

declare(strict_types=1);

namespace SFW2\Validator\Test\Validators;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SFW2\Validator\Exception;
use SFW2\Validator\Exception as ValidatorException;
use SFW2\Validator\Validators\ContainsSpecialChars;

class ContainsSpecialCharsTest extends TestCase
{
    /**
     * @throws Exception
     */
    #[DataProvider('getStringDataprovider')]
    public function testValidValues(int $min, string $value): void
    {
        $rule = new ContainsSpecialChars($min);
        self::assertEquals($value, $rule->validate($value));
    }

    public static function getStringDataprovider(): array
    {
        return [
            [3, '.-/'],
            [1, '.aa'],
            [0, 'aaa'],
            [0, 'A'],
            [0, ''],
            [1, '&'],
            [1, '%A'],
            [6, ',.-;:_'],
            [22, '^!"$%&/()=?{[]}\+#*~<>'],
        ];
    }

    #[DataProvider('getInvalidStringDataprovider')]
    public function testInvalidValues(int $min, string $value): void
    {
        $this->expectException(ValidatorException::class);
        $rule = new ContainsSpecialChars($min);
        $rule->validate($value);
    }

    public static function getInvalidStringDataprovider(): array
    {
        return [
            [4, '[]{'],
            [1, 'A'],
            [1, ''],
            [2, '('],
            [2, '(A'],
            [2, 'A('],
        ];
    }

}
