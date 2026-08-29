<?php

namespace App\Http\Controllers;

use App\Services\CalculateurPrix;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;

class CalculateurController extends Controller
{
    public function prixTtc(Request $request, CalculateurPrix $calculateur): JsonResponse
    {
        $validated = $request->validate([
            'prix_ht' => 'required|numeric',
            'taux_taxe' => 'required|numeric',
        ]);

        try {
            $prixTtc = $calculateur->calculerAvecTaxe($validated['prix_ht'], $validated['taux_taxe']);
        } catch (InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json(['prix_ttc' => $prixTtc]);
    }

    public function appliquerRemise(Request $request, CalculateurPrix $calculateur): JsonResponse
    {
        $validated = $request->validate([
            'prix' => 'required|numeric',
            'remise_pourcentage' => 'required|numeric',
        ]);

        try {
            $prixRemise = $calculateur->appliquerRemise($validated['prix'], $validated['remise_pourcentage']);
        } catch (InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json(['prix_remise' => $prixRemise]);
    }

    public function respecteSeuilMinimum(Request $request, CalculateurPrix $calculateur): JsonResponse
    {
        $validated = $request->validate([
            'prix' => 'required|numeric',
            'seuil_minimum' => 'required|numeric',
        ]);

        try {
            $respecteSeuilMinimum = $calculateur->respecteSeuilMinimum($validated['prix'], $validated['seuil_minimum']);
        } catch (InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json(['respecte_seuil_minimum' => $respecteSeuilMinimum]);
    }
}
