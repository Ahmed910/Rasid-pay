<?php

namespace Tests\Feature;

use App\Models\Department\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class DepartmentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_departments()
    {
        $response = $this->post("/api/v1/dashboard/departments", [
            "en" => [
                "name"        => "Mohamed",
                "description" => "Description"
            ],
            "ar" => [
                "name"        => "Mohamed",
                "description" => "Description"
            ],
            "image" => UploadedFile::fake()->image("image.png")
        ], [
            "Accept" => "Application/json",
        ]);

        $response->assertStatus(201)
            ->assertJsonCount(2, "data.translations");
    }
    public function test_validate_on_ar_departments()
    {
        $response = $this->post("/api/v1/dashboard/departments", [
            "ar" => [
                "description" => "Description"
            ],
            "image" => UploadedFile::fake()->image("image.png")
        ], [
            "Accept" => "Application/json",
        ]);

        $response->assertStatus(422)
            ->assertSeeText("fail");
    }

    public function test_show_department()
    {
        $response = Department::create([
            "en" => [
                "name"        => "Mohamed",
                "description" => "Description"
            ],
            "ar" => [
                "name"        => "Mohamed",
                "description" => "Description"
            ],
            "image" => UploadedFile::fake()->image("image.png")
        ]);

        $response = $this->get(
            "api/v1/dashboard/departments/$response->id",
            [
                "Accept" => "Application/json",
            ]
        );

        $response->assertStatus(200)
            ->assertJsonCount(2, "data.translations");
    }

    public function test_show_if_id_not_found()
    {
        $response = $this->get(
            "api/v1/dashboard/departments/1",
            ["Accept" => "Application/json"]
        );

        $response->assertStatus(404)
            ->assertSeeText("Not Found");
    }

    public function test_if_departments_has_children_cannot_delete()
    {
        $parent = Department::create([
            "en" => [
                "name"        => "Mohamed",
                "description" => "Description"
            ],
            "ar" => [
                "name"        => "Mohamed",
                "description" => "Description"
            ],
            "image" => UploadedFile::fake()->image("image.png")
        ]);

        Department::create([
            "parent_id" => $parent->id,
            "en" => [
                "name"        => "Mohamed",
                "description" => "Description"
            ],
            "ar" => [
                "name"        => "Mohamed",
                "description" => "Description"
            ],
            "image" => UploadedFile::fake()->image("image.png")
        ]);

        $response = $this->delete(
            "api/v1/dashboard/departments/$parent->id"
        );

        $response->assertStatus(401)
            ->assertSee("This item has relationships,so you cannot delete it");
    }

    public function test_if_departments_doesnot_has_children_can_delete()
    {
        $parent = Department::create([
            "en" => [
                "name"        => "Mohamed",
                "description" => "Description"
            ],
            "ar" => [
                "name"        => "Mohamed",
                "description" => "Description"
            ],
            "image" => UploadedFile::fake()->image("image.png")
        ]);

        $response = $this->delete(
            "api/v1/dashboard/departments/$parent->id"
        );

        $response->assertStatus(200)
            ->assertSee("Deleted Successfully");
    }
}
