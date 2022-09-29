<?php
declare(strict_types=1);

namespace App\Presenters;

use Nette;

final class HomepagePresenter extends Nette\Application\UI\Presenter
{
    private Nette\Database\Explorer $db;

    public function __construct(Nette\Database\Explorer $db)
    {
        parent::__construct();
            $this->db = $db;
    }

    /**
     * Render default page with all articles.
     * @return void
     */
    public function renderDefault(): void
    {
        $this->template->posts = $this->db
            ->table('posts')
            ->order('created_at DESC')
            ->limit(5);
    }
}

