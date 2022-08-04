<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class userLogTest extends TestCase
{
    public function test_update_user()
    {
        $admin = User::Where('user_type', 'admin')->first();
        $super = User::Where('user_type', 'superadmin')->first();

        $this->actingAs($super);
        $response = $this->putJson(
            route('admins.update', ['admin' => $admin->id]),
            [
                'is_login_code' => $admin->is_login_code,
                'login_id' =>  $admin->login_id,
                'ban_from' =>  $admin->ban_from,
                'ban_to' =>  $admin->ban_to,
                'department_id' =>  $admin->department->id,
                'rasid_job_id' =>  $admin->rasidJob->id,
                'fullname' =>  $admin->fullname,
                'email' =>  $admin->email,
                'phone' => '966555444465',
                'permission_list' => [
                    '1' => '01dc4fe6-939a-4955-a55a-b80ac567934e'
                ],
                'group_list' => [
                    "0" => '94355412-13e8-11ed-9678-f01faf1ab4e3'
                ],
                'password_change' => 0,
                'ban_status' => 'permanent'
            ]
        );

        $response->assertStatus(200);
    }
}
