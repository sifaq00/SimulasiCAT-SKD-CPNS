<?php

namespace App\Livewire;

use App\Models\Package;
use App\Models\Bundle;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class PackageList extends Component
{
    public $packages = [];
    public $bundles = [];
    public $selectedPackage = null;
    public $selectedBundle = null;
    public $showPaymentModal = false;

    public function mount()
    {
        $this->packages = Package::active()
            ->orderBy('year')
            ->get()
            ->toArray();

        $this->bundles = Bundle::active()
            ->with('packages')
            ->get()
            ->toArray();
    }

    public function selectPackage(int $packageId)
    {
        $this->selectedPackage = Package::find($packageId);
        $this->selectedBundle = null;
        $this->showPaymentModal = true;
    }

    public function selectBundle(int $bundleId)
    {
        $this->selectedBundle = Bundle::find($bundleId);
        $this->selectedPackage = null;
        $this->showPaymentModal = true;
    }

    public function closeModal()
    {
        $this->selectedPackage = null;
        $this->selectedBundle = null;
        $this->showPaymentModal = false;
    }

    public function render()
    {
        return view('livewire.package-list');
    }
}
