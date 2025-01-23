<div>
    @foreach ($posts as $post)
    <div class="card shadow-none bg-label-primary h-auto mb-3">
        <div class="card-body d-flex justify-content-between flex-wrap-reverse">
            <div class="mb-0 w-100 app-academy-sm-60 d-flex flex-column justify-content-between text-center text-sm-start">
                <div class="card-title">
                    <h5 class="text-primary mb-0">{{ $post->title }}</h5>
                    <span class="text-muted small"> {{ $post->category->name }} | Created by <span class="fw-bold">{{ \App\Models\User::find($post->created_by)->name }}</span> | {{ $post->updated_at->diffForHumans() }}</span>
                    <p class="text-body mt-2">
                        {{ $post->body }}
                    </p>
                </div>
                <div class="mb-0"><button class="btn btn-sm btn-primary waves-effect waves-light">View Programs</button></div>
            </div>
        </div>
    </div>
    @endforeach
</div>