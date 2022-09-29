<?php
declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Database\Explorer;
use Nette\Application\UI\Form;
use Nette\Application\BadRequestException as errorMsg;

class EditPresenter extends Nette\Application\UI\Presenter
{
    private Explorer $db;

    /**
     * @param Explorer $db
     */
    public function __construct(Explorer $db)
    {
        parent::__construct();

        $this->db = $db;
    }

    /**
     * @return Form
     */
    public function createComponentPostForm(): Form
    {
        $form = new Form();

        $form->addText('title', 'Title: ')->setRequired();
        $form->addTextArea('content', 'Content:')->setRequired();
        $form->addSubmit('send', 'Save and public');
        $form->onSuccess[] = [$this, 'postFormSucceeded'];

        return $form;
    }

    /**
     * @param array $data
     * @throws Nette\Application\AbortException
     * @return void
     */
    public function postFormSucceeded(array $data): void
    {
        $id = $this->getParameter('id');

        if ($id) {
            $post = $this->db
                ->table('posts')
                ->get($id);
            $post->update($data);
        } else {
            $post = $this->db
                ->table('posts')
                ->insert($data);
        }

        $this->flashMessage("Comment was added.", 'success');
        $this->redirect('Post:show', $post->id);
    }

    /**
     * Render new page with edit form
     * @param int $id
     * @throws errorMsg
     * @return void
     */
    public function renderEdit(int $id): void
    {
        $post = $this->db
            ->table('posts')
            ->get($id);

        if (!$post) {
            $this->error('Post was not found.');
        }

        $this->getComponent('postForm')
            ->setDefaults($post->toArray());
    }
}
