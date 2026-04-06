<x-app-layout>
    <x-slot name="header">
        <h2>Add Scholarship</h2>
    </x-slot>

    <div style="max-width:600px; margin:50px auto;">

        @if($errors->any())
        <div style="color:red;">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.scholarships.store') }}">
            @csrf

            <input type="text" name="name" placeholder="Name" style="width:100%; margin-bottom:10px;"><br>

            <textarea name="description" placeholder="Description" style="width:100%; margin-bottom:10px;"></textarea><br>

            <button type="submit">Save</button>
        </form>

    </div>
</x-app-layout>