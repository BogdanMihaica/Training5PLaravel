<a {{ $attributes->merge(['class' => 
    'flex justify-center items-center text-zinc-200 px-4 py-2 min-w-20 first:ml-5 
    font-arial cursor-pointer rounded-lg hover:bg-slate-800'
]) }}>
    {{ $slot }}
</a>
