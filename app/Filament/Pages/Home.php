<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Home extends Page
{
    protected string $view = 'filament.pages.home';

    //bisa melihat
    public static function canAccess(): bool
    {
        return false;
    }

}
