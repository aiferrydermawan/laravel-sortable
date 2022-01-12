<?php

namespace App\Http\Livewire;

use App\Models\Activity;
use Livewire\Component;

class Todolists extends Component
{
    public $body;
    public $activities;
    public $count_activites;

    public function render()
    {
        $this->activities = Activity::orderBy('position','asc')->get();
        $this->count_activites = Activity::count();
        return view('livewire.todolists');
    }

    public function updateTaskOrder($lists)
    {
        foreach($lists as $item){
            Activity::where('id',$item['value'])->update(['position' => $item['order']]);
        }
    }

    public function submit()
    {
        $this->validate([
            'body' => 'required'
        ]);

        Activity::create([
            'position' => $this->count_activites + 1,
            'body' => $this->body
        ]);

        $this->body = NULL;
    }

    public function delete($id)
    {
        $activity = Activity::find($id);
        $activity->delete();
    }
}
