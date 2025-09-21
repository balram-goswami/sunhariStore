<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;
use App\Services\VerifyDomainService;

class VerifyTenantDomains extends Command
{
    protected $signature = 'tenants:verify-domains';
    protected $description = 'Verify tenant domains every 24 hours';

    public function handle()
    {
        $this->info('Starting domain verification...');

        $service = new VerifyDomainService();

        Tenant::where('is_verified', false)->chunk(50, function ($tenants) use ($service) {
            foreach ($tenants as $tenant) {
                $verified = $service->verifyDNS($tenant);
                $status = $verified ? '✅ Verified' : '❌ Not Verified';
                $this->line("Domain: {$tenant->domain} - $status");
            }
        });

        $this->info('Domain verification complete.');
        return 0;
    }
}
