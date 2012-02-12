<?php

namespace EdpGithub\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\Form\Form,
    ZfcUser\Service\User as UserService,
    ZfcUser\Module as ZfcUser;

class GithubController extends ActionController
{
    protected $emailForm;

    protected $userMapper;

    public function emailAction()
    {
        // @TODO: Make sure they're supposed to be here

        $form    = $this->getEmailForm();
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return array(
                'emailForm' => $form,
            );
        }

        if (!$form->isValid(($post = $request->post()->toArray()))) {
            $this->flashMessenger()->setNamespace('edpgithub-email-form')->addMessage($post);
            return $this->redirect()->toRoute('github/email'); 
        }

        // update user email
        $user = $this->zfcUserAuthentication()->getIdentity();
        $user->setEmail($post['email']);

        // @TODO Use service layer
        $this->getUserMapper()->persist($user);

        return $this->redirect()->toRoute('zfcuser');
    }
 
    /**
     * Get emailForm.
     *
     * @return emailForm
     */
    public function getEmailForm()
    {
        return $this->emailForm;
    }
 
    /**
     * Set emailForm.
     *
     * @param $emailForm the value to be set
     */
    public function setEmailForm(Form $emailForm)
    {
        $this->emailForm = $emailForm;
        $fm = $this->flashMessenger()->setNamespace('edpgithub-email-form')->getMessages();
        if (isset($fm[0])) {
            $this->emailForm->isValid($fm[0]);
        }
        return $this;
    }
 
    /**
     * Get userMapper.
     *
     * @return userMapper
     */
    public function getUserMapper()
    {
        return $this->userMapper;
    }
 
    /**
     * Set userMapper.
     *
     * @param $userMapper the value to be set
     */
    public function setUserMapper($userMapper)
    {
        $this->userMapper = $userMapper;
        return $this;
    }
}
