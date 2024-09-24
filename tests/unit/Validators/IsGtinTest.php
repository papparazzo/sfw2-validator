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
use SFW2\Validator\Exception as ValidatorException;
use SFW2\Validator\Validators\IsGtin;

class IsGtinTest extends TestCase
{
    #[DataProvider('getInvalidGtin')]
    public function testInvalidGtin(string $value): void
    {
        $this->expectException(ValidatorException::class);

        $rule = new IsGtin();
        $rule->validate($value);
    }

    public static function getInvalidGtin(): array
    {
        return [
            ['0'],
            ['111111111111'],
            ['1111111111111'],
            ['11111111111111']
        ];
    }

    /**
     * @throws ValidatorException
     */
    #[DataProvider('getValidGtin')]
    public function testValidGtin(string $value): void
    {
        $rule = new IsGtin();
        self::assertEquals($value, $rule->validate($value));
    }

    public static function getValidGtin(): array
    {
        return [
            [''],
            ['4001883445007'],
            ['4001883965130'],
            ['4066600345251'],
            ['4311501548318']
        ];
    }
}
