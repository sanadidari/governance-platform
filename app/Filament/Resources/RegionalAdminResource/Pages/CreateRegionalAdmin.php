<?php

namespace App\Filament\Resources\RegionalAdminResource\Pages;

use App\Filament\Resources\RegionalAdminResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateRegionalAdmin extends CreateRecord
{
    protected static string $resource = RegionalAdminResource::class;

    protected ?string $plainPassword = null;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['role'] = 'regional_admin';
        
        $password = $data['password'] ?? null;
        if (!$password) {
             $password = \Illuminate\Support\Str::password(12, true, true, false, false);
        }
        
        $this->plainPassword = $password;
        $data['password'] = Hash::make($password);
        
        return $data;
    }

    protected function afterCreate(): void
    {
        $user = $this->getRecord();
        
        // Send Account Created Email
        try {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\AccountCreated($user, $this->plainPassword));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send account creation email to Regional Admin: ' . $e->getMessage());
            
            \Filament\Notifications\Notification::make()
                ->title('تم إنشاء الحساب ولكن فشل إرسال البريد')
                ->warning()
                ->send();
        }
    }
}
