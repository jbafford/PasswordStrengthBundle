BaffordPasswordStrengthBundle
=============================

## Installation

### Get the bundle

Add the following in your composer.json:

``` json
{
    "require": {
        "jbafford/password-strength-bundle": "^1.0"
    }
}
```

Or,

``` bash
./composer.phar require jbafford/password-strength-bundle dev-master
```

### Initialize the bundle

To start using the bundle, register the bundle in your application's kernel class:

``` php
// app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
        new Bafford\PasswordStrengthBundle\BaffordPasswordStrengthBundle(),
    );
)
```


## Usage

If you are using annotations for validations, include the constraints namespace:

``` php
use Bafford\PasswordStrengthBundle\Validator\Constraints as BAssert;
```

and then add the ```PasswordStrength``` validator to the relevant field:

``` php
/**
 * @BAssert\PasswordStrength(minLength=7, requireNumbers=true)
 */
protected $password;
```

Default options include:

- minLength = _5_
- requireLetters = _true_
- requireCaseDiff = _false_
- requireNumbers = _false_
- requireSpecials  = _false_

You can customize the validation error messages:

- tooShortMessage = _'Your password must be at least {{length}} characters long.'_
- missingLettersMessage = _'Your password must include at least one letter.'_
- requireCaseDiffMessage = _'Your password must include both upper and lower case letters.'_
- missingNumbersMessage = _'Your password must include at least one number.'_
- missingSpecialsMessage = _'Your password must include at least one special character.'_
