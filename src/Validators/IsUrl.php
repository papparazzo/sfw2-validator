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

declare(strict_types=1);

namespace SFW2\Validator\Validators;

use Exception;
use SFW2\Validator\Enumerations\ProtocolTypeEnum;
use SFW2\Validator\Exception as ValidatorException;
use SFW2\Validator\ValidatorRuleNotNullable;

class IsUrl extends ValidatorRuleNotNullable {

    protected ProtocolTypeEnum $shema;

    public function __construct(ProtocolTypeEnum $shema = ProtocolTypeEnum::NOT_SPECIFIED) {
        $this->shema = $shema;
    }

    /**
     * @throws ValidatorException
     * @throws Exception
     */
    public function validate(string $value): string
    {
        $value = trim($value);
        if ($value == '') {
            return $value;
        }

        if (filter_var($value, FILTER_VALIDATE_URL) === false) {
            throw new ValidatorException('Der Inhalt ist keine gültige URL.');
        }

        switch ($this->shema) {
            case ProtocolTypeEnum::NOT_SPECIFIED:
                break;

            case ProtocolTypeEnum::WITH_HTTP:
                if (!preg_match('#^(http)#', $value)) {
                    throw new ValidatorException('Die URL fängt nicht mit HTTP an.');
                }
                break;

            case ProtocolTypeEnum::WITH_HTTPS:
                if (!preg_match('#^(https)#', $value)) {
                    throw new ValidatorException('Die URL fängt nicht mit HTTPS an.');
                }
                break;

            case ProtocolTypeEnum::WITH_HTTP_OR_HTTPS:
                if (!preg_match('#^(http|https)#', $value)) {
                    throw new ValidatorException('Die URL fängt nicht mit HTTP(S) an.');
                }
                break;
        }
        return $value;
    }
}
