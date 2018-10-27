<?php
namespace app\home\controller;

use think\Controller;

class Tricks extends Controller
{
    public function index()
    {
        $this->assign('meta_title', '小姐姐小姐姐');
        return $this->fetch();
    }
}
