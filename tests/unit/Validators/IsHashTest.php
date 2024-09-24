<?php

/*
 *  Project:    sfw2-validator
 *
 *  Copyright (C) 2020 Stefan Paproth <pappi-@gmx.de>
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

namespace SFW2\Validator\Test\Validators;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SFW2\Validator\Exception as ValidatorException;
use SFW2\Validator\Validators\IsHash;

final class IsHashTest extends TestCase
{
    #[DataProvider('getInvalidHashes')]
    public function testInvalidHash(string $value): void
    {
        $this->expectException(ValidatorException::class);

        $rule = new IsHash();
        $rule->validate($value);
    }


    public static function getInvalidHashes(): array
    {
        return [
            ['<'],
            ['zu'],
            ['1qw'],
            ['a bc']
        ];
    }

    /**
     * @throws ValidatorException
     */
    #[DataProvider('getValidHashes')]
    public function testValidHash(string $value): void
    {
        $rule = new IsHash();
        self::assertEquals($value, $rule->validate($value));
    }

    public static function getValidHashes(): array
    {
        return [
            ['1'],
            ['abcdef'],
            ['ABCDEF'],
            ['1234567890ABCDEF'],
            ['5d41402abc4b2a76b9719d911017c592']
        ];
    }
}
