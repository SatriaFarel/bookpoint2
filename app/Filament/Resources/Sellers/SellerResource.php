<?php

namespace App\Filament\Resources\Sellers;

use App\Filament\Resources\Sellers\Pages\CreateSeller;
use App\Filament\Resources\Sellers\Pages\EditSeller;
use App\Filament\Resources\Sellers\Pages\ListSellers;
use App\Filament\Resources\Sellers\Pages\ViewSeller;
use App\Filament\Resources\Sellers\Schemas\SellerForm;
use App\Filament\Resources\Sellers\Schemas\SellerInfolist;
use App\Filament\Resources\Sellers\Tables\SellersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SellerResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?int $navigationSort = 1;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'Seller';
    protected static ?string $pluralModelLabel = 'Sellers';
    protected static ?string $navigationLabel = 'Sellers';

    protected static string|\UnitEnum|null $navigationGroup = 'Manajemen User';

    /* ================= FORM ================= */

    public static function form(Schema $schema): Schema
    {
        return SellerForm::configure($schema);
    }

    /* ================= INFOLIST ================= */

    public static function infolist(Schema $schema): Schema
    {
        return SellerInfolist::configure($schema);
    }

    /* ================= TABLE ================= */

    public static function table(Table $table): Table
    {
        return SellersTable::configure($table);
    }

    /* ================= RELATIONS ================= */

    public static function getRelations(): array
    {
        return [];
    }

    /* ================= AUTHORIZATION ================= */

    public static function canAccess(): bool
    {
        return false;
    }

    // public static function canCreate(): bool
    // {
    //     return auth()->user()?->role === 'admin';
    // }

    // public static function canEdit($record): bool
    // {
    //     return auth()->user()?->role === 'admin';
    // }

    // public static function canDelete($record): bool
    // {
    //     return auth()->user()?->role === 'admin';
    // }

    /* ================= QUERY ================= */

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->seller();
    }


    /* ================= PAGES ================= */

    public static function getPages(): array
    {
        return [
            'index' => ListSellers::route('/'),
            'create' => CreateSeller::route('/create'),
            'view' => ViewSeller::route('/{record}'),
            'edit' => EditSeller::route('/{record}/edit'),
        ];
    }

    /* ================= RECORD BINDING ================= */

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}