<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TribunalResource\Pages;
use App\Filament\Resources\TribunalResource\RelationManagers;
use App\Models\Tribunal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TribunalResource extends Resource
{
    protected static ?string $model = Tribunal::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    
    protected static ?string $modelLabel = 'محكمة';
    protected static ?string $pluralModelLabel = 'المحاكم';
    protected static ?string $navigationLabel = 'المحاكم';
    protected static ?string $navigationGroup = 'الإعدادات المرجعية';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('region_id')
                    ->label('الجهة')
                    ->relationship('region', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('name')
                    ->label('اسم المحكمة')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->label('النوع')
                    ->options([
                        'TPI' => 'محكمة ابتدائية (TPI)',
                        'CA' => 'محكمة الاستئناف (CA)',
                        'TC' => 'محكمة تجارية (TC)',
                        'CAC' => 'محكمة الاستئناف التجارية (CAC)',
                        'TA' => 'محكمة إدارية (TA)',
                        'CAA' => 'محكمة الاستئناف الإدارية (CAA)',
                        'CC' => 'محكمة النقض (CC)',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('code')
                    ->label('الرمز')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('اسم المحكمة')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('النوع')
                    ->badge()
                    ->colors([
                        'primary',
                        'success' => 'TPI',
                        'warning' => 'CA',
                    ]),
                Tables\Columns\TextColumn::make('region.name')
                    ->label('الجهة')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')
                    ->label('الرمز')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('region')
                    ->label('تصفية حسب الجهة')
                    ->relationship('region', 'name'),
                Tables\Filters\SelectFilter::make('type')
                    ->label('تصفية حسب النوع')
                     ->options([
                        'TPI' => 'محكمة ابتدائية (TPI)',
                        'CA' => 'محكمة الاستئناف (CA)',
                        'TC' => 'محكمة تجارية (TC)',
                        'CAC' => 'محكمة الاستئناف التجارية (CAC)',
                        'TA' => 'محكمة إدارية (TA)',
                        'CAA' => 'محكمة الاستئناف الإدارية (CAA)',
                        'CC' => 'محكمة النقض (CC)',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTribunals::route('/'),
            'create' => Pages\CreateTribunal::route('/create'),
            'edit' => Pages\EditTribunal::route('/{record}/edit'),
        ];
    }
}
