<x-layout.admin>
        <form class="max-w-full w-[30rem] [&>*]:w-full flex flex-col gap-4">
                <div>
                        <x-select
                                placeholder="Type"
                        >
                                <option value="face">Face</option>
                                <option value="hat">Hat</option>
                        </x-select>
                </div>
                <div>
                        <x-input placeholder="Name" />
                </div>
                <div>
                        <x-textarea 
                                placeholder="Description" 
                        />
                </div>
                <div class="flex gap-4">
                        <x-input 
                                placeholder="Price"
                        />
                        <x-input
                                placeholder="Max Copies (optional)"
                        />
                </div>
                <div class="flex gap-4">
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
</x-layout.admin>