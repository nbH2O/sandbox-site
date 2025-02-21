<x-layout.admin>
        @if ($info)
            <h5 class="mb-2">Remove mainteanance or update below</h5>
            <div class="bg-header p-2 relative mb-4">
                <code>
                    @php 
                        echo 
                        nl2br(json_encode($info->toArray(), JSON_PRETTY_PRINT)) 
                    @endphp
                </code>
                <form method="POST">
                    @method('DELETE')
                    @csrf
                    <x-button color="red" class="absolute bottom-0 right-0 m-2">Remove</x-button>
                </form>
            </div>
        @endif
        <form method="POST" class="max-w-full w-[30rem] [&>*]:w-full flex flex-col gap-4">
                @csrf
                <div>
                    <x-input
                        name="message"
                        placeholder="Message (optional)"
                        class="w-full"
                    />
                </div>
                <div>
                    <x-input
                        name="min_power"
                        type="number"
                        placeholder="Minimum Power (for bypass) (optional)"
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