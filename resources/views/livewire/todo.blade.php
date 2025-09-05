<!-- resources/views/livewire/todo.blade.php -->
<div class="container mx-auto p-4 max-w-4xl">
    <h1 class="text-2xl font-bold mb-6 text-center">Livewire To-Do App</h1>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <!-- Add Todo Form -->
    <div class="mb-8 bg-white p-6 rounded-lg shadow">
        @if (!$editMode)
            <form wire:submit.prevent="addTodo">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="task" class="block text-sm font-medium text-gray-700">Task *</label>
                        <input
                            type="text"
                            id="task"
                            wire:model="task"
                            placeholder="What needs to be done?"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        >
                        @error('task') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
                        <select
                            id="priority"
                            wire:model="priority"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        >
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                        </select>
                        @error('priority') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea
                        id="description"
                        wire:model="description"
                        placeholder="Additional details..."
                        rows="3"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    ></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
                        <input
                            type="date"
                            id="due_date"
                            wire:model="due_date"
                            min="{{ date('Y-m-d') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        >
                        @error('due_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-end">
                        <button
                            type="submit"
                            class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        >
                            Add Task
                        </button>
                    </div>
                </div>
            </form>
        @else
            <form wire:submit.prevent="updateTodo">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="editTask" class="block text-sm font-medium text-gray-700">Task *</label>
                        <input
                            type="text"
                            id="editTask"
                            wire:model="editTask"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        >
                        @error('editTask') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="editPriority" class="block text-sm font-medium text-gray-700">Priority</label>
                        <select
                            id="editPriority"
                            wire:model="editPriority"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        >
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                        </select>
                        @error('editPriority') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="editDescription" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea
                        id="editDescription"
                        wire:model="editDescription"
                        rows="3"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    ></textarea>
                    @error('editDescription') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="editDueDate" class="block text-sm font-medium text-gray-700">Due Date</label>
                        <input
                            type="date"
                            id="editDueDate"
                            wire:model="editDueDate"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        >
                        @error('editDueDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-end space-x-2">
                        <button
                            type="submit"
                            class="flex-1 bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                        >
                            Update
                        </button>
                        <button
                            type="button"
                            wire:click="cancelEdit"
                            class="flex-1 bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                        >
                            Cancel
                        </button>
                    </div>
                </div>
            </form>
        @endif
    </div>

    <!-- Todo List -->
    @if ($todos->count() > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="grid grid-cols-12 bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700">
                <div class="col-span-1">Status</div>
                <div class="col-span-4">Task</div>
                <div class="col-span-2">Priority</div>
                <div class="col-span-2">Due Date</div>
                <div class="col-span-3 text-center">Actions</div>
            </div>

            @foreach ($todos as $todo)
                <div class="grid grid-cols-12 border-b border-gray-200 px-4 py-3 hover:bg-gray-50 items-center">
                    <!-- Status -->
                    <div class="col-span-1">
                        <input
                            type="checkbox"
                            wire:click="toggleCompletion({{ $todo->id }})"
                            {{ $todo->completed ? 'checked' : '' }}
                            class="h-5 w-5 text-blue-500 rounded focus:ring-blue-400"
                        >
                    </div>

                    <!-- Task -->
                    <div class="col-span-4">
                        <div class="{{ $todo->completed ? 'line-through text-gray-400' : 'text-gray-700' }}">
                            {{ $todo->task }}
                        </div>
                        @if ($todo->description)
                            <div class="text-sm text-gray-500 mt-1">
                                {{ Str::limit($todo->description, 50) }}
                            </div>
                        @endif
                    </div>

                    <!-- Priority -->
                    <div class="col-span-2">
                        @php
                            $priorityColors = [
                                'low' => 'bg-green-100 text-green-800',
                                'medium' => 'bg-yellow-100 text-yellow-800',
                                'high' => 'bg-red-100 text-red-800',
                            ];
                        @endphp
                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $priorityColors[$todo->priority] }}">
                            {{ ucfirst($todo->priority) }}
                        </span>
                    </div>

                    <!-- Due Date -->
                    <div class="col-span-2">
                        @if ($todo->due_date)
                            @php
                                $isOverdue = !$todo->completed && $todo->due_date->isPast();
                            @endphp
                            <span class="{{ $isOverdue ? 'text-red-600 font-medium' : 'text-gray-600' }}">
                                {{ $todo->due_date->format('M j, Y') }}
                                @if ($isOverdue)
                                    <span class="text-xs text-red-500">(Overdue)</span>
                                @endif
                            </span>
                        @else
                            <span class="text-gray-400">No due date</span>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="col-span-3 flex justify-center space-x-2">
                        <button
                            wire:click="editTodo({{ $todo->id }})"
                            class="text-blue-500 hover:text-blue-700 focus:outline-none"
                            title="Edit"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                        <button
                            wire:click="deleteTodo({{ $todo->id }})"
                            class="text-red-500 hover:text-red-700 focus:outline-none"
                            onclick="return confirm('Are you sure you want to delete this task?') || event.stopImmediatePropagation()"
                            title="Delete"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 text-sm text-gray-500">
            {{ $todos->where('completed', false)->count() }} items left
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-6 text-center text-gray-500">
            No tasks yet. Add one above!
        </div>
    @endif
</div>
