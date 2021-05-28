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
 * @license MIT For Premium Clients
 *
 * @since 1.0
 *
 */

namespace Modules\Content\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Modules\Thememanager\Entities\SiteTheme;
use Theme;

class CategoriesController extends Controller
{
    public function __construct()
    {
        // Page Title
        $this->module_title = 'Categories';

        // module name
        $this->module_name = 'categories';

        // directory path of the module
        $this->module_path = 'categories';

        // module icon
        $this->module_icon = 'fas fa-sitemap';

        // module model name, path
        $this->module_model = "Modules\Content\Entities\Category";
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $$module_name = $module_model::with(['contents'])->paginate();

        return view(
            "content::frontend.$module_path.index",
            compact('module_title', 'module_name', "$module_name", 'module_path', 'module_icon', 'module_action', 'module_name_singular')
        );
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $id = decode_id($id);

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Show';

        $$module_name_singular = $module_model::findOrFail($id);
        if( \Module::has('Tag') && \Module::has('Comment') ) {
            $contents = $$module_name_singular->contents()->with('category', 'tags', 'comments')->paginate();
        }
        else{
            $contents = $$module_name_singular->contents()->with('category')->paginate();
        }


        if( \Module::has('Thememanager')) {
            $view_file = 'content_list';

            $theme = SiteTheme::where('active', 1)->first();
            // dd( $theme );
            if( $theme ) {

                if(!empty($theme->page_styles)) {
                    // dd( $theme->page_styles );
                    $page_types = json_decode($theme->page_styles);
                    // dd( $page_types );
                    $blade_file = isset($page_types->posts) ? $page_types->posts : 'posts';
                    $blade_path = public_path('themes/'.$theme->slug.'/views/'.$blade_file.'.blade.php');
                   //  dd( $blade_path );
                    if( file_exists($blade_path)) {
                        $view_file = $blade_file;

                        Theme::uses($theme->slug); // oreo, huckbee

                        return Theme::view($view_file, compact('module_title', 'module_name', 'module_icon', 'module_action', 'module_name_singular', "$module_name_singular"));
                    }


                }
            }

        }

        return view(
            "content::frontend.$module_name.show",
            compact('module_title', 'module_name', 'module_icon', 'module_action', 'module_name_singular', "$module_name_singular", 'contents')
        );
    }
}
