<div class="my-md">
    <svg class="relative left-0 stroke-slate-300 mb-6 mx-auto w-full h-1">
        <line x1="0" y1="0" x2="100%" y2="0" style="stroke-width:2"/>
    </svg>
    <div class="flex flex-col md:flex-row space-y-sm md:justify-between md:items-baseline px-md ">
        <div
            class="grid grid-cols-2 gap-4 justify-items-center md:flex md:flex-row md:space-x-7 md:justify-center md:flex-wrap text-sm">
            <span>
                Programmiert mit ♥ vom Simon
            </span>
            <a
                href="https://github.com/smnmsr/de-simon-wird-driisgi"
                target="_blank"
            >
                Quellcode
            </a>
            @if(auth()->check() && auth()->user()->id === 1)
                <a
                    href="{{ route('admin.dashboard') }}"
                >
                    Admin
                </a>
            @endif
        </div>
    </div>
</div>
