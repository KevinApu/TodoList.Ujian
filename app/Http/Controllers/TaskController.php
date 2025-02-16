<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\TaskModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

use function Laravel\Prompts\alert;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->query('status'); // Ambil parameter status dari URL

        if ($status === 'complete') {
            $listtask = TaskModel::where('is_done', 1)->get();
        } elseif ($status === 'incomplete') {
            $listtask = TaskModel::where('is_done', 0)->get();
        } else {
            $listtask = TaskModel::all(); // Default: semua tugas
        }
        return view('index', compact('listtask'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        TaskModel::create([
            'name' => $request->task,
            'priority' => $request->priority
        ]);


        return redirect()->back()->with('success', 'Task sudah berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $taskview = TaskModel::findOrFail($id);
        $listtask = TaskModel::all();
        return view('index', compact('taskview', 'listtask'));
    }

    public function Checklist(Request $request, $id)
    {
        $task = TaskModel::findOrFail($id);
        $status = $request->has('status') ? 1 : 0;
        $completedAt = $status ? Carbon::now()->translatedFormat('l, H:i') : null;
        $task->update([
            'is_done' => $status,
            'tanggal' => $completedAt
        ]);

        return redirect()->route('todo.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = TaskModel::findOrFail($id);
        $task->update([
            'name' => $request->task,
            'priority' => $request->priority
        ]);
        return redirect()->route('todo.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = TaskModel::findOrFail($id);
        $task->delete();
        return redirect()->route('todo.index')->with('success', 'Task sudah berhasil dihapus.');
    } 
    
    public function deleteAll()
    {
        TaskModel::query()->delete();
        return redirect()->route('todo.index')->with('success', 'Task sudah berhasil dihapus.');
    }
}
