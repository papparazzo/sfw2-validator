<?php

namespace SFW2\Validator\Enumerations;

enum CompareEnum {
    case NO_COMPARE;
    case GREATER_THAN;
    case LESS_THAN;
    case GREATER_EQUAL_THAN;
    case LESS_EQUAL_THAN;
}