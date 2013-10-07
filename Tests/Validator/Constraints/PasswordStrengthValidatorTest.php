<?php

namespace Bafford\PasswordStrengthBundle\Tests\Validator\Constraints;

use Bafford\PasswordStrengthBundle\Validator\Constraints as BPSB;

class PasswordStrengthValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testTooShort()
    {
        $constraint = new BPSB\PasswordStrength;
        $validator = new BPSB\PasswordStrengthValidator;
        $mockContext = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        $validator->initialize($mockContext);
        
        $mockContext->expects($this->once())
            ->method('addViolation')
            ->with($this->equalTo($constraint->tooShortMessage), $this->equalTo(array('{{length}}' => $constraint->minLength)));
        
        $validator->validate('test', $constraint);
    }

    public function testTooShortMultiBytes()
    {
        $constraint = new BPSB\PasswordStrength;
        $validator = new BPSB\PasswordStrengthValidator;
        $mockContext = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        $validator->initialize($mockContext);

        $mockContext->expects($this->once())
            ->method('addViolation')
            ->with($this->equalTo($constraint->tooShortMessage), $this->equalTo(array('{{length}}' => $constraint->minLength)));

        $validator->validate('Адыг', $constraint);
    }

    public function testTooLong()
    {
        $constraint = new BPSB\PasswordStrength;
        $validator = new BPSB\PasswordStrengthValidator;
        $mockContext = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        $validator->initialize($mockContext);
        
        $mockContext->expects($this->once())
            ->method('addViolation')
            ->with($this->equalTo($constraint->tooLongMessage), $this->equalTo(array('{{length}}' => 20)));
        
        $constraint->maxLength = 20;
        $validator->validate('abcdefghijklmnopqrstu', $constraint);
    }
    
    public function testTooLongMultiBytes()
    {
        $constraint = new BPSB\PasswordStrength;
        $validator = new BPSB\PasswordStrengthValidator;
        $mockContext = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        $validator->initialize($mockContext);
        
        $mockContext->expects($this->never())
            ->method('addViolation');

        $constraint->maxLength = 8;
        $validator->validate('Адыгэбзэ', $constraint);
    }
    
    public function testNoLengthRestriction()
    {
        $constraint = new BPSB\PasswordStrength;
        $validator = new BPSB\PasswordStrengthValidator;
        $mockContext = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        $validator->initialize($mockContext);
        
        $mockContext->expects($this->never())
            ->method('addViolation');
        
        $constraint->minLength = 0;
        $validator->validate('test', $constraint);
    }
    
    public function testRequireLettersOffPass()
    {
        $constraint = new BPSB\PasswordStrength;
        $validator = new BPSB\PasswordStrengthValidator;
        $mockContext = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        $validator->initialize($mockContext);
        
        $mockContext->expects($this->never())
            ->method('addViolation');
        
        $constraint->requireLetters = false;
        $validator->validate('12345', $constraint);
    }
    
    public function testRequireLettersOnFail()
    {
        $constraint = new BPSB\PasswordStrength;
        $validator = new BPSB\PasswordStrengthValidator;
        $mockContext = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        $validator->initialize($mockContext);

        $mockContext->expects($this->once())
            ->method('addViolation')
            ->with($this->equalTo($constraint->missingLettersMessage));
        
        $constraint->requireLetters = true;
        $validator->validate('12345', $constraint);
    }
    
    public function testRequireCaseDiffOnFail()
    {
        $constraint = new BPSB\PasswordStrength;
        $validator = new BPSB\PasswordStrengthValidator;
        $mockContext = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        $validator->initialize($mockContext);
        
        $mockContext->expects($this->once())
            ->method('addViolation')
            ->with($this->equalTo($constraint->requireCaseDiffMessage));
        
        $constraint->requireCaseDiff = true;
        $validator->validate('abcde', $constraint);
    }
    
    public function testRequireCaseDiffOnPass()
    {
        $constraint = new BPSB\PasswordStrength;
        $validator = new BPSB\PasswordStrengthValidator;
        $mockContext = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        $validator->initialize($mockContext);
        
        $mockContext->expects($this->never())
            ->method('addViolation');
        
        $constraint->requireCaseDiff = true;
        $validator->validate('aBcDe', $constraint);
    }
    
    public function testRequireNumbersOffPass()
    {
        $constraint = new BPSB\PasswordStrength;
        $validator = new BPSB\PasswordStrengthValidator;
        $mockContext = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        $validator->initialize($mockContext);
        
        $mockContext->expects($this->never())
            ->method('addViolation');
        
        $constraint->requireNumbers = false;
        $validator->validate('abcdef', $constraint);
    }
    
    public function testRequireNumbersOnFail()
    {
        $constraint = new BPSB\PasswordStrength;
        $validator = new BPSB\PasswordStrengthValidator;
        $mockContext = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        $validator->initialize($mockContext);

        $mockContext->expects($this->once())
            ->method('addViolation')
            ->with($this->equalTo($constraint->missingNumbersMessage));
        
        $constraint->requireNumbers = true;
        $validator->validate('abcdef', $constraint);
    }
    
    public function testRequireNumbersOnPass()
    {
        $constraint = new BPSB\PasswordStrength;
        $validator = new BPSB\PasswordStrengthValidator;
        $mockContext = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        $validator->initialize($mockContext);

        $mockContext->expects($this->never())
            ->method('addViolation');
        
        $constraint->requireLetters = false;
        $constraint->requireNumbers = true;
        $validator->validate('12345', $constraint);
        $validator->validate('１２３４５６７８９', $constraint);
    }
    
    public function testRequireLettersNumbersPass()
    {
        $constraint = new BPSB\PasswordStrength;
        $validator = new BPSB\PasswordStrengthValidator;
        $mockContext = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        $validator->initialize($mockContext);

        $mockContext->expects($this->never())
            ->method('addViolation');
        
        $constraint->requireLetters = true;
        $constraint->requireNumbers = true;
        $validator->validate('abcd12345', $constraint);
        $validator->validate('１２３４abc５６７８９', $constraint);
    }
    
    public function testRequireLettersNumbersFail()
    {
        $constraint = new BPSB\PasswordStrength;
        $validator = new BPSB\PasswordStrengthValidator;
        $mockContext = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        $validator->initialize($mockContext);

        $mockContext->expects($this->at(0))
            ->method('addViolation')
            ->with($this->equalTo($constraint->missingLettersMessage));
        
        $mockContext->expects($this->at(1))
            ->method('addViolation')
            ->with($this->equalTo($constraint->missingNumbersMessage));
        
        $constraint->requireLetters = true;
        $constraint->requireNumbers = true;
        $validator->validate('!@#$%^&*()', $constraint);
    }

    public function testRequireNonAlphanumericalOffPass()
    {
        $constraint = new BPSB\PasswordStrength;
        $validator = new BPSB\PasswordStrengthValidator;
        $mockContext = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        $validator->initialize($mockContext);
        
        $mockContext->expects($this->never())
            ->method('addViolation');
        
        $constraint->requireNonAlphanumeric = false;
        $constraint->requireLetters = false;
        $validator->validate('12345', $constraint);
    }
    
    public function testRequireNonAlphanumericalOnFail()
    {
        $constraint = new BPSB\PasswordStrength;
        $validator = new BPSB\PasswordStrengthValidator;
        $mockContext = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        $validator->initialize($mockContext);

        $mockContext->expects($this->once())
            ->method('addViolation')
            ->with($this->equalTo($constraint->missingNonAlphanumericMessage));
        
        $constraint->requireNonAlphanumeric = true;
        $constraint->requireLetters = false;
        $validator->validate('12345', $constraint);
    }

    public function testRequireNonAlphanumericalOnSuccess()
    {
        $constraint = new BPSB\PasswordStrength;
        $validator = new BPSB\PasswordStrengthValidator;
        $mockContext = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        $validator->initialize($mockContext);

        $mockContext->expects($this->never())
            ->method('addViolation');
        
        $constraint->requireNonAlphanumeric = true;
        $constraint->requireLetters = false;
        $validator->validate('1 2345', $constraint);
    }
    

}
