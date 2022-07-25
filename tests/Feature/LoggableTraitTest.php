<?php

namespace Tests\Feature;

use App\Models\ActivityLog;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoggableTraitTest extends TestCase
{
    // use RefreshDatabase;

    private $contact;

    public function setUp(): void
    {
        parent::setUp();

        $this->contact = Contact::create([
            'fullname' => 'Mohamed',
            'email' => 'mohamed@yahoo.com',
            'phone' => '0100200300',
            'content' => 'tes message',
        ]);

        $this->contact->refresh();
    }
    /**
     * @test
     */
    public function create_new_contact()
    {
        //given

        $this->assertEquals('created', $this->contact->activity->first()->action_type);
        $this->assertEquals(Contact::PENDING, $this->contact->message_status);
    }

    public function  test_if_show_message_convert_shown()
    {
        // send reqeust to show
        // ensure status => shown
        // ensure action_type => shown
        $admin = User::first();


        // http requests , json
        $this->actingAs($admin);
        $reposnse = $this->getJson(route('contacts.show', $this->contact->id));
        $reposnse->assertStatus(200)
            ->assertJsonPath(
                'data.contact.message_status',
                Contact::WAITING,
            )
            ->assertJsonPath('data.activity.0.type', ActivityLog::SHOWN);
    }

    public function test_if_show_message_convert_reply()
    {
        $admin = User::first();

        $this->actingAs($admin);
        $reposnse = $this->postJson(route('contacts.reply', [
            'contact_id' => $this->contact->id,
            'reply' => 'Hello World',
        ]));

        $reposnse->assertStatus(201)
            ->assertJsonPath(
                'data.contact.message_status',
                Contact::REPLIED,
            )
            ->assertJsonPath('data.contact.activity.0.type', Contact::REPLIED);
    }
}
