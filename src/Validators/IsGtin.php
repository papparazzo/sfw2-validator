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
 */

declare(strict_types=1);

namespace SFW2\Validator\Validators;

use SFW2\Validator\Exception as ValidatorException;

final class IsGtin extends IsInt
{
    function validate(string $value): string
    {
        $value = parent::validate($value);

        if ($value == '') {
            return $value;
        }
        if (!$this->checkGtin($value)) {
            throw new ValidatorException("Der Inhalt ist keine gültige GTIN / EAN.");
        }
        return $value;
    }

    private function checkGtin(string $number): bool
    {
        if (mb_strlen($number) !== 13) {
            return false;
        }

        $sum = 0;

        for ($i = 0; $i < 12; ++$i) {
            $n = (int)$number[$i];
            $sum += $n * ($i % 2 ? 3 : 1);
        }

        $res = (10 - $sum % 10) % 10;

        return  $res === (int)$number[12];
    }
}