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
        
        if (function_exists('grapheme_strlen') && 'UTF-8' === $constraint->charset) {
            $length = grapheme_strlen($value);
        } else {
            $length = mb_strlen($value, $constraint->charset);
        }
            
        if($constraint->minLength > 0 && (mb_strlen($value, $constraint->charset) < $constraint->minLength))
            $this->context->addViolation($constraint->tooShortMessage, array('{{length}}' => $constraint->minLength));
        
        if($constraint->requireLetters && !preg_match('/\pL/', $value))
            $this->context->addViolation($constraint->missingLettersMessage);
        
        if($constraint->requireCaseDiff && !preg_match('/(\p{Ll}+.*\p{Lu})|(\p{Lu}+.*\p{Ll})/', $value))
            $this->context->addViolation($constraint->requireCaseDiffMessage);
        
        if($constraint->requireNumbers && !preg_match('/\pN/', $value))
            $this->context->addViolation($constraint->missingNumbersMessage);
        
        //Cc: Control; M: Mark; P: Punctuation; S: Symbol; Z:  Separator
        //Not checked: L: Letter; N: Number; C{fosn}: format, private-use, surrogate, unassigned
        if($constraint->requireSpecials && !preg_match('/[\p{Cc}\pM\pP\pS\pZ]/', $value))
            $this->context->addViolation($constraint->missingSpecialsMessage);
    }
}
