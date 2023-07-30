<?php

/*
 *  Project:    sfw2-validator
 *
 *  Copyright (C) 2019 Stefan Paproth <pappi-@gmx.de>
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

namespace SFW2\Validator\Validators;

use SFW2\Validator\ValidatorRule;
use SFW2\Validator\Exception as ValidatorException;

class HasMaxLength extends ValidatorRule {

    protected int $max;
    protected bool $trim;

    public function __construct(int $max, bool $trim = true) {
        $this->max = $max;
        $this->trim = $trim;
    }

    /**
     * @throws \SFW2\Validator\Exception
     */
    public function validate(?string $value): string {
        if($this->trim) {
            $value = trim($value);
        }

        if(mb_strlen($value) > $this->max) {
            throw new ValidatorException($this->replaceIn("Der Inhalt darf nicht länger als {MAX} Zeichen sein.", ['MAX' => $this->max]));
        }
        return $value;
    }
}
