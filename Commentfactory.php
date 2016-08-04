<?php
/**
 * Created by PhpStorm.
 * User: alireza
 * Date: 7/27/16
 * Time: 12:41 AM
 */
namespace App\web\one\Domain\Comment;
use App\web\one\Application\Factory\Request\RequestFactory;

class Commentfactory implements CommentFactoryInterface
{

    private $page    ;
    private $comment ;
    private $parentId;

    public function __construct($page , $comment =null)
    {
        $this->page    = $page;
        $this->comment = $comment;
    }

    public function choisir($administrative=null)
    {
        // TODO: Implement choisir() method.


        if (is_null($administrative))
        {
             $comment = new Comment($this->page,$this->comment);
             return  $comment->confectionner();
        }

             $comment = new AdministrativeComments($this->page,$this->comment,$this->parentId);
             return  $comment->confectionner();
    }


}