<template>
     <form action="/purchases" method="POST">

        <input type="hidden" name="stripeToken" v-model="stripeToken">
        <input type="hidden" name="stripeEmail" v-model="stripeEmail">

      <button type="submit" @click.prevent="buy">Buy my book</button>
    </form>
</template>

<script>
    export default {
        data() {
            return {
                stripeEmail: '',
                stripeToken: ''
            };
        },
        created () {
            this.stripe = StripeCheckout.configure({
                key: Laracasts.stripeKey,
                image: "https://stripe.com/img/documentation/checkout/marketplace.png",
                locale: "auto",
                token: (token) => {
                    this.stripeToken = token.id;
                    this.stripeEmail = token.email;
                    /*document.querySelector('#stripeEmail').value = token.email;
                    document.querySelector('#stripeToken').value = token.id;

                    document.querySelector('#checkout-form').submit();*/



                   this.axios.post('/purchases', this.$data)
                        .then(response => alert('Compelte! Thanks four your payment!'));
                }
            });
        },
        methods: {
            buy() {
                this.stripe.open({
                    name: 'My Book',
                    description: 'Some details about the book.',
                    zipCode: false,
                    amount: 2500,
                });
            }
        }
    }
</script>
