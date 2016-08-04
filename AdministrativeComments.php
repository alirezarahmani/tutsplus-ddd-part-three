<?php
/**
 * Created by PhpStorm.
 * User: alireza
 * Date: 7/25/16
 * Time: 3:06 PM
 */
namespace App\web\one\Domain\Comment;

use App\web\one\Domain\Interactions\Core\Model\Entities\Pages;
use App\web\one\Infrastructure\Repositories\Database\DoctrineORM\User\DoctrineCommentRepository;
use App\web\one\Infrastructure\Repositories\Database\DoctrineORM\Interactions\DoctrinePagesRepository;
use App\web\one\Domain\User\Comments;
use Assert\Assertion;

class AdministrativeComments implements CommentTypeFactoryInterface
{

    private $page;
    private $comments;
    private $parentId;
    private $privilege;
    public  $DoctrineCommentRepository = DoctrineCommentRepository::class;
    public  $DoctrineRepository        = DoctrinePagesRepository::class;

    public function __construct(Pages $page, $comment, $parentId)
    {
        $this->page     = $page;
        $this->comments = $comment;
        $this->parentId = $parentId;
        $this->privilege= new Athurization(\Auth::gaurd('admin')->user());
        
    }

    public function confectionner()
    {
        $action = $this->comments['action'];
        Assertion::notNull($this->comments = $this->DoctrineCommentRepository->findOneBy(['commentId'=>$this->comments['id']]),'no Valid comment Id');
        $this->$action;
        return true;
    }

    public function approve()
    {
        $this->privilege->isAuthorize(__METHOD__);
        $this->DoctrineCommentRepository->approve($this->comments,\Auth::gaurd('admin')->user());
    }

    public function reject()
    {
        $this->privilege->isAuthorize(__METHOD__);
        $this->DoctrineCommentRepository->reject($this->comments,\Auth::gaurd('admin')->user());
    }

    public function delete()
    {
        $this->privilege->isAuthorize(__METHOD__);
        $this->DoctrineCommentRepository->delete($this->comments,\Auth::gaurd('admin')->user());
    }

    //...
}