<div class="bg-white p-4 rounded-lg shadow-md max-w-sm mx-auto">
    <div class="flex justify-between items-start">
        <div>
            <p class="text-lg font-semibold">{{ $name }}</p>
            <p class="text-sm text-gray-500">{{ $category }} | {{ $date }}</p>
        </div>
        <div class="flex flex-col items-end space-y-2">
            <div class="flex space-x-2">
                <a href="{{ route('delete-habit', ['id' => $id]) }}" 
                   class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">
                    Delete
                </a>
                <form action="{{ route('timer.start') }}" method="GET" class="flex space-x-2">
                    <input type="hidden" name="name" value="{{ $name }}">
                    <input type="hidden" name="category" value="{{ $category }}">
                    <input type="hidden" name="date" value="{{ $date }}">
                    <button type="submit"
                            class="px-2 py-1 bg-green-500 text-white rounded hover:bg-green-600 transition">
                        START
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
