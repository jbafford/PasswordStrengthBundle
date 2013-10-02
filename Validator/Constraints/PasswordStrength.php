<?php

namespace Bafford\PasswordStrengthBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class PasswordStrength extends Constraint
{
    public $tooShortMessage = 'Your password must be at least {{length}} characters long.';
    public $tooLongMessage = 'Your password must not exceed {{length}} characters.';
    public $missingLettersMessage = 'Your password must include at least one letter.';
    public $requireCaseDiffMessage = 'Your password must include both upper and lower case letters.';
    public $missingNumbersMessage = 'Your password must include at least one digit.';
    public $missingNonAlphanumericMessage = 'Your password must include at least one non-alphanumeric character.';
    
    public $minLength = 5;
    public $maxLength = 0;
    public $requireLetters = true;
    public $requireCaseDiff = false;
    public $requireNumbers = false;
    public $requireNonAlphanumeric = false;
}
