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
use SFW2\Validator\Validators\IsEMailAddress;
use SFW2\Validator\Exception as ValidatorException;

final class IsEMailAddressTest extends TestCase {

    /**
     * @dataProvider getInvalidEmailAddresses
     */
    public function testInvalidEMailAddresses(string $value): void {
        $this->expectException(ValidatorException::class);

        $rule = new IsEMailAddress();
        $rule->validate($value);
    }


    public function getInvalidEmailAddresses() : array {
        return [
            ['abc'],
            ['abc@aasdf@asdf']
        ];
    }

    /**
     * @dataProvider getValidEmailAddresses
     */
    public function testValidEMailAdresses(string $value): void {
        $rule = new IsEMailAddress();
        $this->assertEquals(trim($value), $rule->validate($value));
    }

    public function getValidEmailAddresses() : array {
        return [
            ['a@bc.de'],
            [' a@bc.de'],
            ['a@bc.de '],
            [' a@bc.de '],
            ['']
        ];
    }

    public function testValidNull(): void {
        $rule = new IsEMailAddress();
        $this->assertEquals(null, $rule->validate(null));
    }
}
