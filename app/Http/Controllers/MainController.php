<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Services\Operations;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {

        $id = session('user.id');
        $notes = User::find($id)->note()->whereNull('deleted_at')->get()->toArray();

        return view('home', ['notes' => $notes]);
    }

    public function newNote()
    {
        return view('new_note');
    }

    public function newNoteSubmit(Request $request)
    {
        $request->validate([
            'text_title' => 'required|min:3|max:200',
            'text_note' => 'required|min:3|max:3000',
        ], [
            'text_title.required' => "O titulo é obrigatório",
            'text_title.min' => "O Titulo deve ter pelo menos :min caracteres",
            'text_title.max' => "O Titulo deve ter no máximo :max caracteres",

            'text_note.required' => "A nota é obrigatória",
            'text_note.min' => "A nota deve ter pelo menos :min caracteres",
            'text_note.max' => "A nota deve ter no máximo :max caracteres",
        ]);

        $id = session('user.id');

        $note = new Note();
        $note->user_id = $id;
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        return redirect()->route('home');
    }

    public function editNote($id)
    {
        $id = Operations::decrypt($id);

        $note = Note::find($id);
        return view('edit_note', ['note' => $note]);
    }

    public function editNoteSubmit(Request $request)
    {
        $request->validate([
            'text_title' => 'required|min:3|max:200',
            'text_note' => 'required|min:3|max:3000',
        ], [
            'text_title.required' => "O titulo é obrigatório",
            'text_title.min' => "O Titulo deve ter pelo menos :min caracteres",
            'text_title.max' => "O Titulo deve ter no máximo :max caracteres",

            'text_note.required' => "A nota é obrigatória",
            'text_note.min' => "A nota deve ter pelo menos :min caracteres",
            'text_note.max' => "A nota deve ter no máximo :max caracteres",
        ]);

        if ($request->note_id == null) {
            return redirect()->route('home');
        }

        $id = Operations::decrypt($request->note_id);

        $note = Note::find($id);
        // dd($request->note_id);
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        return  redirect()->route('home');
    }


    public function deleteNote($id)
    {
        $id = Operations::decrypt($id);

        $note = Note::find($id);

        return view('delete_note', ['note' => $note]);
    }

    public function deleteConfirm($id)
    {
        $id = Operations::decrypt($id);
        $note = Note::find($id);

        //deletar direto
        // $note->delete();
        
        //softdelet
        // $note->deleted_at = date('Y/m/d H:i:s');
        // $note->save();
        
        //usando o Use SoftDelete no Model:
        $note->delete();
        //usando o Use SoftDelete no Model porém deletando do BD:
        $note->forceDelete();
        
        return  redirect()->route('home');
    }
}
