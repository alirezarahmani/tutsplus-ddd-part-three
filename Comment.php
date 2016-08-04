<?php
/**
 * Created by PhpStorm.
 * User: alireza
 * Date: 7/25/16
 * Time: 3:06 PM
 */
namespace App\web\one\Domain\Comment;

use App\web\one\Domain\User\Comments\Model\Entities\Comments;
use App\web\one\Infrastructure\Repositories\Database\DoctrineORM\User\DoctrineCommentRepository;
use App\web\one\Infrastructure\Repositories\Database\DoctrineORM\Interactions\DoctrinePagesRepository;
use App\web\one\Domain\Interactions\Core\Model\Entities\Pages;
use App\web\one\Application\Factory\Request\RequestFactory;
use Assert\Assertion;

class Comment implements CommentTypeFactoryInterface
{
    private $page;
    private $comments;
    public  $DoctrineCommentRepository = DoctrineCommentRepository::class;
    public  $DoctrineRepository        = DoctrinePagesRepository::class;
    
    public function __construct(Pages $page, $comment)
    {
        $this->page                      = $page;
        $this->comments                  = $comment;
        $this->DoctrineCommentRepository = \App::make($this->DoctrineCommentRepository);
        $this->DoctrineRepository        = \App::make($this->DoctrineRepository);

    }

    public function confectionner()
    {
        if (is_array($this->comments))
        {
            \Request::replace($this->comments['data']);
            \App::make(RequestFactory::class);

            $this->addComments();
        }
        elseif (is_null($this->comments))
        {
            return $this->retrieveComments();
        }
        elseif (is_int($this->comments))
        {
            $this->deleteComment();
        }
        return true;

    }

    private function addComments()
    {
        if (isset($this->comments['id']) && !is_null($this->comments['object'] = $this->DoctrineCommentRepository->findOneBy(['commentId' => $this->comments['id']])))
            return $this->editComment();

        $this->comments = $this->CommentObjectMapper(new Comments(), $this->comments['data']);
        $this->page->addComments($this->comments);
        $this->DoctrineRepository->AddComments($this->page);
    }

    private function editComment()
    {
        $comment = $this->CommentObjectMapper($this->comments['object'], $this->comments['data']);
        $this->page->addComments($comment);
        $this->DoctrineRepository->AddComments($this->page);
    }

    private function deleteComment()
    {
        $this->DoctrineCommentRepository->delComments($this->comments);
    }

    private function retrieveComments()
    {
        return $this->page->getPageComment();
    }

    //...
    
}