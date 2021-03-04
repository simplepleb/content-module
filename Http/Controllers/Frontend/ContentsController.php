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

namespace Modules\Content\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Modules\Content\Events\ContentViewed;
use Modules\Thememanager\Entities\SiteTheme;
use Theme;

class ContentsController extends Controller
{
    public function __construct()
    {
        // Page Title
        $this->module_title = 'Contents';

        // module name
        $this->module_name = 'contents';

        // directory path of the module
        $this->module_path = 'contents';

        // module icon
        $this->module_icon = 'fas fa-file-alt';

        // module model name, path
        $this->module_model = "Modules\Contents\Entities\Content";
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

        $$module_name = $module_model::latest()->with(['category', 'tags', 'comments'])->paginate();

        return view(
            "content::frontend.$module_path.index",
            compact('module_title', 'module_name', "$module_name", 'module_icon', 'module_action', 'module_name_singular')
        );
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($hashid)
    {
        $id = decode_id($hashid);

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Show';

        $meta_page_type = 'article';

        $$module_name_singular = $module_model::findOrFail($id);
// dd($$module_name_singular);
        event(new ContentViewed($$module_name_singular));
        $view_file = 'show';

        if( \Module::has('ThemeManager')) {
            $view_file = 'blank';

            $theme = SiteTheme::where('active', 1)->first();
            // dd( $theme );
            if( $theme ) {

                if(!empty($theme->page_styles)) {
                    //dd( $meta_page_type->page_styles );
                    $page_types = json_decode($theme->page_styles);
                    // dd( $page_types );
                    $view_file = $page_types->page;

                    Theme::uses('digincy'); // oreo, huckbee


                    $data['info'] = 'Hello World';

                    return Theme::view($view_file, compact('module_title', 'module_name', 'module_icon', 'module_action', 'module_name_singular', "$module_name_singular", 'meta_page_type'));
                }
            }

        }

        // dd( $view_file );
        return view(
            "content::frontend.$module_name.show",
            compact('module_title', 'module_name', 'module_icon', 'module_action', 'module_name_singular', "$module_name_singular", 'meta_page_type')
        );
    }
}
