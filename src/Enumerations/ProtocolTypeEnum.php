<?php

namespace SFW2\Validator\Enumerations;

enum ProtocolTypeEnum {
    case NOT_SPECIFIED;
    case WITH_HTTPS;
    case WITH_HTTP;
    case WITH_HTTP_OR_HTTPS;
}