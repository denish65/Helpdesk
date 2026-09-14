<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId("user_id")->constrained("users")->cascadeOnDelete();
            $table->foreignId("assigned_to")->nullable()->constarined("users")->nullOnDelete();
            $table->foreignId("category_id")->nullable()->constarined("categoris")->nullableOnDelete();
            $table->string("reference")->unique();
            $table->string("subjetc");
            $table->text("description");
            $table->enum("status",['open',"in_porgress","pending","resolved","closed"])->default("open");
            $table->enum("priority",['low','medium',"high","urgent"])->default("medium");
            $table->timestamp("resolved_at")->nullable();
            $table->timestamp("closed_at")->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['tenant_id',"status"]);
            $table->index(['tenant_id',"assigned_to"]);
            $table->index(['tenant_id',"user_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
