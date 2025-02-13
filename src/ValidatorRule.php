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

use SFW2\Validator\Exception as ValidatorException;

abstract class ValidatorRule
{
     /**
      * @throws ValidatorException
      */
    abstract public function validateNullable(?string $value): string;

    /**
     * @param  string                $key
     * @param  array<string, string> $params
     * @return string
     */
    protected function replaceIn(string $key, array $params = []): string
    {
        if (empty($params)) {
            return $key;
        }

        $keys = array_map(fn($n) => '{' . $n . '}', array_keys($params));
        return str_replace($keys, $params, $key);
    }
}
