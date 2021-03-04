<?php

/**
 * Putting this here to help remind you where this came from.
 *
 * I'll get back to improving this and adding more as time permits
 * if you need some help feel free to drop me a line.
 *
 * * Twenty-Years Experience
 * * PHP, JavaScript, Laravel, MySQL, Java, Python and so many more!
 *
 *
 * @author  Simple-Pleb <plebeian.tribune@protonmail.com>
 * @website https://www.simple-pleb.com
 * @source https://github.com/simplepleb/content-module
 *
 * @license Free to do as you please
 *
 * @since 1.0
 *
 */

namespace Modules\Content\Database\Seeders;

use Artisan;
use Auth;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Content\Entities\Category;
use Modules\Content\Entities\Content;
use Modules\Tag\Entities\Tag;

class ContentDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Auth::loginUsingId(1);

        // Disable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        /*
         * Contents Seed
         * ------------------
         */
        DB::table('contents')->truncate();
        echo "Truncate: contents \n";

        // Populate the pivot table
        Content::factory()
                ->has(Tag::factory()->count(rand(1, 5)))
                ->count(25)
                ->create();
        echo " Insert: contents \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
