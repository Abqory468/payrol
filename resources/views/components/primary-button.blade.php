<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-xl font-bold text-sm text-white transition-all duration-200 hover:bg-blue-700 active:scale-[0.98] focus:outline-none focus:ring-4 focus:ring-blue-500/20 shadow-lg shadow-blue-600/20 disabled:opacity-50 disabled:cursor-not-allowed']) }}>
    {{ $slot }}
</button>
