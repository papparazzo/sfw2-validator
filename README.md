# sfw2-validator

Simple validator-class for checking and validating post-data.

## How to use it


First create a new Rulset

```php
    use SFW2\Validator\Ruleset;

    $rulset = new Ruleset();

```
Then add new rules for every $_REQUEST-param. For example
if you want to check set param "home" is set and not empty write:

```php
    use SFW2\Validator\Validators\IsNotEmpty;

    $rulset->addNewRules('home', new IsNotEmpty());
```

if you want to check that "startTime" is a valid time write:

```php
    use SFW2\Validator\Validators\IsNotEmpty;
    use SFW2\Validator\Validators\IsTime;

    $rulset->addNewRules('startTime', new IsNotEmpty(), new IsTime());
```

After setup all rules simply create a validator-object with the given rules and call "validate".
The first param contains the REQUEST-data, the second param returns the validated and sanitized vales
from REQUEST by reference. The boolean return-value of validate indicates a successfully validation of
all params

```php
    use SFW2\Validator\Validator;

    $validator = new Validator($rulset);
    $values = [];

    $error = $validator->validate($_POST, $values);
```
