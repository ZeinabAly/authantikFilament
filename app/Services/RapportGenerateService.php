<?php

namespace App\Services;

use PDF;
use App\Models\RapportJournalier;

class RapportGenerateService
{
    public function rapportJournalier(RapportJournalier $rapport){
        $rapport = RapportJournalier::findOrFail($rapport->id);

        $pdf = Pdf::loadView('documents.rapport', compact('rapport'));

        $nomFichier = 'rapport-journalier-' . $rapport->date . '.pdf';

        return $pdf->download($nomFichier);
    }
}