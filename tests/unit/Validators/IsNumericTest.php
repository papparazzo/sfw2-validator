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
use SFW2\Validator\Validators\IsNumeric;

class IsNumericTest extends TestCase
{
    #[DataProvider('getInvalidNumbers')]
    public function testInvalidNumbers(string $value): void
    {
        $this->expectException(ValidatorException::class);

        $rule = new IsNumeric();
        $rule->validate($value);
    }

    public static function getInvalidNumbers(): array
    {
        return [
            ['a'],
            ['A1'],
            [' a'],
            ['1a']
        ];
    }

    /**
     * @throws ValidatorException
     */
    #[DataProvider('getValidNumbers')]
    public function testValidNumbers(string $value, string $expected): void
    {
        $rule = new IsNumeric();
        self::assertEquals($expected, $rule->validate($value));
    }

    public static function getValidNumbers(): array
    {
        return [
            [' ',       ''       ],
            [' 0',      '0'      ],
            ['      ',  ''       ],
            [' 7     ', '7'      ],
            ['      9', '9'      ],
            ['',        ''       ],
            ['1',       '1'      ],
            ['2',       '2'      ],
            ['4',       '4'      ],
            ['0',       '0'      ],
            ['-2',      '-2'     ],
            ['-2.2',    '-2.2'   ],
            ['1.2',     '1.2'    ],
            ['.2',      '.2'     ],
            ['0.2',     '0.2'    ],
            ['0.23422', '0.23422'],
        ];
    }
}
