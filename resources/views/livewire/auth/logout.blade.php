<!-- <div>
    <a class="btn btn-sm btn-danger d-flex" wire:click="logout">
        <small class="align-middle text-white">Logout Coy</small>
        <i class="ti ti-logout ms-2 ti-14px text-white"></i>
    </a>
</div> -->
<!-- Authentication -->
<form method="POST" action="{{ route('logout') }}" x-data>
    @csrf
    <button type="submit" class="btn btn-sm btn-danger d-flex">{{ __('Log Out') }}</button>
</form>