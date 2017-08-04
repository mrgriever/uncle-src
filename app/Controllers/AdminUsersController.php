<?php namespace Uncle\Controllers;

use Uncle\Models\AdminUsers;

class AdminUsersController extends BaseController
{
    public function index()
    {
        $adminUsers = AdminUsers::find([
            'columns' => 'id,first_name,last_name,email,user_id,facebook_id,deleted,created,modified',
        ]);
        return ['admin_users' => $adminUsers];
    }
}
