<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActeResource\Pages;
use App\Filament\Resources\ActeResource\RelationManagers;
use App\Models\Acte;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ActeResource extends Resource
{
    protected static ?string $model = Acte::class;

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if ($user->isHuissier()) {
            return $query->where('huissier_id', $user->huissier_id);
        }

        if ($user->isRegionalAdmin()) {
             return $query->whereHas('huissier.tribunal', function ($q) use ($user) {
                 $q->where('region_id', $user->region_id);
             });
        }

        return $query;
    }

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $modelLabel = 'إجراء';
    protected static ?string $pluralModelLabel = 'الإجراءات والملفات';
    protected static ?string $navigationLabel = 'الإجراءات والملفات';
    protected static ?string $navigationGroup = 'تتيع الملفات';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('معلومات الملف')
                    ->schema([
                        Forms\Components\TextInput::make('reference')
                            ->label('المرجع / رقم الملف')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\Select::make('type')
                            ->label('نوع الإجراء')
                            ->options([
                                'notification' => 'تبليغ (Notification)',
                                'execution' => 'تنفيذ (Exécution)',
                                'constat' => 'معاينة (Constat)',
                            ])
                            ->required(),
                        Forms\Components\DatePicker::make('date_depot')
                            ->label('تاريخ الدفع')
                            ->required()
                            ->default(now()),
                        Forms\Components\Select::make('huissier_id')
                            ->label('المفوض المكلف')
                            ->relationship('huissier', 'nom')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->default(fn () => auth()->user()->isHuissier() ? auth()->user()->huissier_id : null)
                            ->disabled(fn () => auth()->user()->isHuissier())
                            ->dehydrated() // Ensure it is sent even if disabled
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->nom} {$record->prenom}"),
                    ])->columns(2),

                Forms\Components\Section::make('تفاصيل الإجراء')
                    ->schema([
                        Forms\Components\Textarea::make('objet')
                            ->label('موضوع الإجراء')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('حالة التنفيذ')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('الحالة الحالية')
                            ->options([
                                'pending' => 'في الانتظار',
                                'in_progress' => 'في طور الإنجاز',
                                'completed' => 'منجز / تم التنفيذ',
                                'archived' => 'مؤرشف',
                            ])
                            ->required()
                            ->default('pending'),
                        Forms\Components\DatePicker::make('date_execution')
                            ->label('تاريخ الإنجاز'),
                        Forms\Components\FileUpload::make('attachments')
                            ->label('الوثائق والمرفقات')
                            ->multiple()
                            ->directory('actes_attachments')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('notes')
                            ->label('ملاحظات إضافية')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('admin_notes')
                            ->label('ملاحظات الإدارة (خاص)')
                            ->visible(fn () => auth()->user()->isNationalAdmin() || auth()->user()->isSuperAdmin())
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reference')
                    ->label('المرجع')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('النوع')
                    ->badge()
                    ->colors([
                        'primary' => 'notification',
                        'warning' => 'execution',
                        'info' => 'constat',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'notification' => 'تبليغ',
                        'execution' => 'تنفيذ',
                        'constat' => 'معاينة',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('huissier.nom')
                    ->label('المفوض')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->colors([
                        'danger' => 'pending',
                        'warning' => 'in_progress',
                        'success' => 'completed',
                        'gray' => 'archived',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'في الانتظار',
                        'in_progress' => 'في طور الإنجاز',
                        'completed' => 'منجز',
                        'archived' => 'مؤرشف',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('date_depot')
                    ->label('تاريخ الدفع')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('attachments')
                    ->label('مرفقات')
                    ->boolean()
                    ->trueIcon('heroicon-o-paper-clip')
                    ->falseIcon('')
                    ->state(fn (Acte $record): bool => !empty($record->attachments)),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('تصفية حسب النوع')
                    ->options([
                        'notification' => 'تبليغ',
                        'execution' => 'تنفيذ',
                        'constat' => 'معاينة',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->label('تصفية حسب الحالة')
                    ->options([
                        'pending' => 'في الانتظار',
                        'in_progress' => 'في طور الإنجاز',
                        'completed' => 'منجز',
                        'archived' => 'مؤرشف',
                    ]),
                Tables\Filters\SelectFilter::make('huissier')
                    ->label('تصفية حسب المفوض')
                    ->relationship('huissier', 'nom')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('print')
                    ->label('طباعة')
                    ->icon('heroicon-o-printer')
                    ->url(fn (Acte $record) => route('actes.pdf', $record))
                    ->openUrlInNewTab(),
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
            'index' => Pages\ListActes::route('/'),
            'create' => Pages\CreateActe::route('/create'),
            'edit' => Pages\EditActe::route('/{record}/edit'),
        ];
    }
}
