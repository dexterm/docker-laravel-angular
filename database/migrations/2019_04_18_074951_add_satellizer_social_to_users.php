<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSatellizerSocialToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users')) {
            // create the tblCategory table
            Schema::table('users', function (Blueprint $table) {
                //avoid using multiple columns for each social media type
                $table->string('social', 100)->unique('social_unique');	// this is used for storing google or facebookd id 
                $table->string('social_type', 50); //this is used for storing the name of the social media
                $table->string('avatar', 100)->nullable($value = true);
            });
        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        if (Schema::hasTable('users')) {
            // create the tblCategory table
            Schema::table('users', function (Blueprint $table) {
                // 1. Drop foreign key constraints
                //$table->dropForeign(['store_id']); for reference purpose onlye
                
                // 2. Drop the column
                $table->dropColumn('social');
                $table->dropColumn('social_type');
                $table->dropColumn('avatar');
            });
        }
        
    }
}
