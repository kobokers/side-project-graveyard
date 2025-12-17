<div class="h-full flex flex-col bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700">
    <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-white dark:bg-gray-800 sticky top-0 z-10">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Chats</h2>
    </div>

    <div class="flex-1 overflow-y-auto custom-scrollbar">
        @forelse($conversations as $conversation)
            @php
                $isActive = isset($activeUser) && $activeUser->id === $conversation['other_user']->id;
            @endphp
            <a href="{{ route('messages.show', ['project' => $conversation['project']->id, 'user' => $conversation['other_user']->id]) }}" 
               class="block p-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition relative group {{ $isActive ? 'bg-blue-50 dark:bg-blue-900/30 border-l-4 border-blue-500' : 'border-l-4 border-transparent' }}">
                
                <div class="flex gap-3">
                    <!-- Avatar -->
                    <div class="relative flex-shrink-0">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-sm">
                            {{ strtoupper(substr($conversation['other_user']->name, 0, 1)) }}
                        </div>
                        @if($conversation['unread_count'] > 0)
                            <div class="absolute -top-1 -right-1 w-5 h-5 bg-blue-600 dark:bg-blue-500 rounded-full flex items-center justify-center shadow-md ring-2 ring-white dark:ring-gray-800">
                                <span class="text-[10px] font-bold text-white">{{ $conversation['unread_count'] }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start mb-0.5">
                            <span class="font-semibold text-gray-900 dark:text-gray-100 truncate pr-2 {{ $conversation['unread_count'] > 0 ? 'font-bold' : '' }}">
                                {{ $conversation['other_user']->name }}
                            </span>
                            <span class="text-[11px] text-gray-500 dark:text-gray-400 whitespace-nowrap flex-shrink-0">
                                {{ $conversation['last_message']->created_at->diffForHumans(null, true, true) }}
                            </span>
                        </div>
                        
                        <p class="text-xs text-blue-600 dark:text-blue-400 font-medium mb-0.5 truncate">
                            {{ $conversation['project']->title }}
                        </p>

                        <p class="text-sm text-gray-600 dark:text-gray-400 truncate {{ $conversation['unread_count'] > 0 ? 'font-semibold text-gray-900 dark:text-gray-200' : '' }}">
                            @if($conversation['last_message']->sender_id === auth()->id())
                                <span class="text-gray-400 dark:text-gray-500">You:</span>
                            @endif
                            {{ $conversation['last_message']->message }}
                        </p>
                    </div>
                </div>
            </a>
        @empty
            <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                <p>No conversations yet.</p>
            </div>
        @endforelse
    </div>
</div>
