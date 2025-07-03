<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\Depense;
use App\Models\RapportJournalier;
use Filament\Notifications\Notification;

class GenererRapportJournalier extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:generer-rapport-journalier';
    protected $signature = 'rapport:journalier';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crée un rapport journalier avec les ventes et dépenses du jour ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->toDateString();

        if(RapportJournalier::where('date', $today)->exists()){
            $this->info('Le rapport pour aujourd’hui existe déjà.');
            return ;
        }

        $totalVentes = Order::whereDate('created_at', $today)->sum('total');
        $totalDepenses = Depense::whereDate('date', $today)->sum('montant');
        $benefice = $totalVentes - $totalDepenses;

        RapportJournalier::create([
            'date' => $today,
            'total_ventes' => $totalVentes,
            'total_depenses' => $totalDepenses,
            'benefice' => $benefice,
        ]);

        $this->info('Rapport journalier créé avec succès.');
    }
}
