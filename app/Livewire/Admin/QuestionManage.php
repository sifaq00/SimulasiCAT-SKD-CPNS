<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Option;
use App\Models\Package;
use App\Models\Question;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class QuestionManage extends Component
{
    use WithFileUploads;

    // Filters
    public $selectedPackage = '';
    public $selectedCategory = '';
    public $search = '';

    // Form data
    public $showForm = false;
    public $editingId = null;
    public $formData = [
        'package_id' => '',
        'category_id' => '',
        'question_text' => '',
        'question_image' => null,
        'explanation' => '',
        'order_number' => 1,
    ];
    public $imageFile; // For Livewire upload
    public $existingImage; // For display
    public $csvFile; // For Bulk Import

    public $options = [
        ['label' => 'A', 'text' => '', 'points' => 5, 'is_correct' => true],
        ['label' => 'B', 'text' => '', 'points' => 4, 'is_correct' => false],
        ['label' => 'C', 'text' => '', 'points' => 3, 'is_correct' => false],
        ['label' => 'D', 'text' => '', 'points' => 2, 'is_correct' => false],
        ['label' => 'E', 'text' => '', 'points' => 1, 'is_correct' => false],
    ];

    // Data
    public $packages = [];
    public $categories = [];

    protected $rules = [
        'formData.package_id' => 'required|exists:packages,id',
        'formData.category_id' => 'required|exists:categories,id',
        'formData.question_text' => 'required|min:5',
        'formData.explanation' => 'nullable',
        'formData.order_number' => 'required|integer|min:1',
        'options.*.text' => 'required|min:1',
        'options.*.points' => 'required|integer|min:0|max:5',
        'imageFile' => 'nullable|image|max:2048',
    ];

    protected $messages = [
        'formData.package_id.required' => 'Pilih paket soal',
        'formData.category_id.required' => 'Pilih kategori',
        'formData.question_text.required' => 'Teks soal wajib diisi',
        'formData.question_text.min' => 'Teks soal minimal 10 karakter',
        'options.*.text.required' => 'Semua opsi jawaban harus diisi',
    ];

    public function mount()
    {
        $this->categories = Category::all()->toArray();
    }

    public function updatedSelectedPackage()
    {
        //
    }

    public function updatedSelectedCategory()
    {
        //
    }

    public function updatedSearch()
    {
        //
    }

    public function openCreateForm()
    {
        $this->resetForm();
        $this->showForm = true;

        // Auto-set order number
        if ($this->selectedPackage && $this->selectedCategory) {
            $lastOrder = Question::where('package_id', $this->selectedPackage)
                ->where('category_id', $this->selectedCategory)
                ->max('order_number') ?? 0;
            $this->formData['order_number'] = $lastOrder + 1;
            $this->formData['package_id'] = $this->selectedPackage;
            $this->formData['category_id'] = $this->selectedCategory;
        }
    }

    public function editQuestion($id)
    {
        $question = Question::with('options')->findOrFail($id);

        $this->editingId = $id;
        $this->formData = [
            'package_id' => $question->package_id,
            'category_id' => $question->category_id,
            'question_text' => $question->question_text,
            'explanation' => $question->explanation,
            'order_number' => $question->order_number,
            'question_image' => $question->question_image,
        ];
        $this->existingImage = $question->question_image;
        $this->imageFile = null;

        $this->options = $question->options->map(fn($opt) => [
            'id' => $opt->id,
            'label' => $opt->label,
            'text' => $opt->option_text,
            'points' => $opt->points,
            'is_correct' => $opt->is_correct,
        ])->toArray();

        $this->showForm = true;
    }

    public function selectPackage($id)
    {
        $this->selectedPackage = $id;
    }

    public function backToPackages()
    {
        $this->selectedPackage = '';
        $this->showForm = false;
    }

    public function removeImage()
    {
        $this->imageFile = null;
        $this->existingImage = null;
        $this->formData['question_image'] = null;

        if ($this->editingId) {
            $question = Question::find($this->editingId);
            if ($question && $question->question_image) {
                \Storage::disk('public')->delete($question->question_image);
                $question->update(['question_image' => null]);
            }
        }

        session()->flash('success', 'Gambar berhasil dihapus.');
    }

    public function setCorrectOption($index)
    {
        // For TWK/TIU: only one correct answer
        $category = Category::find($this->formData['category_id']);

        if ($category && $category->code !== 'TKP') {
            foreach ($this->options as $i => $opt) {
                $this->options[$i]['is_correct'] = ($i === $index);
                // Set points: correct = 5, wrong = 0
                $this->options[$i]['points'] = ($i === $index) ? 5 : 0;
            }
        }
    }

    public function saveQuestion($next = false)
    {
        $this->validate();

        $category = Category::find($this->formData['category_id']);
        $isTKP = $category && $category->code === 'TKP';

        // Handle image upload
        if ($this->imageFile) {
            $imagePath = $this->imageFile->store('questions', 'public');
            $this->formData['question_image'] = $imagePath;
        }

        // Create or update question
        $questionData = [
            'package_id' => $this->formData['package_id'],
            'category_id' => $this->formData['category_id'],
            'question_text' => $this->formData['question_text'],
            'question_image' => $this->formData['question_image'] ?? null,
            'explanation' => $this->formData['explanation'],
            'order_number' => $this->formData['order_number'],
        ];

        if ($this->editingId) {
            $question = Question::findOrFail($this->editingId);
            $question->update($questionData);
        } else {
            $question = Question::create($questionData);
        }

        // Save options
        $correctOptionId = null;

        foreach ($this->options as $opt) {
            $optionData = [
                'question_id' => $question->id,
                'label' => $opt['label'],
                'option_text' => $opt['text'],
                'points' => $isTKP ? $opt['points'] : ($opt['is_correct'] ? 5 : 0),
                'is_correct' => $opt['is_correct'],
            ];

            if (isset($opt['id'])) {
                $option = Option::find($opt['id']);
                if ($option) {
                    $option->update($optionData);
                    if ($opt['is_correct'] && !$isTKP) {
                        $correctOptionId = $option->id;
                    }
                }
            } else {
                $option = Option::create($optionData);
                if ($opt['is_correct'] && !$isTKP) {
                    $correctOptionId = $option->id;
                }
            }
        }

        if ($next) {
            $this->resetFormForNext();
            session()->flash('success', 'Soal disimpan, silahkan lanjut ke nomor berikutnya.');
        } else {
            $this->closeForm();
            session()->flash('success', $this->editingId ? 'Soal berhasil diupdate!' : 'Soal berhasil ditambahkan!');
        }
    }

    public function resetFormForNext()
    {
        $lastCategory = $this->formData['category_id'];
        $lastOrder = $this->formData['order_number'];

        $this->resetForm();

        $this->formData['package_id'] = $this->selectedPackage;
        $this->formData['category_id'] = $lastCategory;
        $this->formData['order_number'] = $lastOrder + 1;

        $this->editingId = null;
        $this->showForm = true;
    }

    public function deleteQuestion($id)
    {
        $question = Question::findOrFail($id);
        $question->options()->delete();
        $question->delete();

        session()->flash('success', 'Soal berhasil dihapus!');
    }

    public function cancelEdit()
    {
        $this->showForm = false;
        $this->editingId = null;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->formData = [
            'package_id' => $this->selectedPackage ?: '',
            'category_id' => $this->selectedCategory ?: '',
            'question_text' => '',
            'explanation' => '',
            'order_number' => 1,
            'question_image' => null,
        ];
        $this->options = [
            ['label' => 'A', 'text' => '', 'points' => 5, 'is_correct' => true],
            ['label' => 'B', 'text' => '', 'points' => 4, 'is_correct' => false],
            ['label' => 'C', 'text' => '', 'points' => 3, 'is_correct' => false],
            ['label' => 'D', 'text' => '', 'points' => 2, 'is_correct' => false],
            ['label' => 'E', 'text' => '', 'points' => 1, 'is_correct' => false],
        ];
    }

    public function getQuestionsProperty()
    {
        return Question::with(['package', 'category', 'options'])
            ->when($this->selectedPackage, fn($q) => $q->where('package_id', $this->selectedPackage))
            ->when($this->selectedCategory, fn($q) => $q->where('category_id', $this->selectedCategory))
            ->when($this->search, fn($q) => $q->where('question_text', 'like', "%{$this->search}%"))
            ->orderBy('package_id')
            ->orderBy('order_number')
            ->get();
    }

    public function getQuestionCountsProperty()
    {
        if (!$this->selectedPackage) {
            return [];
        }

        return Category::withCount([
            'questions' => function ($q) {
                $q->where('package_id', $this->selectedPackage);
            }
        ])->get()->mapWithKeys(fn($c) => [$c->code => $c->questions_count])->toArray();
    }

    public function importQuestions()
    {
        $this->validate([
            'csvFile' => 'required|mimes:csv,txt|max:2048',
        ]);

        $path = $this->csvFile->getRealPath();
        $file = fopen($path, 'r');

        // Skip header
        fgetcsv($file);

        $count = 0;
        \DB::beginTransaction();
        try {
            while (($row = fgetcsv($file)) !== FALSE) {
                if (count($row) < 8)
                    continue; // Basic validation

                $categoryCode = trim($row[0]);
                $category = collect($this->categories)->firstWhere('code', $categoryCode);
                if (!$category)
                    continue;

                $isTKP = $categoryCode === 'TKP';

                $question = Question::create([
                    'package_id' => $this->selectedPackage,
                    'category_id' => $category['id'],
                    'question_text' => $row[1],
                    'explanation' => $row[7] ?? null,
                    'order_number' => (int) ($row[8] ?? (Question::where('package_id', $this->selectedPackage)->max('order_number') + 1)),
                ]);

                // Options: Label|Text|Points|IsCorrect (Format: A:Text:Points:IsCorrect)
                // Columns 2, 3, 4, 5, 6 are options A, B, C, D, E
                $labels = ['A', 'B', 'C', 'D', 'E'];
                $correctOptionId = null;

                for ($i = 0; $i < 5; $i++) {
                    $optData = explode('|', $row[$i + 2]);
                    $text = $optData[0] ?? '';
                    $points = isset($optData[1]) ? (int) $optData[1] : 0;
                    $isCorrect = isset($optData[2]) && (trim(strtolower($optData[2])) === 'true' || $optData[2] === '1');

                    if (!$text)
                        continue;

                    $option = Option::create([
                        'question_id' => $question->id,
                        'label' => $labels[$i],
                        'option_text' => $text,
                        'points' => $isTKP ? $points : ($isCorrect ? 5 : 0),
                        'is_correct' => $isCorrect,
                    ]);

                    if ($isCorrect && !$isTKP) {
                        $correctOptionId = $option->id;
                    }
                }

                if ($correctOptionId) {
                    $question->update(['correct_option_id' => $correctOptionId]);
                }

                $count++;
            }
            \DB::commit();
            session()->flash('success', "Berhasil mengimpor $count soal!");
            $this->csvFile = null;
        } catch (\Exception $e) {
            \DB::rollBack();
            session()->flash('error', 'Gagal mengimpor: ' . $e->getMessage());
        }

        fclose($file);
    }

    public function render()
    {
        $this->packages = Package::withCount('questions')->orderBy('year')->get()->toArray();

        return view('livewire.admin.question-manage', [
            'questions' => $this->questions,
            'questionCounts' => $this->questionCounts,
        ]);
    }
}
