<?php

namespace App\Services;

use App\Models\Tenant;
use Illuminate\Support\Facades\Http;

class VerifyDomainService
{
    public function verifyDNS(Tenant $tenant): bool
    {
        if ($tenant->is_verified) {
            return true;
        }

        if (app()->environment('local')) {
            if (!empty($tenant->verification_token)) {
                $tenant->is_verified = true;
                $tenant->save();
                return true;
            }

            return false;
        }

        $domain = filter_var($tenant->domain, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME);
        if (!$domain) {
            return false;
        }

        $dnsRecords = dns_get_record("verify." . $domain, DNS_TXT);

        foreach ($dnsRecords as $record) {
            if (
                isset($record['txt']) &&
                trim($record['txt'], "\" \t\n\r\0\x0B") === $tenant->verification_token
            ) {
                if (!$this->isHostReachable($domain)) {
                    return false;
                }

                $tenant->is_verified = true;
                $tenant->save();
                return true;
            }
        }

        return false;
    }


    protected function isHostReachable(string $domain): bool
    {
        try {
            $response = Http::timeout(5)->get("http://$domain");

            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }
}
