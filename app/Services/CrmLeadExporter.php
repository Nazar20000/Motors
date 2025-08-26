<?php

namespace App\Services;

use App\Models\Application;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CrmLeadExporter
{
    /**
     * Build ADF XML content from an Application model.
     */
    public function buildAdfXml(Application $application): string
    {
        $nowRfc3339 = Date::now()->toRfc3339String();

        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><adf></adf>');

        $prospect = $xml->addChild('prospect');
        $prospect->addChild('requestdate', $nowRfc3339);

        $vehicle = $prospect->addChild('vehicle');
        if ($application->vehicle_year) { $vehicle->addChild('year', htmlspecialchars((string)$application->vehicle_year)); }
        if ($application->vehicle_make) { $vehicle->addChild('make', htmlspecialchars((string)$application->vehicle_make)); }
        if ($application->vehicle_model) { $vehicle->addChild('model', htmlspecialchars((string)$application->vehicle_model)); }
        if ($application->vehicle_price) { $vehicle->addChild('price', number_format((float)$application->vehicle_price, 2, '.', '')); }
        if ($application->stock_number) { $vehicle->addChild('stock', htmlspecialchars((string)$application->stock_number)); }

        $customer = $prospect->addChild('customer');
        $contact = $customer->addChild('contact');
        $contact->addChild('name', htmlspecialchars($application->full_name));
        $contact->addChild('email', htmlspecialchars((string)$application->email));
        $contact->addChild('phone', htmlspecialchars((string)$application->cell_phone));

        $address = $customer->addChild('address');
        $address->addChild('street', htmlspecialchars((string)$application->street_address));
        $address->addChild('city', htmlspecialchars((string)$application->city));
        $address->addChild('regioncode', htmlspecialchars((string)$application->state));
        $address->addChild('postalcode', htmlspecialchars((string)$application->zip_code));

        $finance = $prospect->addChild('finance');
        if ($application->down_payment) { $finance->addChild('downpayment', number_format((float)$application->down_payment, 2, '.', '')); }
        if ($application->monthly_income) { $finance->addChild('monthlyincome', number_format((float)$application->monthly_income, 2, '.', '')); }

        // Additional details packed into comments to preserve full application data
        $extras = [
            'buyer_type' => $application->buyer_type,
            'date_of_birth' => optional($application->date_of_birth)->format('Y-m-d'),
            'ssn' => $application->ssn,
            'home_phone' => $application->home_phone,
            'driver_license' => $application->driver_license,
            'driver_license_state' => $application->driver_license_state,
            'license_issue_date' => optional($application->license_issue_date)->format('Y-m-d'),
            'license_expiry_date' => optional($application->license_expiry_date)->format('Y-m-d'),
            'housing_type' => $application->housing_type,
            'monthly_rent' => $application->monthly_rent,
            'years_at_address' => $application->years_at_address,
            'months_at_address' => $application->months_at_address,
            'employer_name' => $application->employer_name,
            'job_title' => $application->job_title,
            'employer_phone' => $application->employer_phone,
            'years_at_job' => $application->years_at_job,
            'months_at_job' => $application->months_at_job,
            'has_trade_in' => $application->has_trade_in ? 'yes' : 'no',
            'trade_vin' => $application->trade_vin,
            'trade_mileage' => $application->trade_mileage,
            'trade_year' => $application->trade_year,
            'trade_make' => $application->trade_make,
            'trade_model' => $application->trade_model,
            'exterior_color' => $application->exterior_color,
            'interior_color' => $application->interior_color,
            'accepts_terms' => $application->accepts_terms ? 'yes' : 'no',
        ];

        // Append previous addresses and employments summaries
        if (is_array($application->previous_addresses) && !empty($application->previous_addresses)) {
            foreach ($application->previous_addresses as $i => $addr) {
                $label = 'previous_address_' . ($i+1);
                $extras[$label] = trim(($addr['street_address'] ?? '').', '.($addr['city'] ?? '').', '.($addr['state'] ?? '').' '.($addr['zip_code'] ?? ''));
            }
        }
        if (is_array($application->previous_employments) && !empty($application->previous_employments)) {
            foreach ($application->previous_employments as $i => $emp) {
                $label = 'previous_employment_' . ($i+1);
                $extras[$label] = trim(($emp['employer_name'] ?? '').' - '.($emp['job_title'] ?? ''));
            }
        }

        $commentLines = [];
        foreach ($extras as $label => $value) {
            if ($value === null || $value === '') { continue; }
            $commentLines[] = strtoupper($label) . ': ' . (string) $value;
        }
        if (!empty($commentLines)) {
            $prospect->addChild('comments', htmlspecialchars(implode("\n", $commentLines)));
        }

        $provider = $prospect->addChild('provider');
        $name = env('APP_NAME', 'Website');
        $provider->addChild('name', htmlspecialchars($name));

        // XML string
        return $xml->asXML() ?: '';
    }

    /**
     * Upload the ADF XML to CRM via SFTP.
     * Returns the remote path on success.
     */
    public function uploadToCrm(string $xmlContent, ?string $fileName = null): string
    {
        $disk = Storage::disk('crm_sftp');

        $fileName = $fileName ?: 'lead_' . now()->format('Ymd_His') . '.xml';
        $remoteDir = rtrim(config('filesystems.disks.crm_sftp.root') ?? '/', '/');
        $remotePath = ($remoteDir === '' ? '' : $remoteDir . '/') . $fileName;

        $disk->put($remotePath, $xmlContent);
        Log::info('Lead ADF uploaded to CRM SFTP', ['remote_path' => $remotePath]);
        return $remotePath;
    }

    /**
     * Convenience method: build and upload.
     */
    public function export(Application $application): string
    {
        $xml = $this->buildAdfXml($application);
        return $this->uploadToCrm($xml);
    }
}


