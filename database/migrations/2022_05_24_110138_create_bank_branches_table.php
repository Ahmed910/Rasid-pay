<?php

use App\Models\BankBranch\BankBranch;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankBranchesTable extends Migration
{
    public function up()
    {
        Schema::create('bank_branches', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string('name');
            $table->enum('type', BankBranch::TYPES);
            $table->string('code');
            $table->string('site');
            $table->decimal('transfer_amount');
            $table->string('commercial_record')->nullable();
            $table->string('tax_number')->nullable();
            $table->string('service_customer')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('bank_id')->constrained('banks')->cascadeOnDelete()->cascadeOnUpdate();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bank_branches');
    }
}
