<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Todo;


class TodoController extends Controller
{
    public function index(): View
    {
        // Menggunakan orderBy() untuk mengurutkan berdasarkan id secara descending
        $all_todos = Todo::orderBy('id', 'desc')->get();

        return view('todolist', ['todos' => $all_todos]);
    }

    public function add(Request $request): RedirectResponse
    {
        $request->validate([
            'todo' => 'required|string|max:255' // Validasi input 'todo'
        ]);

        $todo = new Todo;
        $todo->todo = $request->todo;
        $todo->status = false;
        $todo->save();

        return redirect('/');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $todo = Todo::find($id);
        if (!$todo) {
            abort(404); // Jika todo tidak ditemukan, tampilkan 404 error
        }
        
        $todo->status = !$todo->status;
        $todo->save();

        return redirect('/');
    }

    public function delete(Request $request, $id): RedirectResponse
    {
        $todo = Todo::find($id);
        if (!$todo) {
            abort(404); // Jika todo tidak ditemukan, tampilkan 404 error
        }

        $todo->delete();

        return redirect('/');
    }
}
