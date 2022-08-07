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
            $table->enum('type', BankBranch::TYPES);
            $table->string('code');
            $table->string('site', 500);
            $table->decimal('transfer_amount');
            $table->string('commercial_record')->nullable();
            $table->string('tax_number')->nullable();
            $table->string('service_customer')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignUuid('bank_id')->constrained('banks')->cascadeOnDelete()->cascadeOnUpdate();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('bank_branch_translations', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("name");
            $table->string("locale")->index();
            $table->foreignUuid("bank_branch_id")->constrained('bank_branches')->onDelete('cascade');
            $table->unique(["bank_branch_id", "locale"]);
        });
    }

    public function down()
    {
        Schema::dropIfExists("bank_branch_translations");
        Schema::dropIfExists('bank_branches');
    }
}
