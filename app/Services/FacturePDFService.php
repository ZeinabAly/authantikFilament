<?php

namespace App\Services;

use PDF;
use App\Models\Order;
use NumberFormatter;
use App\Models\{Product, Setting};

class FacturePDFService
{
    public function generateInvoice(Order $order)
    {
        // $formatter = new NumberFormatter("fr", NumberFormatter::SPELLOUT); //Transformer le prix en lettres
        
        $settings = Setting::first();

        $data = [
            'order' => $order,
            'items' => $order->orderItems()->with('product')->get(),
            'settings' => $settings,
        ];

        $logoPath = $settings && $settings->logo_path ? storage_path('app/public/' . $settings->logo_path) : null;

        if ($logoPath && file_exists($logoPath)) {
            $data['logo_path'] = $logoPath;
        } else {
            $data['logo_path'] = null;
        }
        

        // Generation du PDF
        $pdf = [];
        $pdf[] = PDF::loadView('documents.facture', $data)
            //->setPaper('a4', 'landscape') //a4:Indique la taille de la page et landscape:Orientation(horizontal)
            ->setPaper([0, 0, 226.77, 600]) //80mm taille d'un recu de caisse 
            ->setWarnings(false); //désactive les messages d’avertissement qui pourraient être générés lors du rendu (par exemple, des erreurs CSS)

        // Génération du reçu de cuisine
        $pdf[] = PDF::loadView('documents.recu_cuisine', $data)
        ->setPaper([0, 0, 226.77, 600]) // Largeur ~80mm (226.77pt), hauteur définie
        ->setWarnings(false);

        return $pdf;
    }

    public function saveInvoiceToFile(Order $order){
        
        // Generation du PDF
        $documents = $this->generateInvoice($order);

        // Creer un dossier s'il n'existe pas
        $directory = public_path("documents/factures");
        if(!file_exists($directory)){
            mkdir($directory, 0755, true);
        }

        //Sauvegarder les fichiers avec les noms differents
        $fileNames = [];

        // Facture
        $factureFileName = 'facture_' . $order->id . '.pdf';
        $facturePath = $directory .'/'.$factureFileName;
        $documents[0]->save($facturePath);
        $fileNames['facture'] = $facturePath;

        // Recu
        $recuFileName = 'recu_' . $order->id . '.pdf';
        $recuPath = $directory .'/'.$recuFileName;
        $documents[0]->save($recuPath);
        $fileNames['recu'] = $recuPath;


        return $fileNames;
    }
}