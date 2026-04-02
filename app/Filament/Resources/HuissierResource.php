<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HuissierResource\Pages;
use App\Filament\Resources\HuissierResource\RelationManagers;
use App\Models\Huissier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HuissierResource extends Resource
{
    protected static ?string $model = Huissier::class;

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if ($user->isHuissier()) {
            return $query->where('id', $user->huissier_id);
        }

        if ($user->isRegionalAdmin()) {
             return $query->whereHas('tribunal', function ($q) use ($user) {
                 $q->where('region_id', $user->region_id);
             });
        }

        return $query;
    }

    protected static ?string $navigationIcon = 'heroicon-o-users';
    
    protected static ?string $modelLabel = 'مفوض قضائي';
    protected static ?string $pluralModelLabel = 'المفوضون القضائيون';
    protected static ?string $navigationLabel = 'المفوضون القضائيون';
    protected static ?string $navigationGroup = 'إدارة الموارد';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('معلومات المفوض')
                    ->schema([
                        Forms\Components\Select::make('tribunal_id')
                            ->label('المحكمة التابع لها')
                            ->relationship('tribunal', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('nom')
                            ->label('الاسم العائلي')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('prenom')
                            ->label('الاسم الشخصي')
                            ->required()
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make('معلومات الاتصال')
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->label('البريد الإلكتروني')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('password')
                            ->label('كلمة المرور')
                            ->password()
                            ->revealable()
                            ->dehydrated(false) // Handle manually
                            ->helperText('اتركه فارغًا لتوليد كلمة مرور تلقائية (8+ أحرف، كبير، صغير، رقم، رمز)')
                            ->visible(fn ($livewire) => $livewire instanceof Pages\CreateHuissier)
                            ->minLength(8)
                            ->regex('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/')
                            ->validationMessages([
                                'regex' => 'يجب أن تحتوي كلمة المرور على حرف كبير، حرف صغير، رقم، ورمز خاص (مثل @, #, _, -).',
                            ]),
                        Forms\Components\TextInput::make('telephone')
                            ->label('رقم الهاتف')
                            ->tel()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('adresse')
                            ->label('العنوان المهني')
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('الحالة')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('الحالة')
                            ->options([
                                'active' => 'نشط',
                                'pending' => 'قيد الانتظار',
                                'suspended' => 'موقف',
                                'retired' => 'متقاعد',
                            ])
                            ->required()
                            ->default('active'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nom')
                    ->label('الاسم العائلي')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('prenom')
                    ->label('الاسم الشخصي')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tribunal.name')
                    ->label('المحكمة')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('telephone')
                    ->label('الهاتف')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->colors([
                        'success' => 'active',
                        'warning' => 'pending',
                        'danger' => 'suspended',
                        'gray' => 'retired',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => 'نشط',
                        'pending' => 'قيد الانتظار',
                        'suspended' => 'موقف',
                        'retired' => 'متقاعد',
                        default => $state,
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tribunal')
                    ->label('تصفية حسب المحكمة')
                    ->relationship('tribunal', 'name'),
                Tables\Filters\SelectFilter::make('status')
                     ->label('تصفية حسب الحالة')
                     ->options([
                        'active' => 'نشط',
                        'pending' => 'قيد الانتظار',
                        'suspended' => 'موقف',
                        'retired' => 'متقاعد',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('تفعيل الحساب')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Huissier $record) => $record->status === 'pending')
                    ->action(function (Huissier $record) {
                        $record->update(['status' => 'active']);
                        
                        // Notify User if linked
                        // Notification logic can be added here
                        
                        \Filament\Notifications\Notification::make()
                            ->title('تم تفعيل الحساب بنجاح')
                            ->success()
                            ->send();
                    }),
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
            'index' => Pages\ListHuissiers::route('/'),
            'create' => Pages\CreateHuissier::route('/create'),
            'edit' => Pages\EditHuissier::route('/{record}/edit'),
        ];
    }
}
