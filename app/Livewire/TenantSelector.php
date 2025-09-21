<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Tenant;

class TenantSelector extends Component
{
    public $tenants;
    public $selectedTenant;

    public function mount()
    {
        $this->tenants = Tenant::all();
        $this->selectedTenant = Session::get('tenant_id');
    }

    public function selectTenant($id)
    {
        if (empty($id)) {
            return; // do nothing
        }

        $tenant = Tenant::find($id);
        if (!$tenant) return;

        Session::regenerate();

        Session::put('tenant_id', $tenant->id);
        Session::put('tenant_name', $tenant->name);

        if (Auth::check()) {
            Session::put('user_id', Auth::id());
        }

        return redirect(request()->header('Referer') ?? '/');
    }

    public function render()
    {
        return view('livewire.tenant-selector');
    }
}
