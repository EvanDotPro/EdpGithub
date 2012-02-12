<?php

namespace EdpGithub\Form;

use ZfcBase\Form\ProvidesEventsForm;

class EmailAddress extends ProvidesEventsForm
{
    protected $emailValidator;

    public function initLate()
    {
        $this->setMethod('post');

        $this->addElement('text', 'email', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                'EmailAddress',
                $this->emailValidator,
            ),
            'required'   => true,
            'label'      => 'Email',
            'order'      => 200,
        ));

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'order'    => 1000,
        ));

        $this->addElement('hash', 'csrf', array(
            'ignore'     => true,
            'decorators' => array('ViewHelper'),
            'order'      => -100,
        ));
    }

    public function setEmailValidator($emailValidator)
    {
        $this->emailValidator = $emailValidator;
        $this->initLate();
        return;
    }

}
