<div x-data="{ modalOpen: @entangle('modalOpen') }" class="relative">
    <div>
        <button wire:click="refreshNotifications" @click="modalOpen = true"
            class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-700 transition">
            📩 Notificações ({{ count($notifications) }})
        </button>
    </div>

    <div x-show="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-gray-900 bg-opacity-50" x-cloak>
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 sm:mx-auto flex flex-col h-[90vh]">
          <div class="p-4 border-b flex-shrink-0">
            <div class="flex justify-between items-center">
              <h2 class="text-xl font-bold text-gray-800">🔔 Notificações</h2>
              <button @click="modalOpen = false" class="text-gray-500 hover:text-gray-700 text-2xl">
                &times;
              </button>
            </div>
          </div>
      
          <div class="p-4 flex-1 overflow-y-auto">
            @if ($notifications->isEmpty())
              <div class="text-center text-gray-500 py-4">
                📭 Nenhuma nova notificação.
              </div>
            @else
              <ul class="space-y-2">
                @foreach ($notifications as $notification)
                  <li class="p-3 bg-gray-100 rounded-lg shadow-sm border-l-4 border-blue-500">
                    <p class="text-lg font-semibold text-gray-700">
                      {{ $notification->data['title'] ?? 'Notificação sem mensagem' }}
                    </p>
                    <p class="text-sm text-gray-700">
                      {{ $notification->data['message'] ?? 'Notificação sem mensagem' }}
                    </p>
                    <p class="text-xs text-gray-500">
                      {{ $notification->created_at->diffForHumans() }}
                    </p>
                  </li>
                @endforeach
              </ul>
            @endif
          </div>
      
          <div class="p-4 border-t flex-shrink-0">
            <div class="flex justify-end space-x-2">
              <button @click="modalOpen = false" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 transition">
                Fechar
              </button>
              <button wire:click="markAsRead" class="bg-blue-600 text-white px-4 py-2 rounded shadow-md hover:bg-blue-700 transition">
                ✅ Marcar como lidas
              </button>
            </div>
          </div>
        </div>
      </div>
      
      
    
    
    
</div>
