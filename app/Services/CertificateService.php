<?php

namespace App\Services;

use App\Models\Member;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * Membership Certificate Generation Service
 * 
 * Generates PDF certificates with QR codes for verified members
 * 
 * @package App\Services
 */
class CertificateService
{
    /**
     * Generate membership certificate PDF
     * 
     * @param Member $member Member instance
     * @return string Path to generated certificate
     * @throws Exception
     */
    public function generate(Member $member): string
    {
        try {
            // Validate member is approved
            if ($member->status !== 'approved') {
                throw new Exception('Member must be approved to generate certificate');
            }

            // Generate QR code
            $qrCodePath = $this->generateQrCode($member);

            // Prepare certificate data
            $data = [
                'member' => $member,
                'membership_id' => $member->membership_id,
                'full_name' => $member->full_name,
                'issue_date' => $member->approved_at?->format('F d, Y'),
                'expiry_date' => $member->expires_at?->format('F d, Y'),
                'qr_code' => $qrCodePath,
            ];

            // Generate PDF
            $pdf = Pdf::loadView('certificates.membership', $data);
            $pdf->setPaper('A4', 'landscape');
            $pdf->setOption('enable-local-file-access', true);

            // Save certificate
            $filename = "certificate_{$member->membership_id}_" . now()->format('YmdHis') . '.pdf';
            $path = "certificates/{$filename}";
            
            Storage::disk('local')->put($path, $pdf->output());

            // Update member record
            $member->update([
                'certificate_path' => $path,
                'certificate_generated_at' => now(),
            ]);

            // Log certificate generation
            Log::channel('security')->info('Certificate generated', [
                'member_id' => $member->id,
                'membership_id' => $member->membership_id,
                'path' => $path,
            ]);

            return $path;
        } catch (Exception $e) {
            Log::channel('security')->error('Certificate generation failed', [
                'member_id' => $member->id,
                'error' => $e->getMessage(),
            ]);
            throw new Exception('Certificate generation failed: ' . $e->getMessage());
        }
    }

    /**
     * Generate QR code for membership certificate
     * 
     * @param Member $member Member instance
     * @return string Path to QR code image
     * @throws Exception
     */
    private function generateQrCode(Member $member): string
    {
        try {
            // QR code data (membership verification URL)
            $verificationUrl = route('certificate.verify', [
                'membership_id' => $member->membership_id,
                'token' => $this->generateVerificationToken($member),
            ]);

            // Generate QR code
            $qrCode = QrCode::create($verificationUrl)
                ->setSize(200)
                ->setMargin(10);

            $writer = new PngWriter();
            $result = $writer->write($qrCode);

            // Save QR code
            $filename = "qr_{$member->membership_id}.png";
            $path = "qr_codes/{$filename}";
            
            Storage::disk('local')->put($path, $result->getString());

            return storage_path("app/{$path}");
        } catch (Exception $e) {
            Log::channel('security')->error('QR code generation failed', [
                'member_id' => $member->id,
                'error' => $e->getMessage(),
            ]);
            throw new Exception('QR code generation failed: ' . $e->getMessage());
        }
    }

    /**
     * Generate verification token for certificate
     * 
     * @param Member $member Member instance
     * @return string Verification token
     */
    private function generateVerificationToken(Member $member): string
    {
        $data = [
            'membership_id' => $member->membership_id,
            'member_id' => $member->id,
            'timestamp' => now()->timestamp,
        ];

        return base64_encode(hash_hmac('sha256', json_encode($data), config('app.key'), true));
    }

    /**
     * Verify certificate token
     * 
     * @param string $membershipId Membership ID
     * @param string $token Verification token
     * @return bool Verification status
     */
    public function verifyToken(string $membershipId, string $token): bool
    {
        $member = Member::where('membership_id', $membershipId)->first();

        if (!$member) {
            return false;
        }

        $expectedToken = $this->generateVerificationToken($member);
        return hash_equals($expectedToken, $token);
    }

    /**
     * Download certificate
     * 
     * @param Member $member Member instance
     * @return \Illuminate\Http\Response
     * @throws Exception
     */
    public function download(Member $member)
    {
        if (empty($member->certificate_path)) {
            // Generate if not exists
            $this->generate($member);
            $member->refresh();
        }

        if (!Storage::disk('local')->exists($member->certificate_path)) {
            throw new Exception('Certificate file not found');
        }

        return Storage::disk('local')->download(
            $member->certificate_path,
            "membership_certificate_{$member->membership_id}.pdf"
        );
    }
}

