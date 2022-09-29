<?php
declare(strict_types=1);

namespace App\Presenters;

use JetBrains\PhpStorm\NoReturn;
use Nette;
use Nette\Database\Explorer;
use Nette\Application\UI\Form;

final class PostPresenter extends Nette\Application\UI\Presenter
{
    private Explorer $db;

    /**
     * @param Explorer $db
     */
    public function __construct(Nette\Database\Explorer $db)
    {
        parent::__construct();
        $this->db = $db;
    }

    /**
     * Show article page with single article from database
     *
     * @param int $id
     * @throws Nette\Application\BadRequestException
     * @return void
     */
    public function renderShow(int $id): void
    {
        $post = $this->db
            ->table('posts')
            ->get($id);
        if (!$post) {
            $this->error('Page was not found.');
        }

        $this->template->post = $post;
        $this->template->comments = $post->related('comments')->order('created_at');
    }

    /**
     * Form for create new comment.
     *
     * @return Form
     */
    public function createComponentCommentForm(): Form
    {
        $form = new Form();
        $form->addText('name', 'Name: ')->setRequired();
        $form->addEmail('email', 'E-mail: ');
        $form->addTextArea('content', 'Comment: ')->setRequired();
        $form->addSubmit('submit', 'Send');
        $form->onSuccess[] = [$this, 'commentFormSucceeded'];

        return $form;
    }

    /**
     * Method for save new comment into database.
     *
     * @param \stdClass $data
     * @throws Nette\Application\AbortException
     * @return void
     */
    #[NoReturn] public function commentFormSucceeded(\stdClass $data):void
    {
        $postId = $this->getParameter('id');

        $this->db->table('comments')->insert([
            'post_id' => $postId,
            'name' => $data->name,
            'email' => $data->email,
            'content' => $data->content,
        ]);

        $this->flashMessage('Comment succeed', 'success');
        $this->redirect('this');
    }
}
