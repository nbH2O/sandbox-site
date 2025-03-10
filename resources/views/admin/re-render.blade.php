<x-layout.admin>
        <form method="POST" class="max-w-full w-[30rem] [&>*]:w-full flex flex-col gap-4">
                @csrf
                <div>
                    <x-select
                        name="subject_type"
                        class="w-full"
                    >
                        <option value="item">item</option>
                        <option value="user">user</option>
                    </x-select>
                    <x-input
                        placeholder="id"
                        type="number"
                        name="subject_id"
                        class="w-full"
                    />
                </div>
                
                <x-button color="green">Submit</x-button>
        </form>
        @if ($errors->any())
        <div class="alert alert-danger">
                <ul>
                @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                @endforeach
                </ul>
        </div>
        @endif
</x-layout.admin>