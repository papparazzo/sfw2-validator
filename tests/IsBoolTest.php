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

use PHPUnit\Framework\TestCase;
use SFW2\Validator\Validators\IsBool;
use SFW2\Validator\Exception as ValidatorException;

final class IsBoolTest extends TestCase {

    /**
     * @dataProvider getFalse
     */
    public function testFalse(string $value): void {
        $rule = new IsBool();
        $this->assertEquals('0', $rule->validate($value));
    }

    public static function getFalse(): array {
        return [
            [''],
            [' '],
            ['   '],
            ['0'],
            ['false'],
            ['FALSE'],
            ['FaLsE'],
            ['fAlSe'],
            ['0 '],
            ['false '],
            ['FALSE '],
            ['FaLsE '],
            ['fAlSe '],
            [' 0'],
            [' false'],
            [' FALSE'],
            [' FaLsE'],
            [' fAlSe'],
            [' 0 '],
            [' false '],
            [' FALSE '],
            [' FaLsE '],
            [' fAlSe '],
        ];
    }

    /**
     * @dataProvider getTrue
     */
    public function testTrue(string $value): void {
        $rule = new IsBool();
        $this->assertEquals('1', $rule->validate($value));
    }

    public static function getTrue(): array {
        return [
            ['a'],
            ['1'],
            ['01'],
            ['falses'],
            ['tFALSE'],
            ['Falsch'],
        ];
    }

    public function testValidateNullValue(): void {
        $rule = new IsBool();
        $this->assertEquals('0', $rule->validate(null));
    }
}
