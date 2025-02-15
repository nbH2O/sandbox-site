<x-layout.admin>
        <form method="POST" enctype="multipart/form-data" class="max-w-full w-[30rem] [&>*]:w-full flex flex-col gap-4">
                {{ csrf_field() }}
                <div>
                        <x-select
                                name="type"
                                placeholder="Type"
                        >
                                <option value="face">Face</option>
                                <option value="hat">Hat</option>
                        </x-select>
                </div>
                <div>
                        <x-input 
                                type="file"
                                name="file"
                        />
                </div>
                <div>
                        <x-input 
                                name="name"
                                placeholder="Name"
                        />
                </div>
                <div>
                        <x-textarea 
                                name="description"
                                placeholder="Description" 
                        />
                </div>
                <div class="flex gap-4">
                        <x-input 
                                name="price"
                                placeholder="Price"
                        />
                        <x-input
                                name="max_copies"
                                placeholder="Max Copies (optional)"
                        />
                </div>
                <div class="flex gap-4 opacity-50">
                        <x-input 
                                placeholder="Available From (optional)"
                        />
                        <x-input
                                placeholder="Available To (optional)"
                        />
                </div>
                <div class="flex gap-4">
                        <x-checkbox 
                                name="is_onsale"
                                label="Is Onsale"
                        />
                        <x-checkbox 
                                name="is_special"
                                label="Is Special"
                        />
                        <x-checkbox 
                                name="is_public"
                                label="Is Public"
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