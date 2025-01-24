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
use SFW2\Validator\ValidatorRuleNotNullable;

final class ContainsUpperChars extends ValidatorRuleNotNullable
{
    public function __construct(
        private readonly int $min = 1
    ) {
    }

    /**
     * @throws ValidatorException
     */
    public function validate(string $value): string
    {
        if (mb_strlen((string)preg_replace('#[^[:upper:]]+#', '', $value)) < $this->min) { // FIXME: I18N!
            throw new ValidatorException($this->replaceIn("Der Inhalt muss mindestens {MIN} Großbuchstaben enthalten.", ['MIN' => $this->min]));
        }
        return $value;
    }
}