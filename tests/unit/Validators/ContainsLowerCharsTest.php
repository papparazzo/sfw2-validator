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

namespace unit\Validators;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SFW2\Validator\Exception;
use SFW2\Validator\Exception as ValidatorException;
use SFW2\Validator\Test\IsBoolTest;
use SFW2\Validator\Validators\ContainsLowerChars;

class ContainsLowerCharsTest extends TestCase
{
    /**
     * @throws Exception
     */
    #[DataProvider('getStringDataprovider')]
    public function testValidValues(int $min, string $value): void
    {
        $rule = new ContainsLowerChars($min);
        self::assertEquals($value, $rule->validate($value));
    }

    public static function getStringDataprovider(): array
    {
        return [
            [3, 'aaa'],
            [1, 'aaa'],
            [0, 'aaa'],
            [0, 'A'],
            [0, ''],
            [1, 'a'],
            [1, 'aA'],
            [1, 'Aa'],
        ];
    }

    #[DataProvider('getInvalidStringDataprovider')]
    public function testInvalidValues(int $min, string $value): void
    {
        $this->expectException(ValidatorException::class);
        $rule = new ContainsLowerChars($min);
        $rule->validate($value);
    }

    public static function getInvalidStringDataprovider(): array
    {
        return [
            [4, 'aaa'],
            [1, 'A'],
            [1, ''],
            [2, 'a'],
            [2, 'aA'],
            [2, 'Aa'],
            [1, '1'],
            [1, '.'],
        ];
    }
}
