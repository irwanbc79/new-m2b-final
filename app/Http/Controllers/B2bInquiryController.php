<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\B2bInquiry;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class B2bInquiryController extends Controller
{
    /**
     * Submit B2B Customs/Shipping Inquiry
     */
    public function submit(Request $request): JsonResponse
    {
        // 1. Validate inputs
        $request->validate([
            'name'              => 'required|string|max:100',
            'company'           => 'required|string|max:100',
            'npwp'              => 'required|string|max:50',
            'email'             => 'required|email|max:100',
            'phone'             => 'required|string|max:30',
            'service_type'      => 'required|in:paid,free_ship',
            'shipment_type'     => 'required_if:service_type,free_ship|nullable|string|max:50',
            'volume'            => 'required_if:service_type,free_ship|nullable|string|max:100',
            'route_origin'      => 'nullable|string|max:100',
            'route_destination' => 'nullable|string|max:100',
            'est_shipment_date' => 'nullable|string|max:100',
            'invoice_file'      => 'nullable|file|max:10240', // Max 10MB
            'packing_list_file' => 'nullable|file|max:10240', 
            'catalog_file'      => 'nullable|file|max:15360', // Max 15MB
        ]);

        // 2. Handle File Uploads
        $storedFiles = [];
        $fileFields = ['invoice_file', 'packing_list_file', 'catalog_file'];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                try {
                    $file = $request->file($field);
                    $originalName = $file->getClientOriginalName();
                    $mimeType = $file->getClientMimeType();
                    
                    // Store file in storage/app/inquiries
                    $path = $file->store('inquiries');

                    $storedFiles[] = [
                        'field'         => $field,
                        'path'          => $path,
                        'original_name' => $originalName,
                        'mime_type'     => $mimeType,
                    ];
                } catch (\Throwable $e) {
                    Log::error("Failed to upload file {$field}", ['error' => $e->getMessage()]);
                }
            }
        }

        // 3. Generate Invoice No (if Paid option selected)
        $invoiceNo = null;
        $status = 'pending';
        if ($request->input('service_type') === 'paid') {
            $invoiceNo = 'M2B-INQ-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
        } else {
            $status = 'free';
        }

        // 4. Save to Database
        try {
            $inquiry = B2bInquiry::create([
                'name'              => $request->input('name'),
                'company'           => $request->input('company'),
                'npwp'              => $request->input('npwp'),
                'email'             => $request->input('email'),
                'phone'             => $request->input('phone'),
                'service_type'      => $request->input('service_type'),
                'shipment_type'     => $request->input('shipment_type'),
                'volume'            => $request->input('volume'),
                'route_origin'      => $request->input('route_origin'),
                'route_destination' => $request->input('route_destination'),
                'est_shipment_date' => $request->input('est_shipment_date'),
                'files'             => $storedFiles,
                'invoice_no'        => $invoiceNo,
                'status'            => $status,
                'emailed'           => false
            ]);
        } catch (\Throwable $e) {
            Log::error("Failed to save B2bInquiry to DB", ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Gagal menyimpan data ke database. Silakan coba kembali.'], 500);
        }

        // 5. Send Email Notification to sales@m2b.co.id
        $emailSent = false;
        try {
            Mail::send('emails.inquiry_notification', compact('inquiry'), function ($message) use ($inquiry, $storedFiles) {
                $message->to('sales@m2b.co.id')
                        ->subject('Inquiry B2B Baru — ' . $inquiry->company);

                // Attach files
                foreach ($storedFiles as $file) {
                    $filePath = storage_path('app/' . $file['path']);
                    if (file_exists($filePath)) {
                        $message->attach($filePath, [
                            'as'   => $file['original_name'],
                            'mime' => $file['mime_type']
                        ]);
                    }
                }
            });
            $emailSent = true;
        } catch (\Throwable $e) {
            Log::error("Failed to send B2B inquiry notification email", ['error' => $e->getMessage()]);
        }

        // 6. Send Autoresponder to Customer
        try {
            Mail::send('emails.inquiry_autoresponder', compact('inquiry'), function ($message) use ($inquiry) {
                $message->to($inquiry->email, $inquiry->name)
                        ->subject('Inquiry Anda Telah Diterima — M2B');
            });
            
            if ($emailSent) {
                $inquiry->update(['emailed' => true]);
            }
        } catch (\Throwable $e) {
            Log::error("Failed to send B2B inquiry autoresponder email", ['error' => $e->getMessage()]);
        }

        // 7. Return Response
        return response()->json([
            'success'      => true,
            'invoice_no'   => $invoiceNo,
            'service_type' => $inquiry->service_type,
            'inquiry_id'   => $inquiry->id,
            'wa_text'      => $this->getWhatsAppMessage($inquiry)
        ]);
    }

    /**
     * Generate pre-filled WhatsApp message
     */
    private function getWhatsAppMessage(B2bInquiry $inquiry): string
    {
        $type = $inquiry->service_type === 'paid' 
            ? 'Opsi A (Riset Berbayar Rp 150.000)' 
            : 'Opsi B (Bundling Freight - GRATIS)';

        $msg = "Halo M2B, saya baru saja mengajukan B2B Cargo Inquiry melalui website M2B. Berikut detail data perusahaan kami:\n\n"
             . "· Nama Perusahaan: " . $inquiry->company . "\n"
             . "· NPWP: " . $inquiry->npwp . "\n"
             . "· Nama Kontak: " . $inquiry->name . "\n"
             . "· Rencana Pengiriman: " . $inquiry->shipment_type . " (" . $inquiry->volume . ")\n"
             . "· Rute: " . ($inquiry->route_origin ?? '-') . " ke " . ($inquiry->route_destination ?? '-') . "\n"
             . "· Tipe Layanan: " . $type . "\n";
             
        if ($inquiry->invoice_no) {
            $msg .= "· No. Invoice: " . $inquiry->invoice_no . "\n\n"
                 . "[Catatan: Saya akan segera mengirimkan bukti transfer pembayaran Rp 150.000 ke Rekening Mandiri M2B].";
        } else {
            $msg .= "\n[Dokumen Invoice/PL telah kami unggah ke sistem M2B. Mohon bantuannya untuk kalkulasi harga pengiriman].";
        }

        return rawurlencode($msg);
    }
}
