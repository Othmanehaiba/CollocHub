<x-app-layout>
    <div class="max-w-2xl mx-auto p-6">
        <div class="bg-white rounded-xl shadow p-6 border border-gray-200">
            <h1 class="text-2xl font-bold text-gray-900 mb-3">
                Répondre à l'invitation
            </h1>

            <p class="text-gray-600 mb-2">
                Vous avez été invité à rejoindre la colocation
                <span class="font-semibold text-gray-900">{{ $invitation->colocation->name }}</span>.
            </p>

            <p class="text-sm text-gray-500 mb-6">
                Email invité : {{ $invitation->email }}
            </p>

            <div class="flex gap-3">
                <form method="POST" action="{{ route('invitations.accept', $invitation->token) }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                        Accepter
                    </button>
                </form>

                <form method="POST" action="{{ route('invitations.refuse', $invitation->token) }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                        Refuser
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>