<nav class="fixed bottom-0 w-full bg-white dark:bg-surface-dark border-t border-gray-200 dark:border-gray-800 pb-safe pt-2 px-6 flex justify-between items-center z-40 pb-4 md:hidden">

    <a href="{{ route('repertoires.index') }}" 
       class="flex flex-col items-center gap-1 cursor-pointer transition-colors group
       {{ request()->routeIs('repertoires.*') ? 'text-primary' : 'text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300' }}">
        <span class="material-symbols-outlined text-2xl {{ request()->routeIs('repertoires.*') ? 'filled' : '' }}">
            queue_music
        </span>
        <span class="text-[10px] font-medium">Repertórios</span>
    </a>

    <a href="{{ route('songs.index') }}" 
       class="flex flex-col items-center gap-1 cursor-pointer transition-colors group
       {{ request()->routeIs('songs.*') ? 'text-primary' : 'text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300' }}">
        <span class="material-symbols-outlined text-2xl {{ request()->routeIs('songs.*') ? 'filled' : '' }}">
            music_note
        </span>
        <span class="text-[10px] font-medium">Músicas</span>
    </a>

    <a href="#" 
       class="flex flex-col items-center gap-1 cursor-pointer transition-colors group text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300">
        <span class="material-symbols-outlined text-2xl">
            calendar_month
        </span>
        <span class="text-[10px] font-medium">Agenda</span>
    </a>

    <a href="{{ route('profile.index') }}" 
       class="flex flex-col items-center gap-1 cursor-pointer transition-colors group
       {{ request()->routeIs('profile.*') ? 'text-primary' : 'text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300' }}">
        <span class="material-symbols-outlined text-2xl {{ request()->routeIs('profile.*') ? 'filled' : '' }}">
            person
        </span>
        <span class="text-[10px] font-medium">Perfil</span>
    </a>

</nav>