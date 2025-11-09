<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('address')->nullable()->after('role');
        $table->string('city')->nullable()->after('address');
        $table->string('province')->nullable()->after('city');
        $table->string('postal_code')->nullable()->after('province');
        $table->string('department')->nullable()->after('postal_code');
        $table->string('address_type')->nullable()->after('department'); // hogar o laboral
        $table->text('delivery_instructions')->nullable()->after('address_type');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
