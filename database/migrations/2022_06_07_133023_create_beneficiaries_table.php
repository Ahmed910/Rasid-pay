<?php

use App\Models\Beneficiary;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeneficiariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string('name');
            $table->foreignUuid('country_id')->nullable()->constrained("countries")->onDelete('set null');
            $table->foreignUuid('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignUuid('recieve_option_id')->nullable()->constrained('recieve_options')->onDelete('set null');
            $table->string('nationality')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('benficiar_type', Beneficiary::TYPES);
            $table->string('iban_number')->nullable();
            $table->string('relation')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beneficiaries');
    }
}
