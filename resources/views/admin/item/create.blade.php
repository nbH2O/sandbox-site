<x-layout.admin>
        <form method="POST" enctype="multipart/form-data" class="max-w-full w-[30rem] [&>*]:w-full flex flex-col gap-4">
                {{ csrf_field() }}
                <div>
                        <x-select
                                name="type_id"
                                placeholder="Type"
                        >
                                @foreach (config('site.item_types') as $key => $val)
                                        @if ($val == 'face' || $val == 'hat')
                                                <option value="{{ $key }}">{{ $val }}</option>
                                        @endif
                                @endforeach
                        </x-select>
                </div>
                <div>
                        <p>Faces can be PNG | Hats can be GLB</p>
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
                <div>
                        <p class="text-muted">Aviilable from-to (universal standard time) (optional)</p>
                        <div class="flex gap-4">
                                <x-input 
                                        type="datetime-local"
                                        name="available_from"
                                        placeholder="Available From (optional)"
                                />
                                <x-input
                                        type="datetime-local"
                                        name="available_to"
                                        placeholder="Available To (optional)"
                                />
                        </div>
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