<x-layout title="Users">
    <div class="row" id="wrapper">
        @foreach($users as $user)
        <div class="col-md-4">
            <div class="card card-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-warning">
                    <div class="widget-user-image">
                        <img class="img-circle" style="width: 70px; height: 70px;" src="{{ $user->photo }}" alt="User Avatar">
                    </div>
                    <h3 class="widget-user-username">{{ $user->name }}</h3>
                    <h5 class="widget-user-desc">{{ $user->position->name }}</h5>
                </div>
                <div class="card-footer p-0">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <span class="nav-link">
                                Phone <span class="float-right badge bg-primary">{{ $user->phone }}</span>
                            </span>
                        </li>
                        <li class="nav-item">
                            <p class="nav-link">
                                Email <span class="float-right badge bg-primary">{{ $user->email }}</span>
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    {{ $users->links() }}
</x-layout>
