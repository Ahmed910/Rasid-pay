<?php

use App\Models\Contact;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    public function up()
    {

        Schema::create('contacts', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid("user_id")->nullable()->constrained()->nullOnDelete();
            $table->string("fullname")->nullable();
            $table->string("email")->nullable();
            $table->string("phone")->nullable();
            $table->string("title")->nullable();
            $table->longText("content");
            $table->text("notes")->nullable();

            $table->enum('message_source', ['website', 'app',])->nullable()->default('app');;
            $table->enum('message_status', Contact::MESSAGE_STATUS)->default(Contact::PENDING);
            $table->foreignUuid("admin_id")->nullable()->constrained('users')->nullOnDelete();

            $table->softDeletes();

            $table->timestamp("read_at")->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
