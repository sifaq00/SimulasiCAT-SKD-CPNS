<?php

namespace App\Livewire\Admin;

use App\Models\Bundle;
use App\Models\Package;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class PackageManage extends Component
{
    public $packages = [];
    public $bundles = [];
    public $showForm = false;
    public $editingId = null;
    public $formData = [
        'name' => '',
        'slug' => '',
        'description' => '',
        'year' => '',
        'price' => 0,
        'total_questions' => 110,
        'duration_minutes' => 100,
        'is_active' => true,
        'is_free' => false,
    ];

    public $showBundleForm = false;
    public $editingBundleId = null;
    public $bundleFormData = [
        'name' => '',
        'slug' => '',
        'description' => '',
        'original_price' => 0,
        'discount_price' => 0,
        'is_active' => true,
        'selected_packages' => [],
    ];

    protected $rules = [
        'formData.name' => 'required|min:3',
        'formData.slug' => 'required|alpha_dash',
        'formData.description' => 'nullable',
        'formData.year' => 'required|integer|min:2019|max:2030',
        'formData.price' => 'required|numeric|min:0',
        'formData.total_questions' => 'required|integer|min:1',
        'formData.duration_minutes' => 'required|integer|min:1',
    ];

    protected $bundleRules = [
        'bundleFormData.name' => 'required|min:3',
        'bundleFormData.slug' => 'required|alpha_dash',
        'bundleFormData.description' => 'nullable',
        'bundleFormData.original_price' => 'required|numeric|min:0',
        'bundleFormData.discount_price' => 'required|numeric|min:0|lte:bundleFormData.original_price',
        'bundleFormData.selected_packages' => 'required|array|min:1',
    ];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->packages = Package::withCount('questions')
            ->orderBy('year')
            ->get()
            ->toArray();

        $this->bundles = Bundle::withCount('packages')
            ->get()
            ->toArray();
    }

    // Keep loadPackages for backward compatibility if needed, or redirect
    public function loadPackages()
    {
        $this->loadData();
    }

    public function updatedFormDataName($value)
    {
        if (!$this->editingId) {
            $this->formData['slug'] = \Str::slug($value);
        }
    }

    public function openCreateForm()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function editPackage($id)
    {
        $package = Package::findOrFail($id);
        $this->editingId = $id;
        $this->formData = [
            'name' => $package->name,
            'slug' => $package->slug,
            'description' => $package->description,
            'year' => $package->year,
            'price' => $package->price,
            'total_questions' => $package->total_questions,
            'duration_minutes' => $package->duration_minutes,
            'is_active' => $package->is_active,
            'is_free' => $package->is_free,
        ];
        $this->showForm = true;
    }

    public function savePackage()
    {
        $this->validate();

        $data = $this->formData;

        if ($this->editingId) {
            $package = Package::findOrFail($this->editingId);
            $package->update($data);
            session()->flash('success', 'Paket berhasil diupdate!');
        } else {
            Package::create($data);
            session()->flash('success', 'Paket berhasil ditambahkan!');
        }

        $this->closeForm();
        $this->loadPackages();
    }

    public function toggleActive($id)
    {
        $package = Package::findOrFail($id);
        $package->update(['is_active' => !$package->is_active]);
        $this->loadPackages();
    }

    public function deletePackage($id)
    {
        $package = Package::findOrFail($id);

        if ($package->questions()->count() > 0) {
            session()->flash('error', 'Tidak bisa menghapus paket yang sudah memiliki soal!');
            return;
        }

        $package->delete();
        session()->flash('success', 'Paket berhasil dihapus!');
        $this->loadPackages();
    }

    public function closeForm()
    {
        $this->showForm = false;
        $this->editingId = null;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->formData = [
            'name' => '',
            'slug' => '',
            'description' => '',
            'year' => date('Y'),
            'price' => 0,
            'total_questions' => 110,
            'duration_minutes' => 100,
            'is_active' => true,
            'is_free' => false,
        ];
    }

    public function render()
    {
        return view('livewire.admin.package-manage');
    }

    // Bundle Logic

    public function openCreateBundleForm()
    {
        $this->resetBundleForm();
        $this->showBundleForm = true;
    }

    public function editBundle($id)
    {
        $bundle = Bundle::with('packages')->findOrFail($id);
        $this->editingBundleId = $id;
        $this->bundleFormData = [
            'name' => $bundle->name,
            'slug' => $bundle->slug,
            'description' => $bundle->description,
            'original_price' => $bundle->original_price,
            'discount_price' => $bundle->discount_price,
            'is_active' => $bundle->is_active,
            'selected_packages' => $bundle->packages->pluck('id')->map(fn($id) => (string) $id)->toArray(),
        ];
        $this->showBundleForm = true;
    }

    public function saveBundle()
    {
        $this->validate($this->bundleRules);

        $data = [
            'name' => $this->bundleFormData['name'],
            'slug' => $this->bundleFormData['slug'],
            'description' => $this->bundleFormData['description'],
            'original_price' => $this->bundleFormData['original_price'],
            'discount_price' => $this->bundleFormData['discount_price'],
            'is_active' => $this->bundleFormData['is_active'],
        ];

        if ($this->editingBundleId) {
            $bundle = Bundle::findOrFail($this->editingBundleId);
            $bundle->update($data);
            $bundle->packages()->sync($this->bundleFormData['selected_packages']);
            session()->flash('success', 'Bundle berhasil diupdate!');
        } else {
            $bundle = Bundle::create($data);
            $bundle->packages()->sync($this->bundleFormData['selected_packages']);
            session()->flash('success', 'Bundle berhasil ditambahkan!');
        }

        $this->closeBundleForm();
        $this->loadData();
    }

    public function deleteBundle($id)
    {
        $bundle = Bundle::findOrFail($id);
        // Maybe check existing transactions?
        // For simplicity, just delete. Transactions might have null bundle_id if generic constraint, 
        // or prevent delete if transactions exist.
        if ($bundle->transactions()->exists()) {
            session()->flash('error', 'Tidak bisa menghapus bundle yang sudah dibeli user!');
            return;
        }

        $bundle->packages()->detach(); // Pivot
        $bundle->delete();

        session()->flash('success', 'Bundle berhasil dihapus!');
        $this->loadData();
    }

    public function toggleBundleActive($id)
    {
        $bundle = Bundle::findOrFail($id);
        $bundle->update(['is_active' => !$bundle->is_active]);
        $this->loadData();
    }

    public function closeBundleForm()
    {
        $this->showBundleForm = false;
        $this->editingBundleId = null;
        $this->resetBundleForm();
    }

    public function resetBundleForm()
    {
        $this->bundleFormData = [
            'name' => '',
            'slug' => '',
            'description' => '',
            'original_price' => 0,
            'discount_price' => 0,
            'is_active' => true,
            'selected_packages' => [],
        ];
    }
}
