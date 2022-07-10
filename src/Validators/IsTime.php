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
use Exception;

class IsTime extends ValidatorRule {

    const NO_COMPARE         = 0;
    const GREATER_THAN       = 1;
    const LESS_THAN          = 2;
    const GREATER_EQUAL_THAN = 3;
    const LESS_EQUAL_THAN    = 4;

    protected int $operator;
    protected string $compareTo;

    public function __construct($operator = self::NO_COMPARE, string $compareTo = '') {
        $this->operator = $operator;
        $this->compareTo = $compareTo;
    }

    /**
     * @throws \SFW2\Validator\Exception
     * @throws \Exception
     */
    public function validate(?string $value) : string {
        if(!$this->checkTime($value)) {
            throw new ValidatorException('Der Inhalt ist keine gültige Uhrzeit (hh:mm).');
        }
        if(!$this->checkTime($this->compareTo)) {
            throw new Exception('comparator time is invalid');
        }

        if($value == '') {
            return $value;
        }

        switch($this->operator) {
            case self::NO_COMPARE:
                break;

            case self::GREATER_THAN:
                if(intval(str_replace(':', '', $value)) <= intval(str_replace(':', '', $this->compareTo))) {
                    throw new ValidatorException($this->replaceIn('Die Uhrzeit muss größer als {TIME} Uhr sein', ['TIME' => $this->compareTo]));
                }
                break;

            case self::LESS_THAN:
                if(intval(str_replace(':', '', $value)) > intval(str_replace(':', '', $this->compareTo))) {
                    throw new ValidatorException($this->replaceIn('Die Uhrzeit muss kleiner als {TIME} Uhr sein', ['TIME' => $this->compareTo]));
                }
                break;

            case self::GREATER_EQUAL_THAN:
                if(intval(str_replace(':', '', $value)) < intval(str_replace(':', '', $this->compareTo))) {
                    throw new ValidatorException($this->replaceIn('Die Uhrzeit muss größer gleich als {TIME} Uhr sein', ['TIME' => $this->compareTo]));
                }
                break;

            case self::LESS_EQUAL_THAN:
                if(intval(str_replace(':', '', $value)) >= intval(str_replace(':', '', $this->compareTo))) {
                    throw new ValidatorException($this->replaceIn('Die Uhrzeit muss kleiner gleich als {TIME} Uhr sein', ['TIME' => $this->compareTo]));
                }
                break;

            default:
                throw new Exception('invalid operator given');
        }
        return $value;
    }

    protected function checkTime(string &$value) : bool {
        $value = trim($value);
        if($value == '') {
            return true;
        }

        if(!preg_match(self::REGEX_TIME, $value)) {
            return false;
        }

        $frc = explode(':', $value);

        if(intval($frc[0]) < 0 || intval($frc[0]) > 23 || intval($frc[1]) < 0 || intval($frc[1]) > 59) {
            return false;
        }
        $rv = '';
        if(strlen($frc[0]) == 1) {
            $rv = '0';
        }
        $rv .= $frc[0] . ':';

        if(strlen($frc[1]) == 1) {
            $rv .= '0';
        }
        $value = $rv . $frc[1];
        return true;
    }
}
