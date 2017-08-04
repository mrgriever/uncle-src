<?php namespace Uncle\Models;

class AdminUsers extends BaseModel
{
    public function initialize()
    {
        $this->setSource('admin_users');
        $this->skipAttributes(['id']);
    }
}
