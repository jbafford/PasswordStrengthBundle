<?php

namespace Bafford\PasswordStrengthBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PasswordStrengthValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return;
        }

        if (!is_scalar($value) && !(is_object($value) && method_exists($value, '__toString'))) {
            throw new UnexpectedTypeException($value, 'string');
        }

        $stringValue = (string) $value;

        if (function_exists('grapheme_strlen') && 'UTF-8' === $constraint->charset) {
            $length = grapheme_strlen($stringValue);
        } elseif (function_exists('mb_strlen')) {
            $length = mb_strlen($stringValue, $constraint->charset);
        } else {
            $length = strlen($stringValue);
        }

        if($constraint->minLength > 0 && ($length < $constraint->minLength))
            $this->context->addViolation($constraint->tooShortMessage, array('{{length}}' => $constraint->minLength));

        if($constraint->maxLength > 0 && ($length > $constraint->maxLength))
            $this->context->addViolation($constraint->tooLongMessage, array('{{length}}' => $constraint->maxLength));

        if($constraint->requireLetters && !preg_match('/\pL/', $stringValue))
            $this->context->addViolation($constraint->missingLettersMessage);

        if($constraint->requireCaseDiff && !preg_match('/(\p{Ll}+.*\p{Lu})|(\p{Lu}+.*\p{Ll})/', $stringValue))
            $this->context->addViolation($constraint->requireCaseDiffMessage);

        if($constraint->requireNumbers && !preg_match('/\pN/', $stringValue))
            $this->context->addViolation($constraint->missingNumbersMessage);

        if($constraint->requireNonAlphanumeric && ctype_alnum($stringValue))
            $this->context->addViolation($constraint->missingNonAlphanumericMessage);
    }
}
