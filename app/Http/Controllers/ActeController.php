<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Acte;
use Barryvdh\DomPDF\Facade\Pdf;


class ActeController extends Controller
{
    public function downloadPdf(Acte $acte)
    {
        $pdf = Pdf::loadView('actes.pdf', ['acte' => $acte]);

        return $pdf->stream("acte-{$acte->reference}.pdf");
    }
}
