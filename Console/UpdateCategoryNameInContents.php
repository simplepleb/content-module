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

namespace Modules\Content\Console;

use Illuminate\Console\Command;
use Modules\Content\Entities\Category;
use Modules\Content\Entities\Content;

class UpdateCategoryNameInContents extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'content:UpdateCategoryNameInContents';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the Category name in all the content.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo "\n\n UpdateCategoryNameInContents \n\n";

        // get all categories
        $categories = Category::all();

        $total_update_count = 0;

        // loop trhough the categories
        foreach ($categories as $category) {
            // update contents when find a category_id match
            $count = Content::where('category_id', $category->id)->update(['category_name' => $category->name]);

            // show total updated rows per category
            echo "\n " . $category->name . "| " . $count . " Posts Updated.";

            $total_update_count += $count;
        }

        // end note, show total updated rows in total
        echo "\n\n Total $total_update_count contents updated.";

        echo "\n\n";
    }
}
