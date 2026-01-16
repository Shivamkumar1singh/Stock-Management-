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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->string('product_name');
            $table->string('product_image')->nullable();
            $table->decimal('product_price', 10, 2);
            $table->decimal('gst_amount', 10, 2)->default(0);
            $table->decimal('total_price', 10, 2);
            $table->date('purchase_date');
            $table->date('manufacture_date');
            $table->enum('status', ['furnished', 'non_furnished'])
                  ->default('non_furnished');
            $table->date('furnished_date')->nullable();
            $table->text('furnished_work')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
