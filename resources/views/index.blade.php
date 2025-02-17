<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Page</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg overflow-hidden mt-16">
        <!-- Header -->
        <div class="px-4 py-2">
            <h1 class="text-gray-800 font-bold text-2xl uppercase">{{ isset($taskview) ? 'Edit Task' : 'Add Task' }}</h1>
        </div>

        <!-- Form -->
        <form action="{{ isset($taskview) ? route('todo.update', $taskview->id) : route('todo.add') }}" method="POST" class="w-full max-w-sm mx-auto px-4 py-2">
            @csrf
            @if(isset($taskview))
            @method('PUT')
            @endif
            <div class="flex items-center border-b-2 border-teal-500 py-2">
                <input
                    class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                    type="text" placeholder="Add a task" name="task"
                    value="{{ isset($taskview) ? $taskview->name : old('task') }}">
                @error('task')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
                <div class="mr-7">
                    <select name="priority" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200">
                        <option value="" disabled {{ old('priority', isset($taskview) ? $taskview->priority : '') == '' ? 'selected' : '' }}>⭐</option>
                        <option value="1" {{ old('priority', isset($taskview) ? $taskview->priority : '') == 1 ? 'selected' : '' }}>Bintang 1</option>
                        <option value="2" {{ old('priority', isset($taskview) ? $taskview->priority : '') == 2 ? 'selected' : '' }}>Bintang 2</option>
                        <option value="3" {{ old('priority', isset($taskview) ? $taskview->priority : '') == 3 ? 'selected' : '' }}>Bintang 3</option>
                        <option value="4" {{ old('priority', isset($taskview) ? $taskview->priority : '') == 4 ? 'selected' : '' }}>Bintang 4</option>
                        <option value="5" {{ old('priority', isset($taskview) ? $taskview->priority : '') == 5 ? 'selected' : '' }}>Bintang 5</option>
                    </select>
                </div>
                @error('priority')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror

                <button class="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded" type="submit">
                    {{ isset($taskview) ? 'Update' : 'Add' }}
                </button>
            </div>
        </form>


        <ul class="divide-y divide-gray-200 px-4 mt-12">
            <!-- Filter -->
            <div class="flex justify-center space-x-4 mb-8">
                @php
                $status = request()->query('status');
                @endphp
                <a href="{{ $status === 'complete' ? route('todo.index') : route('todo.index', ['status' => 'complete']) }}"
                    class="{{ $status === 'complete' ? 'bg-teal-700 border-2 border-yellow-500 text-white' : 'bg-teal-500 text-white hover:bg-teal-600' }} py-2 px-4 rounded-full">
                    Complete
                </a>
                <a href="{{ $status === 'incomplete' ? route('todo.index') : route('todo.index', ['status' => 'incomplete']) }}"
                    class="{{ $status === 'incomplete' ? 'bg-gray-500 border-2 border-yellow-500 text-white' : 'bg-gray-300 text-black hover:bg-gray-400' }} py-2 px-4 rounded-full">
                    Incomplete
                </a>
                <form action="{{ route('todo.deleteAll') }}" method="POST" onsubmit="return confirm('Apakah kamu yakin ingin menghapus semua tugas?')">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded-full hover:bg-red-600">
                        Delete All
                    </button>
                </form>
            </div>

            <!-- List Task -->
            @foreach($listtask as $item)
            <li class="py-4">
                <div class="flex items-center justify-between">
                    <div x-data="{ checked: {{ $item->is_done ? 'true' : 'false' }} }" class="flex items-center">
                        <form action="{{ route('todo.checklist', ['id' => $item->id]) }}" method="post">
                            @csrf
                            <input name="status" type="checkbox" onchange="this.form.submit()" {{ $item->is_done == 1 ? 'checked' : '' }}
                                class="h-5 w-5 text-teal-600 focus:ring-teal-500 border-gray-300 rounded">
                        </form>
                        <label class="ml-6 text-gray-900">
                            <span :class="checked ? 'line-through text-gray-400' : ''" class="text-lg font-medium">
                                {{ $item->name }}
                            </span>
                            <span class="text-sm font-light text-gray-500 block">{{ isset($item->tanggal) ? $item->tanggal : '' }}</span>
                        </label>
                    </div>
                    <div class="flex space-x-2 ml-12">
                        @if($item->is_done == 0)
                        <form action="{{ route('todo.edit', ['id' => $item->id]) }}" method="POST">
                            @csrf
                            <button type="submit" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                    <path d="M16 5l3 3" />
                                </svg>
                            </button>
                        </form>
                        @endif
                        <form action="{{ route('todo.delete', ['id' => $item->id]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 7l16 0" />
                                    <path d="M10 11l0 6" />
                                    <path d="M14 11l0 6" />
                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                <p class="flex items-center gap-x-1 mt-3">
                    @for ($i = 1; $i <= ($item->priority ?? 0); $i++)
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow-500">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                        </svg>
                        @endfor
                </p>
            </li>
            @endforeach
        </ul>
    </div>


    <!-- Success Alert -->
    @if(session('success'))
    <div x-data="{ isOpen: true }" x-init="setTimeout(() => isOpen = false, 3000)">
        <div
            x-show="isOpen"
            @keydown.escape.window="isOpen = false"
            @click.self="isOpen = false"
            tabindex="-1"
            aria-hidden="true"
            class="overflow-y-auto overflow-x-hidden fixed inset-0 z-50 flex justify-center items-center w-full md:inset-0 h-screen md:h-full bg-black bg-opacity-30"
            x-transition:enter="transition-opacity duration-300 ease-out"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-300 ease-in"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
            <div @click.stop
                class="bg-white rounded-xl shadow-lg p-4 text-center w-48 transition-transform"
                x-transition:enter="transform transition-transform duration-300 ease-out"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transform transition-transform duration-200 ease-in"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95">
                <!-- Icon Success -->
                <div class="bg-green-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-3 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-500 animate-pulse" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 12l5 5l10-10" />
                    </svg>
                </div>

                <!-- Pesan -->
                <h1 class="text-base font-semibold text-green-600">Success</h1>
                <p class="text-gray-500 text-xs mb-3 leading-tight">
                    {{ session('success') }}
                </p>

                <!-- Tombol Continue -->
                <button type="button" @click="isOpen = false"
                    class="bg-green-500 text-white py-1 px-4 rounded-full text-sm hover:bg-green-600 focus:ring focus:ring-green-300 transition">
                    Continue
                </button>
            </div>
        </div>
    </div>
    @endif
</body>
</html>