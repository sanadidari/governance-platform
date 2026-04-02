<?php

namespace App\Filament\Resources\HuissierResource\Pages;

use App\Filament\Resources\HuissierResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHuissiers extends ListRecords
{
    protected static string $resource = HuissierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('import')
                ->label('استيراد (CSV)')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('success')
                ->form([
                    \Filament\Forms\Components\FileUpload::make('file')
                        ->label('ملف CSV')
                        ->acceptedFileTypes(['text/csv', 'text/plain', 'application/vnd.ms-excel'])
                        ->disk('public')
                        ->storeFiles(true)
                        ->required(),
                ])
                ->action(function (array $data) {
                    $file = public_path('storage/' . $data['file']);
                    if (!file_exists($file)) {
                        \Filament\Notifications\Notification::make()
                            ->title('الملف غير موجود')
                            ->danger()
                            ->send();
                        return;
                    }

                    $csvData = array_map('str_getcsv', file($file));
                    $header = array_shift($csvData); // Assume first row is header but we'll use index

                    $count = 0;
                    $errors = 0;

                    foreach ($csvData as $row) {
                        // Expected Format: Nom, Prenom, Email, Telephone, TribunalName
                        if (count($row) < 5) continue;

                        $nom = $row[0];
                        $prenom = $row[1];
                        $email = $row[2];
                        $tel = $row[3];
                        $tribunalName = $row[4];

                        // Find Tribunal
                        $tribunal = \App\Models\Tribunal::where('name', 'like', "%{$tribunalName}%")->first();
                        
                        if (!$tribunal) {
                            $errors++;
                            continue;
                        }

                        // Check if Huissier exists
                        if (\App\Models\Huissier::where('email', $email)->exists()) {
                            $errors++; // Skip duplicate emails
                            continue;
                        }

                        \App\Models\Huissier::create([
                            'nom' => $nom,
                            'prenom' => $prenom,
                            'email' => $email,
                            'telephone' => $tel,
                            'tribunal_id' => $tribunal->id,
                            'status' => 'active',
                        ]);
                        
                        $count++;
                    }

                    \Filament\Notifications\Notification::make()
                        ->title("تم استيراد $count مفوض بنجاح")
                        ->body("فشل استيراد $errors صف بسبب نقص البيانات أو عدم تطابق المحكمة.")
                        ->success()
                        ->send();
                }),
        ];
    }
}
