<?php

namespace Bafford\PasswordStrengthBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PasswordStrengthValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if($value === null)
            $value = '';
        
        if($constraint->minLength > 0 && (strlen($value) < $constraint->minLength))
            $this->context->addViolation($constraint->tooShortMessage, ['{{length}}' => $constraint->minLength]);
        
        if($constraint->requireLetters && !preg_match('/\pL/', $value))
            $this->context->addViolation($constraint->missingLettersMessage);
        
        if($constraint->requireCaseDiff && !preg_match('/(\p{Ll}+.*\p{Lu})|(\p{Lu}+.*\p{Ll})/', $value))
            $this->context->addViolation($constraint->requireCaseDiffMessage);
        
        if($constraint->requireNumbers && !preg_match('/\pN/', $value))
            $this->context->addViolation($constraint->missingNumbersMessage);
    }
}