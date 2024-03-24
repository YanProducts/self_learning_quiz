<?php
// カスタムエラーの例外を投げた際のページ
namespace App\Exceptions;
use \Exception;

class CustomException extends \Exception
{
  // Exceptionをオーバーライドする必要性あり
  public function __construct($message,$code = 0, Throwable $previous = null){
    parent::__construct($message,$code,$previous);
  }

}
