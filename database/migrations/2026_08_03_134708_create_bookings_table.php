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
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        $table->string('booking_no')->unique();
        $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('provider_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
        $table->date('booking_date');
        $table->time('booking_time');
        $table->string('address');
        $table->decimal('amount', 10, 2);
        $table->string('status')->default('pending');
        $table->string('payment_status')->default('unpaid');
        $table->text('remarks')->nullable();
        $table->foreignId('cancelled_by')->nullable()->constrained('users');
        $table->timestamp('cancelled_at')->nullable();
        $table->text('cancellation_reason')->nullable();
        $table->timestamp('completed_at')->nullable();
        $table->timestamps();
        $table->softDeletes();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
