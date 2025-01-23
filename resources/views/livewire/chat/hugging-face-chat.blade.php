<div class="mt-4">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Ask a Question</h5>
            <div x-data="{ loading: false }">
                <form wire:submit.prevent="getChatCompletion" x-on:submit="loading = true">
                    <input type="text" wire:model="message" placeholder="Enter your question" class="form-control" x-bind:disabled="loading" />
                </form>
                <button class="btn btn-primary btn-sm mt-2" x-on:click="loading = true, $wire.getChatCompletion()" x-bind:disabled="loading">
                    <span x-show="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    <span x-on:ask-reload.window="loading = false">
                        <span x-show="!loading">Ask</span>
                    </span>
                </button>
            </div>
            @if ($response)
            <div class="mt-3">
                <h6>Response:</h6>
                <p id="responseText" class="card-text bg-info p-2 text-white rounded shadow mb-0 w-100 h-auto overflow-hidden break-all">{{ $response }}</p>
                <div class="mt-2">
                    <button class="btn btn-info btn-sm" @click="copyTextToClipboard('#responseText')">Copy</button>
                </div>
            </div>
            @endif
        </div>
    </div>
    <script>
        function copyTextToClipboard(selector) {
            const element = document.querySelector(selector);
            const textToCopy = element.textContent || element.innerText;
            navigator.clipboard.writeText(textToCopy).then(function() {
                alert('Response copied to clipboard!');
            }).catch(function(error) {
                console.error('Error copying text: ', error);
                alert('Failed to copy text.');
            });
        }
    </script>
</div>