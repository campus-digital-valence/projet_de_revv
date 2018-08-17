
<form action="{{ route('user.payment.charge') }}" method="POST">
    @csrf
    <script
            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
            data-key="{{ env('STRIPE_PUB_KEY') }}"
            data-amount="1999"
            data-name="Subscription"
            data-description="Online subscription about REVV Org."
            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
            data-locale="auto"
            data-currency="eur">
    </script>
</form>