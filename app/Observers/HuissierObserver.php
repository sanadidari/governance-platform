<?php

namespace App\Observers;

use App\Models\Huissier;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class HuissierObserver
{
    /**
     * Handle the Huissier "created" event.
     */
    public function created(Huissier $huissier): void
    {
        // Check if user already exists (to avoid duplicates if created manually elsewhere)
        if (User::where('huissier_id', $huissier->id)->exists()) {
            return;
        }

        if ($huissier->email) {
            // Check if password was passed via transient property, otherwise generate strong one
            $plainPassword = $huissier->plain_password;
            
            if (!$plainPassword) {
                // Generate strong password: 12 chars, mixed case, numbers, symbols, uncompromised
                $plainPassword = \Illuminate\Support\Str::password(12, true, true, false, false);
            }

            $user = User::create([
                'name' => "{$huissier->nom} {$huissier->prenom}",
                'email' => $huissier->email,
                'password' => $plainPassword, // Casted to 'hashed' in User model
                'role' => 'huissier',
                'huissier_id' => $huissier->id,
                'status' => $huissier->status ?? 'active',
            ]);

            // Send Account Created Email with password
            try {
                \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\AccountCreated($user, $plainPassword));
            } catch (\Exception $e) {
                // Log error but don't fail creation
                \Illuminate\Support\Facades\Log::error('Failed to send account creation email: ' . $e->getMessage());
            }
        }
    }

    /**
     * Handle the Huissier "updated" event.
     */
    public function updated(Huissier $huissier): void
    {
        if ($huissier->isDirty('status')) {
            $user = User::where('huissier_id', $huissier->id)->first();
            if ($user) {
                // Map Huissier status to User status if needed, or direct copy if same
                // 'retired' -> 'suspended' for login purposes? Or just keep as is if User supports it.
                // Migration said: active, pending, suspended.
                // If retired, let's set to suspended or just copy it if column allows string.
                // Safest: 'active' -> 'active', everything else -> 'suspended' or 'pending'.
                
                $status = $huissier->status;
                if ($status === 'retired') {
                    $status = 'suspended'; 
                }
                
                $user->update(['status' => $status]);

                // Send Activation Email if status became active
                if ($huissier->getOriginal('status') !== 'active' && $status === 'active') {
                    \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\AccountActivated($user));
                }
            }
        }
        
        // Also sync email if changed, to avoiding confusion
        if ($huissier->isDirty('email')) {
             User::where('huissier_id', $huissier->id)->update(['email' => $huissier->email]);
        }
    }

    /**
     * Handle the Huissier "deleted" event.
     */
    public function deleted(Huissier $huissier): void
    {
        User::where('huissier_id', $huissier->id)->delete();
    }
}
