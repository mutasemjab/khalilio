@extends('layouts.admin')

@section('title', __('messages.Users'))

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1 font-weight-bold">{{ __('messages.Users') }}</h4>
            <p class="text-muted mb-0 small">{{ __('messages.Users') }} ({{ $users->total() }})</p>
        </div>
    </div>

    {{-- Filter Form --}}
    <div class="card border-0 shadow-sm rounded-lg mb-4">
        <div class="card-body py-3">
            <form method="GET" action="{{ route('users.index') }}" class="form-inline flex-wrap" style="gap:10px">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       class="form-control form-control-sm"
                       placeholder="{{ __('messages.Name') }} / {{ __('messages.Phone') }} / {{ __('messages.School Name') }}"
                       style="min-width:220px">

                <select name="generation" class="form-control form-control-sm" style="min-width:140px">
                    <option value="">-- {{ __('messages.Generation') ?? 'الجيل' }} --</option>
                    <option value="2008" {{ request('generation') == '2008' ? 'selected' : '' }}>2008</option>
                    <option value="2009" {{ request('generation') == '2009' ? 'selected' : '' }}>2009</option>
                    <option value="2010" {{ request('generation') == '2010' ? 'selected' : '' }}>2010</option>
                </select>

                <button type="submit" class="btn btn-primary btn-sm px-4">
                    <i class="fas fa-filter mr-1"></i> {{ __('messages.filter') ?? 'فلتر' }}
                </button>
                @if(request()->hasAny(['search','generation']))
                    <a href="{{ route('users.index') }}" class="btn btn-light btn-sm px-3">
                        <i class="fas fa-times mr-1"></i> {{ __('messages.clear') ?? 'مسح' }}
                    </a>
                @endif
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded-lg">
                <div class="card-body p-0">
                    @if($users->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.ID') }}</th>
                                        <th>{{ __('messages.Name') }}</th>
                                        <th>{{ __('messages.Phone') }}</th>
                                        <th>{{ __('messages.School Name') }}</th>
                                        <th>{{ __('messages.Generation') ?? 'الجيل' }}</th>
                                        <th>{{ __('messages.Arabic Grade') }}</th>
                                        <th>{{ __('messages.Math Grade') }}</th>
                                        <th>{{ __('messages.Jordan History Grade') }}</th>
                                        <th>{{ __('messages.Islamic Education Grade') }}</th>
                                        <th>{{ __('messages.Average') }}</th>
                                        <th>{{ __('messages.Created At') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->phone }}</td>
                                            <td>{{ $user->school_name }}</td>
                                            <td>
                                                @if($user->generation)
                                                    <span class="badge" style="background:rgba(102,126,234,0.15);color:#667eea;font-size:12px;padding:5px 10px;border-radius:20px">
                                                        {{ $user->generation }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($user->arabic_grade)
                                                    <span class="badge badge-primary">{{ $user->arabic_grade }}</span>
                                                @else
                                                    <span class="text-muted">{{ __('messages.Not Set') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($user->math_grade)
                                                    <span class="badge badge-success">{{ $user->math_grade }}</span>
                                                @else
                                                    <span class="text-muted">{{ __('messages.Not Set') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($user->jordan_history_grade)
                                                    <span class="badge badge-info">{{ $user->jordan_history_grade }}</span>
                                                @else
                                                    <span class="text-muted">{{ __('messages.Not Set') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($user->islamic_education_grade)
                                                    <span class="badge badge-warning">{{ $user->islamic_education_grade }}</span>
                                                @else
                                                    <span class="text-muted">{{ __('messages.Not Set') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($user->average)
                                                    <strong class="text-primary">{{ number_format($user->average, 2) }}</strong>
                                                @else
                                                    <span class="text-muted">{{ __('messages.Not Calculated') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-muted small">{{ $user->created_at->format('Y-m-d H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center py-3">
                            {{ $users->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">{{ __('messages.No Users Found') }}</h5>
                            <p class="text-muted">{{ __('messages.No users have been registered yet') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
