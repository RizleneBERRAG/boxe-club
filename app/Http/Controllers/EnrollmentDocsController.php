<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentDocsController extends Controller
{
    private function getPaidEnrollment(Request $request): Enrollment
    {
        $ref = $request->query('ref');
        abort_unless($ref, 404);

        $enrollment = Enrollment::where('dossier_ref', $ref)->firstOrFail();
        abort_unless($enrollment->status === 'paid', 403); // pas payé => interdit

        return $enrollment;
    }

    public function medical(Request $request)
    {
        $this->getPaidEnrollment($request);

        $path = storage_path('app/templates/certificat_medical.pdf');
        abort_unless(file_exists($path), 404);

        return response()->download($path, 'certificat-medical.pdf', [
            'Content-Type' => 'application/pdf'
        ]);
    }

    public function ophtalmo(Request $request)
    {
        $this->getPaidEnrollment($request);

        $path = storage_path('app/templates/certificat_ophtalmo.pdf');
        abort_unless(file_exists($path), 404);

        return response()->download($path, 'certificat-ophtalmologique.pdf', [
            'Content-Type' => 'application/pdf'
        ]);
    }
}
