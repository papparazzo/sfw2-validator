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

use PHPUnit\Framework\TestCase;
use SFW2\Validator\Exception as ValidatorException;
use SFW2\Validator\Validators\IsAvailable;

final class IsAvailableTest extends TestCase
{

    public function testValidateNullValue(): void
    {
        $this->expectException(ValidatorException::class);

        $rule = new IsAvailable();
        $rule->validate(null);
    }

    /**
     * @throws ValidatorException
     */
    public function testValidateNonNullValues(): void
    {
        $rule = new IsAvailable();
        self::assertEquals('', $rule->validate(''));
        self::assertEquals(' Hal.o ', $rule->validate(' Hal.o '));
    }

}
