<?php
/**
 * Created by PhpStorm.
 * User: alireza
 * Date: 7/25/16
 * Time: 12:38 PM
 */
namespace App\web\one\Domain\Comment;


use App\web\one\Domain\User\Comments\Model\Entities\Comments;
use App\web\one\Infrastructure\Repositories\Database\DoctrineORM\User\DoctrineCommentRepository;
use App\web\one\Infrastructure\Repositories\Database\DoctrineORM\Interactions\DoctrinePagesRepository;

use Assert\Assertion;

class PageAggregate
{

    public $Pages;
    public $pageResult;
    public $parentId          = null;
    public $comments;
    public $DoctrineRepository= DoctrinePagesRepository::class;

    public function __construct($id, $comments = null, $administrative = null)
    {
        $this->DoctrineRepository = \App::make($this->DoctrineRepository);
        Assertion::notNull($this->pageResult = $this->DoctrineRepository->findOneBy(['pageId' => $id]), 'sorry the valid page id is required here');
        $commentFacory = new Commentfactory($this->pageResult, $comments);
        return $commentFacory->choisir($administrative);
    }



}