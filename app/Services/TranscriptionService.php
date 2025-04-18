<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class TranscriptionService
{
    public function generate(string $filePath): ?string
    {
        set_time_limit(300); // allonge le temps d'exécution
    
        $fullPath = storage_path('app/public/' . $filePath);
    
        if (!file_exists($fullPath)) {
            Log::error("❌ Fichier introuvable pour transcription : " . $fullPath);
            return null;
        }
    
        Log::info("✅ Fichier trouvé pour transcription : " . $fullPath);
    
        // 📁 Dossier de sortie
        $outputDir = storage_path('app/transcriptions');

        // ✅ Créer le dossier s'il n'existe pas
        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0775, true);
        }

        $python = base_path('.venv/Scripts/python.exe');
        $command = "\"$python\" -m whisper \"$fullPath\" --model small --language en --output_dir \"$outputDir\" 2>&1";
    
        $output = shell_exec($command);
    
        // 🧼 Supprimer les lignes de warning
        $filteredOutput = collect(explode("\n", $output))
            ->reject(fn($line) => str_contains($line, 'UserWarning') || str_contains($line, 'warnings.warn'))
            ->implode("\n");
    
        Log::info("Sortie de Whisper (filtrée) : " . $filteredOutput);
    
        return $filteredOutput;
    }
    
    
}
