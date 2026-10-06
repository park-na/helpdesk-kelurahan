<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Nomor tiket
            |--------------------------------------------------------------------------
            */

            $table->string('ticket_number')
                ->nullable()
                ->unique();


            /*
            |--------------------------------------------------------------------------
            | Pelapor
            |--------------------------------------------------------------------------
            */

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Informasi perangkat
            |--------------------------------------------------------------------------
            */

            $table->string('device_type');

            $table->string('device_name');

            $table->string('inventory_code')
                ->nullable();

            $table->string('room_name');


            /*
            |--------------------------------------------------------------------------
            | Kendala
            |--------------------------------------------------------------------------
            */

            $table->text('description');

            $table->string('photo')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->string('status')
                ->default('waiting');


            /*
            |--------------------------------------------------------------------------
            | Penanganan teknisi
            |--------------------------------------------------------------------------
            */

            $table->text('repair_note')
                ->nullable();

            $table->foreignId('handled_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('completed_at')
                ->nullable();


            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | Index
            |--------------------------------------------------------------------------
            */

            $table->index('status');

            $table->index([
                'user_id',
                'status'
            ]);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};