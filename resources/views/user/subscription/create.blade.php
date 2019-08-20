@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1>{{ __('subscription.New Subscription') }}</h1>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('app.Home') }}</a></li>
            <li class="breadcrumb-item">{{ __('subscription.New Subscription') }}</li>
        </ol>
    </nav>

    <div class="row">
        <form class="col-4" method="post" action="{{ route('user.subscription.store') }}">
            @csrf

            <div class="form-group row">
                <label for="start-date" class="col-sm-4 col-form-label text-md-right">{{ __('subscription.NEW Start date') }}</label>
                <div class="col-md-8">
                    <input type="text" readonly disabled class="form-control-plaintext text-success" id="start-date"
                           value="{{ $startDate->format('d/m/Y') }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="end-date" class="col-sm-4 col-form-label text-md-right">{{ __('subscription.NEW End date') }}</label>
                <div class="col-md-8">
                    <input type="text" readonly disabled class="form-control-plaintext text-success" id="end-date"
                           value="{{ $endDate->format('d/m/Y') }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="selected-type"
                       class="col-sm-4 col-form-label text-md-right">{{ __('app.Subscription type') }}</label>
                <div class="col-md-8">
                    <select id="selected-type" name="type" class="custom-select">
                        @foreach($subscriptionTypes as $subscriptionType)
                            @if ($subscriptionType->id == $actualSubscriptionTypeId)
                                <option selected value="{{ $subscriptionType->id }}"
                                        data-amount="{{ $subscriptionType->amount }}">
                                    {{ __('subscription.'.$subscriptionType->name) }}
                                </option>
                            @else
                                <option value="{{ $subscriptionType->id }}"
                                        data-amount="{{ $subscriptionType->amount }}">
                                    {{ __('subscription.'.$subscriptionType->name) }}
                                </option>

                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="subscription-amount" class="col-sm-4 col-form-label text-md-right">{{ __('app.Price') }}</label>
                <div class="col-md-8">
                    <input type="text" readonly disabled class="form-control-plaintext" id="subscription-amount">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-8 offset-md-4">
                    @include('user.payment.payment')
                    <a href="{{route('user.subscription.pdf')}}" class="btn btn-success"
                       target="_blank">{{__('subscription.Membership PDF')}}</a>
                </div>
            </div>
        </form>
        <div class="col-4 align-self-center font-weight-bold">
            @if ($subscriptionValide === "subscrValide")
                <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('subscription.Subscription Valid :-)') }}</h5>
                        <p class="card-text">{{ __('subscription.Your subscription still cover the current period')}}
                            <br/>{{__('subscription.You don\'t need to renewal it urgently') }}</p>
                    </div>
                </div>
            @elseif ($subscriptionValide === "subscrOutdated")
                <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('subscription.Subscription Outdated :-(') }}</h5>
                        <p class="card-text">{{ __('subscription.Your subscription is outdated')}}
                            <br/>{{__('subscription.Please renewal it use the bellow form.') }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>


    <h2>{{ __('subscription.Subscriptions History') }}</h2>
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">{{ __('subscription.Start Date') }}</th>
            <th scope="col">{{ __('subscription.End Date') }}</th>
            <th scope="col">{{ __('subscription.Type') }}</th>
            <th scope="col">{{ __('subscription.Amount') }}</th>
        </tr>
        </thead>
        <tbody>
        @forelse($user->subscriptions as $subscription)

            <tr>
                <td scope="row">{{$subscription->date_start->format('d/m/Y')}}</td>
                <td>{{ $subscription->date_end->format('d/m/Y') }}</td>
                <td>{{ $subscription->type->name}}</td>
                <td> {{ $subscription->amount}}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4">{{ __('subscription.No subscription yet') }}</td>
            </tr>
        @endforelse

        </tbody>
    </table>

    @push('scripts')
        <script>
            function selectedtype() {
                var amount = $('#selected-type option:selected').data('amount');
                $('#subscription-amount').val(amount + ' €');
            }

            $('#selected-type').change(selectedtype);
            selectedtype();
        </script>
    @endpush

@endsection
