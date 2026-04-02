<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ComplaintResource\Pages;
use App\Filament\Resources\ComplaintResource\RelationManagers;
use App\Models\Complaint;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ComplaintResource extends Resource
{
    protected static ?string $model = Complaint::class;

    protected static ?string $modelLabel = 'شكاية / تبليغ';
    protected static ?string $pluralModelLabel = 'الشكايات والتبليغات';
    protected static ?string $navigationLabel = 'الشكايات والتبليغات';
    protected static ?string $navigationGroup = 'الحماية المهنية';

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if ($user->isHuissier()) {
            return $query->where('huissier_id', $user->huissier_id);
        }

        // National/Super Admin see all
        return $query;
    }
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('subject')
                    ->label('موضوع الشكاية / التبليغ')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                
                Forms\Components\RichEditor::make('description')
                    ->label('تفاصيل الشكاية')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\Select::make('priority')
                    ->label('درجة الاستعجال')
                    ->options([
                        'low' => 'عادية',
                        'medium' => 'متوسطة',
                        'high' => 'عاجلة',
                    ])
                    ->default('medium')
                    ->required(),

                Forms\Components\FileUpload::make('attachments')
                    ->label('المرفقات (PDF / صور)')
                    ->multiple()
                    ->directory('complaints_attachments')
                    ->columnSpanFull(),

                Forms\Components\Select::make('status')
                    ->label('حالة المعالجة')
                    ->options([
                        'submitted' => 'تم الإرسال',
                        'processing' => 'قيد المعالجة',
                        'resolved' => 'تم الحل',
                        'rejected' => 'مرفوضة',
                    ])
                    ->default('submitted')
                    ->visible(fn () => auth()->user()->isNationalAdmin() || auth()->user()->isSuperAdmin()),

                Forms\Components\Textarea::make('admin_notes')
                    ->label('ملاحظات الإدارة')
                    ->visible(fn () => auth()->user()->isNationalAdmin() || auth()->user()->isSuperAdmin())
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإرسال')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subject')
                    ->label('الموضوع')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('huissier.nom') // Show who submitted if Admin
                    ->label('المرسل')
                    ->visible(fn () => auth()->user()->isNationalAdmin() || auth()->user()->isSuperAdmin())
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->colors([
                        'gray' => 'submitted',
                        'warning' => 'processing',
                        'success' => 'resolved',
                        'danger' => 'rejected',
                    ]),
                Tables\Columns\TextColumn::make('priority')
                    ->searchable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListComplaints::route('/'),
            'create' => Pages\CreateComplaint::route('/create'),
            'edit' => Pages\EditComplaint::route('/{record}/edit'),
        ];
    }
}
