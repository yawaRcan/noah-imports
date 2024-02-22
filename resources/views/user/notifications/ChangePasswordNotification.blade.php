<a href="{{route('user.account.profile.view')}}" data-notification-id="{{$notification->id}}" class="ni-notification-click-read message-item d-flex align-items-center border-bottom px-3 py-2">
    <span class="btn btn-light-danger text-danger btn-circle">
        <i data-feather="link" class="feather-sm fill-white"></i>
    </span>
    <div class="w-75 d-inline-block v-middle ps-3">
        <h5 class="message-title mb-0 mt-1 fs-3 fw-bold">Password changed by {{$notification->notifiable->first_name}}</h5> <span class="fs-2 text-nowrap d-block time text-truncate fw-normal text-muted mt-1"></span> <span class="fs-2 text-nowrap d-block subtext text-muted">{{$notification->created_at}}</span>
    </div>
</a>