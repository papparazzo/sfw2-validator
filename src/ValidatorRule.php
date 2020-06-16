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

abstract class ValidatorRule {

    const REGEX_TEXT_SIMPLE = '#^[A-Za-zäÄöÖüÜß0-9]+$#';
    const REGEX_FILE_NAME   = '#^[A-Za-zäÄöÖüÜß0-9._]+$#';
    const REGEX_NAME        = '#^[A-Za-zäÄöÖüÜß0-9._\- ]+$#';
    const REGEX_ID          = '#^[A-Za-z0-9\-_]+$#';
    const REGEX_STRICT      = '#^[A-Za-z0-9]+$#';
    const REGEX_HASH        = '#^[A-Fa-f0-9]+$#';
    const REGEX_NUMERIC     = '#^[0-9\-]+$#';
    const REGEX_TIME        = '#^[0-2]?[0-9]:[0-5]?[0-9]$#';
    const REGEX_PHONE       = '#^\(?(\+|00|0)?[1-9]?[0-9 ]{1,9}(/|\))?[0-9 \-]+$#';
    const REGEX_EMAIL_ADDR  = '#^[a-zA-Z0-9._%\+\-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$#';

    abstract public function validate(?string $value) : string;

    protected function replaceIn(string $key, $params = []): string {
        if (empty($params)) {
            return $key;
        }

        $keys = array_map(fn($n) => '{' . $n . '}', array_keys($params));
        return str_replace($keys, $params, $key);
    }
}
