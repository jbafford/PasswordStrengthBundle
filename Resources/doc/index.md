BaffordPasswordStrengthBundle
=============================

##Installation

### Get the bundle

Add the following lines in your composer.json:

``` json
{
    "require": {
        "jbafford/password-strength-bundle": "dev-master",
    }
}
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


##Usage
