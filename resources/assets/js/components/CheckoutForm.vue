<template>
     <form action="/purchases" method="POST">
        <input type="hidden" name="stripeToken" v-model="stripeToken">
        <input type="hidden" name="stripeEmail" v-model="stripeEmail">

        <select name="product" v-model="product">
            <option v-for="product in products" :value="product.id">
                {{ product.name }} &mdash; $ {{ product.price / 100}}
            </option>
        </select>

      <button type="submit" @click.prevent="buy">Buy my book</button>
    </form>
</template>

<script>
    export default {
        props: ['products'],
        data() {
            return {
                stripeEmail: '',
                stripeToken: '',
                product: '1'
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

                   axios.post('/purchases', this.$data)
                        .then(response => alert('Complete! Thanks four your payment!'));
                }
            });
        },
        methods: {
            buy() {
                let product = this.findProductById(this.product);
                this.stripe.open({
                    name: product.name,
                    description: product.description,
                    zipCode: false,
                    amount: product.price,
                });
            },

            findProductById(id) {
                return this.products.find(product => product.id == id);
            }
        }
    }
</script>
