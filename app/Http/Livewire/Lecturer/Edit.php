<?php

namespace App\Http\Livewire\Lecturer;

use Livewire\Component;
use App\Models\Lecturer;

class Edit extends Component
{
    // from parameter 
    public $lecturer;

    // modal lecturer
    public $nip;
    public $expertise;

    // modal user relationship 
    public $name;
    public $email;

    public $empty = false;

    public function mount($lecturer)
    {
        if(!empty($lecturer)){
            $this->name         = $lecturer->user->name;
            $this->email        = $lecturer->user->email;
            $this->nip          = $lecturer->nip;
            $this->expertise    = $lecturer->expertise;
        }else{
            // for 404 not found
            $this->empty = true;
        }
    }

    public function render()
    {
        return view('livewire.lecturer.edit');
    }

    protected function propertyValidation()
    {
        return [
            'nip'           => ['required', 'numeric', 'unique:lecturers,nip,'.$this->lecturer->id],
            'expertise'     => ['required'],
        ];
    }

    // realtime validation 
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->propertyValidation());
    }

    public function update()
    {
       try{
            // every realtime validation, must do this for twice
            $validatedData = $this->validate($this->propertyValidation());

            $lecturer = Lecturer::findOrFail($this->lecturer->id);
            $lecturer->fill($validatedData);
            $lecturer->save();

            session()->flash('success', 'Lecturer successfully updated.');
        } catch (\Exception $e){
            session()->flash('error', $e->getMessage());
        }
    }
}
