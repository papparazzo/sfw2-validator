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

class Validator
{

    protected Ruleset $rulesets;

    public function __construct(Ruleset $ruleset)
    {
        $this->rulesets = $ruleset;
    }

    /**
     * @param  array<string, string>                              $input
     * @param  array<string, array{hint: string, value: ?string}> $output
     * @return bool
     */
    public function validate(array $input, array &$output): bool
    {
        $hasErrors = false;
        $output = [];
        foreach ($this->rulesets->getRules() as $field => $rulesets) {
            if ($this->validateElement($field, $rulesets, $input, $output)) {
                $hasErrors = true;
            }
        }
        return !$hasErrors;
    }

    /**
     * @param  string                                             $field
     * @param  ValidatorRule[]                                    $rulesets
     * @param  array<string, string>                              $input
     * @param  array<string, array{hint: string, value: ?string}> $output
     * @return bool
     */
    protected function validateElement(string $field, array $rulesets, array $input, array &$output): bool
    {
        $output[$field]['value'] = null;

        if (isset($input[$field])) {
            $output[$field]['value'] = $input[$field];
        }

        try {
            foreach ($rulesets as $ruleset) {
                $output[$field]['hint'] = '';
                $output[$field]['value'] = $ruleset->validateNullable($output[$field]['value']);
            }
        } catch (ValidatorException $ex) {
            $output[$field]['hint'] = $ex->getMessage();
            return true;
        }
        return false;
    }
}
