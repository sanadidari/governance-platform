<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegionalAdminResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RegionalAdminResource extends Resource
{
    protected static ?string $model = User::class;
    
    protected static ?string $modelLabel = 'مسؤول جهوي';
    protected static ?string $pluralModelLabel = 'المسؤولون الجهويون';
    protected static ?string $navigationLabel = 'المسؤولون الجهويون';
    protected static ?string $navigationGroup = 'إدارة الموارد';
    protected static ?string $slug = 'regional-admins';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('role', 'regional_admin');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('الاسم الكامل')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->label('البريد الإلكتروني')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('password')
                    ->label('كلمة المرور')
                    ->password()
                    ->revealable()
                    ->helperText('اتركه فارغًا لتوليد كلمة مرور تلقائية (8+ أحرف، كبير، صغير، رقم، رمز)')
                    ->visible(fn ($livewire) => $livewire instanceof Pages\CreateRegionalAdmin)
                    ->minLength(8)
                    ->regex('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/')
                    ->validationMessages([
                        'regex' => 'يجب أن تحتوي كلمة المرور على حرف كبير، حرف صغير، رقم، ورمز خاص (مثل @, #, _, -).',
                    ]),
                Forms\Components\Select::make('region_id')
                    ->label('الجهة')
                    ->relationship('region', 'name')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('الحالة')
                    ->options([
                        'active' => 'نشط',
                        'pending' => 'قيد الانتظار',
                        'suspended' => 'موقف',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('الاسم'),
                Tables\Columns\TextColumn::make('email')->label('البريد الإلكتروني'),
                Tables\Columns\TextColumn::make('region.name')->label('الجهة'),
                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->colors([
                        'success' => 'active',
                        'warning' => 'pending',
                        'danger' => 'suspended',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('تفعيل الحساب')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (User $record) => $record->status === 'pending')
                    ->action(function (User $record) {
                        $record->update(['status' => 'active']);
                        \Illuminate\Support\Facades\Mail::to($record->email)->send(new \App\Mail\AccountActivated($record));
                        
                        \Filament\Notifications\Notification::make()
                            ->title('تم تفعيل الحساب وإرسال البريد')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRegionalAdmins::route('/'),
            'create' => Pages\CreateRegionalAdmin::route('/create'),
            'edit' => Pages\EditRegionalAdmin::route('/{record}/edit'),
        ];
    }
}
