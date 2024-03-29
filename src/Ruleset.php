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

namespace SFW2\Validator;

class Ruleset
{
    /**
     * @var array<string, ValidatorRule[]>
     */
    private array $rules = [];

    public function addNewRules(string $element, ValidatorRule ...$rules): void
    {
        foreach ($rules as $rule) {
            $this->rules[$element][] = $rule;
        }
    }

    /**
     * @return array<string, ValidatorRule[]>
     */
    public function getRules(): array
    {
        return $this->rules;
    }
}
