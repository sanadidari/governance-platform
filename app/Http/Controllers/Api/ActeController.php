<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Acte;
use Illuminate\Http\Request;

class ActeController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Should normally be scoped to the logged-in Huissier
        $query = Acte::query();

        if ($user->huissier_id) {
            $query->where('huissier_id', $user->huissier_id);
        }

        // Simple filtering
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        return response()->json($query->latest()->get());
    }

    public function updateStatus(Request $request, Acte $acte)
    {
        // Ensure the act belongs to the user (if huissier)
        if ($request->user()->huissier_id && $acte->huissier_id !== $request->user()->huissier_id) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
            'date_execution' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $acte->update([
            'status' => $validated['status'],
            'date_execution' => $validated['date_execution'] ?? $acte->date_execution,
            'notes' => $validated['notes'] ?? $acte->notes,
        ]);

        return response()->json(['message' => 'Statut mis à jour.', 'acte' => $acte]);
    }
}
