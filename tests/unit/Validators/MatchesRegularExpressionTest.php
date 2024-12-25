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
use SFW2\Validator\Exception as ValidatorException;
use SFW2\Validator\Validators\MatchesRegularExpression;
use PHPUnit\Framework\TestCase;

class MatchesRegularExpressionTest extends TestCase
{
    #[DataProvider('validateValuesDataProvider')]
    public function testValidateValues(string $value, string $regex): void
    {
        $rule = new MatchesRegularExpression($regex);
        $this->assertEquals($value, $rule->validate($value));
    }

    public static function validateValuesDataProvider(): array
    {
        return [
            ['MüMü', '/^[\p{L}\- ]*$/u']
        ];
    }

    #[DataProvider('validateInvalidValuesDataProvider')]
    public function testValidateInvalidValues(string $value, string $regex): void
    {
        $this->expectException(ValidatorException::class);

        $rule = new MatchesRegularExpression($regex);
        $rule->validate($value);
    }

    public static function validateInvalidValuesDataProvider(): array
    {
        return [
            ['MüMü', '/^[\p{L}\- ]*$/']
        ];
    }
}
