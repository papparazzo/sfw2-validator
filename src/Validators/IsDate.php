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

class IsDate extends ValidatorRule {

    const NO_COMPARE         = 0;
    const GREATER_THAN       = 1;
    const LESS_THAN          = 2;
    const GREATER_EQUAL_THAN = 3;
    const LESS_EQUAL_THAN    = 4;
    const FUTURE_DATE        = 5;
    const PAST_DATE          = 6;


    protected int $operator;
    protected string $compareTo;

    public function __construct(int $operator = self::NO_COMPARE, string $compareTo = '') {
        $this->operator = $operator;
        $this->compareTo = $compareTo;
    }

    /**
     * @throws \SFW2\Validator\Exception
     * @throws \Exception
     */
    public function validate(?string $value) : string {
        if(!$this->checkDate($value)) {
            throw new ValidatorException('Der Inhalt ist kein gültiges Datum.');
        }
        if(!$this->checkDate($this->compareTo)) {
            throw new Exception('comparator time is invalid');
        }

        if($value == '') {
            return $value;
        }

        switch($this->operator) {
            case self::NO_COMPARE:
                break;

            case self::GREATER_THAN:
                if(strtotime($value) <= strtotime($this->compareTo) ) {
                    throw new ValidatorException($this->replaceIn('Das Datum muss nach dem {DATE} liegen.', ['DATE' => $this->formatDate($this->compareTo)]));
                }
                break;

            case self::LESS_THAN:
                if(strtotime($value) > strtotime($this->compareTo) ) {
                    throw new ValidatorException($this->replaceIn('Das Datum muss vor dem {DATE} liegen.', ['DATE' => $this->formatDate($this->compareTo)]));
                }
                break;

            case self::GREATER_EQUAL_THAN:
                if(strtotime($value) < strtotime($this->compareTo) ) {
                    throw new ValidatorException($this->replaceIn('Das Datum muss nach oder gleich dem {DATE} sein.', ['DATE' => $this->formatDate($this->compareTo)]));
                }
                break;

            case self::LESS_EQUAL_THAN:
                if(strtotime($value) >= strtotime($this->compareTo) ) {
                    throw new ValidatorException($this->replaceIn('Das Datum muss vor oder gleich dem {DATE} sein.', ['DATE' => $this->formatDate($this->compareTo)]));
                }
                break;

            case self::FUTURE_DATE:
                if(strtotime($value) < time()) {
                    throw new ValidatorException('Das Datum muss in der Zukunft liegen.');
                }
                break;

            case self::PAST_DATE:
                if(strtotime($value) > time()) {
                    throw new ValidatorException('Das Datum muss in der Vergangenheit liegen.');
                }
                break;

            default:
                throw new Exception('invalid operator given');
        }
        return $value;
    }

    protected function checkDate(string &$value) : bool {
        $value = trim($value);
        if($value == '') {
            return true;
        }

        $result = date_parse($value);

        if($result === false) {
            return false;
        }

        if($result['month'] < 10) {
            $result['month'] = '0' . $result['month'];
        }

        if($result['day'] < 10) {
            $result['day'] = '0' . $result['day'];
        }

        $value = $result['year'] . '-' . $result['month'] . '-' . $result['day'];
        return true;
    }

    /**
     * @throws \Exception
     */
    protected function formatDate(string $value) : string {
        $result = date("d.m.Y", strtotime($value));
        if($result === false) {
            throw new Exception("parsing of date <$value> failed!");
        }
        return $result;
    }
}
