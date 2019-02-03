<?php

namespace App\Http\Controllers\Theme;

use Illuminate\Routing\Controller;

class SwitchThemeController extends Controller
{
    protected $defaultTheme;

    const AVAILABLE_THEMES = [
        'blue' => 'Blue',
        'blue-light' => 'Blue Light',
        'black' => 'Dark',
        'black-light' => 'Light',
        'purple' => 'Purple',
        'purple-light' => 'Purple Light',
    ];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->defaultTheme = config('adminlte.skin', 'blue');
    }

    public function switchTheme(string $theme = null)
    {
        if (!in_array($theme, array_keys(self::AVAILABLE_THEMES))) {
            $theme = $this->defaultTheme;
        }
        $backUrl = redirect()->back()->getTargetUrl();
        $cookie = cookie()->forever(config('app.theme.key', 'theme'), $theme);

        return redirect($backUrl)->withCookie($cookie);
    }
}
