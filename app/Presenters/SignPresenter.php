<?php
declare(strict_types=1);

use Nette\Application\UI\Form;

final class SignPresenter extends Nette\Application\UI\Presenter
{
    /**
     * Starting form, for Sign in
     * @return Form
     */
    public function createComponentSignInForm(): Form
    {
        $form = new Form();

        $form->addText('username', 'Username')->setRequired('Please fill the username field.');
        $form->addPassword('password', 'Password')->setRequired('Please fill the password field.');
        $form->addSubmit('send', 'Sign in');
        $form->onSuccess[] = [$this, 'signInFormSucceed'];

        return $form;
    }

    public function signInFormSucceeded(Form $form, \stdClass $data): void
    {
        try {
            $this->getUser()->login($data->username, $data->password);
            $this->redirect('Homepage:');

        } catch (Nette\Security\AuthenticationException $e) {
            $form->addError('Nesprávné přihlašovací jméno nebo heslo.');
        }
    }

    public function actionOut(): void
    {
        $this->getUser()->logout();
        $this->flashMessage('Odhlášení bylo úspěšné.');
        $this->redirect('Homepage:');
    }


}