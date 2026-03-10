<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use BackedEnum;

class Help extends Page
{
    protected string $view = 'filament.pages.help';

    protected static ?int $navigationSort = 100;
    protected static ?string $navigationLabel = 'Help';

    protected static ?string $modelLabel = 'Help';
    protected static ?string $pluralModelLabel = 'Help';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQuestionMarkCircle;
}
