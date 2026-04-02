<?php

namespace App\Filament\Pages\Auth;

use App\Models\Huissier;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Component;
use Filament\Pages\Auth\Register as BaseRegister;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;

class RegisterHuissier extends BaseRegister
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        
                        \Filament\Forms\Components\Select::make('role_selection')
                            ->label('نوع الحساب')
                            ->options([
                                'huissier' => 'مفوض قضائي',
                                'regional_admin' => 'مسؤول جهوي (رئيس المجلس الجهوي)',
                            ])
                            ->required()
                            ->reactive()
                            ->default('huissier'),

                        // Huissier Fields
                        \Filament\Forms\Components\Select::make('tribunal_id')
                            ->label('المحكمة التابع لها')
                            ->options(\App\Models\Tribunal::all()->pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->visible(fn (\Filament\Forms\Get $get) => $get('role_selection') === 'huissier'),

                        \Filament\Forms\Components\TextInput::make('professional_code')
                            ->label('الرمز المهني')
                            ->required()
                            ->visible(fn (\Filament\Forms\Get $get) => $get('role_selection') === 'huissier'),

                        \Filament\Forms\Components\TextInput::make('office_address')
                            ->label('عنوان المكتب')
                            ->required()
                            ->visible(fn (\Filament\Forms\Get $get) => $get('role_selection') === 'huissier'),

                        // Regional Admin Fields
                        \Filament\Forms\Components\Select::make('region_id')
                            ->label('الجهة (الدائرة الاستئنافية)')
                            ->options(\App\Models\Region::all()->pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->visible(fn (\Filament\Forms\Get $get) => $get('role_selection') === 'regional_admin'),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function handleRegistration(array $data): Model
    {
        $role = $data['role_selection'];
        
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $role,
            'region_id' => $role === 'regional_admin' ? $data['region_id'] : null,
            'status' => 'pending', // Pending approval
        ]);

        if ($role === 'huissier') {
            // Create Huissier Profile
            $huissier = Huissier::create([
                'nom' => explode(' ', $data['name'])[0],
                'prenom' => explode(' ', $data['name'], 2)[1] ?? '',
                'email' => $data['email'],
                'telephone' => $data['telephone'],
                'tribunal_id' => $data['tribunal_id'],
                'adresse' => $data['office_address'],
                'status' => 'pending',
            ]);

            $user->huissier_id = $huissier->id;
            $user->save();
        }

        return $user;
    }
}
